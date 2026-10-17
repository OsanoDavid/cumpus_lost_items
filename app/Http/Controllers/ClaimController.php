<?php

namespace App\Http\Controllers;

use App\Models\Claim;
use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClaimController extends Controller
{
    // Store the claim submission along with deeper personal and student verification info
    public function store(Request $request, Item $item)
    {
        // Ensure a user cannot claim their own reported item
        if ($item->user_id === Auth::id()) {
            return back()->with('error', 'You cannot claim an item you reported yourself.');
        }

        // Validate the deep personal information and timeline required for claiming
        $validated = $request->validate([
            'student_registration_number' => 'required|string|max:255',
            'phone_number'                => 'required|string|max:20',
            'claimed_loss_date'           => 'required|date',
            'claimed_location'            => 'nullable|string|max:255',
            'proof_details'               => 'required|string|min:5', // Evidence answering secret identifiers or ownership proof
        ]);

        // Automated Fraud Detection & Timeline Verification ("Red Claim" detection)
        $isSuspicious = false;
        $flagReasons = [];

        $claimedDate = \Carbon\Carbon::parse($validated['claimed_loss_date'])->startOfDay();
        $today = now()->startOfDay();

        // Check 1: Future loss date
        if ($claimedDate->isAfter($today)) {
            $isSuspicious = true;
            $flagReasons[] = "FUTURE LOSS DATE: Claimant stated they lost the item on " . $claimedDate->format('M d, Y') . ", which is a future date.";
        }

        // Check 2: Timeline Contradiction (Lost date is AFTER item was already found)
        if ($item->status === 'found') {
            $itemFoundDate = $item->date_lost_found 
                ? \Carbon\Carbon::parse($item->date_lost_found)->startOfDay() 
                : $item->created_at->startOfDay();

            if ($claimedDate->isAfter($itemFoundDate)) {
                $isSuspicious = true;
                $flagReasons[] = "TIMELINE CONTRADICTION (FRAUD ALERT): Claimant states they lost the item on " . $claimedDate->format('M d, Y') . ", but this item was already recovered and logged into security on " . $itemFoundDate->format('M d, Y') . ". An item cannot be found before it was lost!";
            }
        }

        // Check 3: Repeat suspicious claimant history
        $priorSuspiciousCount = Claim::where('user_id', Auth::id())
            ->where('is_suspicious', true)
            ->count();
        if ($priorSuspiciousCount > 0) {
            $isSuspicious = true;
            $flagReasons[] = "ACCOUNT AUDIT: Claimant has {$priorSuspiciousCount} previous claim(s) flagged for contradictory details.";
        }

        // Save the claim with automated fraud flags (visible only to Administrators)
        Claim::create([
            'item_id'                     => $item->id,
            'user_id'                     => Auth::id(),
            'student_registration_number' => $validated['student_registration_number'],
            'phone_number'                => $validated['phone_number'],
            'claimed_loss_date'           => $validated['claimed_loss_date'],
            'claimed_location'            => $validated['claimed_location'] ?? null,
            'proof_details'               => $validated['proof_details'],
            'is_suspicious'               => $isSuspicious,
            'flag_reason'                 => !empty($flagReasons) ? implode("\n", $flagReasons) : null,
            'claim_status'                => 'pending', // Awaiting admin review
        ]);

        return redirect()->route('items.show', $item->id)->with('success', 'Your ownership claim and verification details have been submitted successfully. Campus Security and Administration will review your credentials.');
    }
}