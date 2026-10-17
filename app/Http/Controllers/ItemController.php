<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ItemController extends Controller
{
    /**
     * Display list of lost and found items.
     * Rule: Regular users can ONLY view items matching what they are searching for (e.g., Laptops only, not IDs).
     * Only the Administrator can view ALL items across the entire campus.
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $isAdmin = (bool) ($user && $user->is_admin);

        $query = Item::query();

        // Specific category mapping helper
        $searchIntent = $user ? ($user->what_searching ?: $user->what_lost) : null;

        // Non-admin restriction: regular users CANNOT view all items
        if (!$isAdmin) {
            if ($searchIntent) {
                $query->forSearchIntent($searchIntent);
            } else {
                // If regular user has no search intent specified, only show their own items unless actively searching
                if (!$request->filled('search')) {
                    $query->where('user_id', $user->id);
                }
            }
        }

        // Search by keyword (title, description, category, location)
        if ($request->filled('search')) {
            $search = trim($request->input('search'));
            if ($search !== '') {
                $query->where(function ($q) use ($search) {
                    $q->where('title', 'like', "%{$search}%")
                      ->orWhere('description', 'like', "%{$search}%")
                      ->orWhere('category', 'like', "%{$search}%")
                      ->orWhere('location', 'like', "%{$search}%");
                });
            }
        }

        // Filter by status (lost or found)
        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        // Filter by category
        if ($request->filled('category')) {
            $cat = $request->input('category');
            if ($isAdmin) {
                $query->where('category', $cat);
            } else {
                // Regular users can only filter within their allowed scope
                $query->where('category', $cat);
            }
        }

        $items = $query->latest()->paginate(10)->withQueryString();

        return view('items.index', compact('items', 'isAdmin', 'searchIntent'));
    }

    // Show form to report a lost or found item (Publicly accessible without account)
    public function create()
    {
        return view('items.create');
    }

    /**
     * Store reported item with image evidence.
     * Can be posted WITHOUT an account (guest), but must provide contact details like phone number.
     */
    public function store(Request $request)
    {
        $isGuest = !Auth::check();

        $validationRules = [
            'title'             => 'required|string|max:255',
            'description'       => 'required|string',
            'status'            => 'required|in:lost,found',
            'category'          => 'required|string',
            'location'          => 'required|string',
            'date_lost_found'   => 'nullable|date',
            'image'             => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'secret_identifier' => 'nullable|string|max:255',
            'is_anonymous'      => 'nullable|boolean',
        ];

        // If posting without account or posting anonymously, phone number is MANDATORY so person can be reached
        if ($isGuest || $request->has('is_anonymous') || $request->filled('contact_phone')) {
            $validationRules['contact_phone'] = [
                'required',
                'string',
                'max:10',
                'regex:/^[0-9]{10}$/',
            ];
            $validationRules['contact_name'] = $isGuest ? 'required|string|max:255' : 'nullable|string|max:255';
        }

        $validationMessages = [
            'contact_phone.required' => 'Please provide your 10-digit phone number so Campus Security or the owner can contact you to retrieve the item.',
            'contact_phone.max'      => 'Phone number must not exceed 10 digits (e.g., 0712345678).',
            'contact_phone.regex'    => 'Phone number must be a valid 10-digit phone number (e.g., 0712345678).',
            'contact_name.required'  => 'Please provide your name so we know who to address when contacting you.',
        ];

        $validated = $request->validate($validationRules, $validationMessages);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('items', 'public');
        }

        // Contact info resolution
        $contactPhone = $request->input('contact_phone', Auth::check() ? Auth::user()->phone : null);
        $contactName  = $request->input('contact_name', Auth::check() ? Auth::user()->name : 'Anonymous Reporter');

        $newItem = Item::create([
            'user_id'           => ($isGuest || $request->has('is_anonymous')) ? null : Auth::id(),
            'title'             => $validated['title'],
            'description'       => $validated['description'],
            'status'            => $validated['status'],
            'category'          => $validated['category'],
            'location'          => $validated['location'],
            'date_lost_found'   => $validated['date_lost_found'] ?? now()->toDateString(),
            'contact_phone'     => $contactPhone,
            'contact_name'      => $contactName,
            'image_path'        => $imagePath,
            'secret_identifier' => $request->input('secret_identifier'),
            'is_resolved'       => 0,
            'is_anonymous'      => ($isGuest || $request->has('is_anonymous')) ? 1 : 0,
        ]);

        // If reported as a LOST item, execute intelligent scanning of all found items from that date forward
        if ($validated['status'] === 'lost') {
            $matches = Item::findMatchesForLostItem($newItem);
            $matchCount = $matches->count();

            if ($isGuest) {
                return redirect()->route('items.index', ['status' => 'found', 'category' => $newItem->category])
                    ->with('success', "Your lost item report was submitted successfully! Campus Security has your phone number ({$contactPhone}). We scanned database from " . ($newItem->date_lost_found ?? 'today') . " forward: {$matchCount} potential found match(es) located on campus.");
            }

            $successMsg = $matchCount > 0
                ? "Your lost item was reported successfully! System scanned all found items from " . ($newItem->date_lost_found ?? 'today') . " to today and detected {$matchCount} potential match(es). You can inspect and claim them directly from your dashboard below."
                : "Your lost item report was submitted successfully! No matching found items yet, but your dashboard will automatically monitor and alert you if an item with your credentials is surrendered.";

            return redirect()->route('dashboard.seeker')
                ->with('success', $successMsg)
                ->with('new_reported_lost_id', $newItem->id)
                ->with('matched_count', $matchCount);
        }

        // If reported as a FOUND item
        if ($isGuest) {
            return redirect('/')->with('success', 'Thank you! Your found item report was submitted successfully. Campus Security has your phone number on record for retrieval.');
        }

        return redirect()->route('dashboard.finder')
            ->with('success', 'Found item surrendered/reported successfully! The community and potential owners can now view and submit claims.');
    }

    // View single item details
    public function show(Item $item)
    {
        return view('items.show', compact('item'));
    }
}