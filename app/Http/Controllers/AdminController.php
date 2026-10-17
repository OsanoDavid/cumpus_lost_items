<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\User;
use App\Models\Claim;
use App\Models\UserMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function index()
    {
        $items = Item::latest()->paginate(10);
        $users = User::latest()->paginate(10);
        $claims = Claim::with(['item', 'user'])->latest()->paginate(10);

        return view('admin.dashboard', compact('items', 'users', 'claims'));
    }

    public function destroyItem(Item $item)
    {
        $item->delete();
        return back()->with('success', 'Item deleted by admin.');
    }

    public function resolveItem(Item $item)
    {
        $item->update(['is_resolved' => 1]);
        return back()->with('success', 'Item marked as resolved.');
    }

    /**
     * Approve a claim and notify the claimant.
     */
    public function approveClaim(Claim $claim)
    {
        $claim->update(['claim_status' => 'approved']);

        if ($claim->item) {
            $claim->item->update(['is_resolved' => 1]);
        }

        // Send in-app notification to student
        if ($claim->user_id) {
            $itemName = $claim->item ? $claim->item->title : 'your item';
            UserMessage::create([
                'from_user_id' => Auth::id(),
                'to_user_id'   => $claim->user_id,
                'claim_id'     => $claim->id,
                'subject'      => '✅ Claim Approved — Come Collect Your Property',
                'body'         => "Dear student,\n\nGreat news! Your ownership claim for \"" . $itemName . "\" has been reviewed and APPROVED by Campus Security.\n\nPlease visit the Main Administration Block Security Desk at your earliest convenience with your Student ID card to collect your property.\n\nThank you,\nKisii University Campus Security Desk\n+254 58 2030161",
            ]);
        }

        return back()->with('success', 'Claim approved! Student has been notified to visit the Security Desk.');
    }

    /**
     * Reject a claim and notify the claimant with the reason.
     */
    public function rejectClaim(Request $request, Claim $claim)
    {
        $notes = $request->input('admin_notes', 'Your claim could not be verified. Please visit Campus Security with additional proof.');

        $claim->update([
            'claim_status' => 'rejected',
            'admin_notes'  => $notes,
        ]);

        // Send in-app notification to student
        if ($claim->user_id) {
            $itemName = $claim->item ? $claim->item->title : 'the item';
            UserMessage::create([
                'from_user_id' => Auth::id(),
                'to_user_id'   => $claim->user_id,
                'claim_id'     => $claim->id,
                'subject'      => '❌ Claim Denied — Ownership Could Not Be Verified',
                'body'         => "Dear student,\n\nAfter careful review, your ownership claim for \"" . $itemName . "\" has been DENIED by Campus Security.\n\nReason: " . $notes . "\n\nIf you believe this is an error, please visit the Main Administration Block Security Desk in person with your Student ID and any additional evidence of ownership.\n\nKisii University Campus Security Desk\n+254 58 2030161",
            ]);
        }

        return back()->with('success', 'Claim rejected. Student has been notified of the decision.');
    }

    /**
     * Admin sends a direct message to a student.
     */
    public function sendMessage(Request $request)
    {
        $request->validate([
            'to_user_id' => 'required|exists:users,id',
            'subject'    => 'nullable|string|max:255',
            'body'       => 'required|string|min:5',
            'claim_id'   => 'nullable|exists:claims,id',
        ]);

        UserMessage::create([
            'from_user_id' => Auth::id(),
            'to_user_id'   => $request->to_user_id,
            'subject'      => $request->input('subject', 'Message from Campus Security Administration'),
            'body'         => $request->body,
            'claim_id'     => $request->claim_id,
        ]);

        return back()->with('success', 'Message sent to student successfully.');
    }

    /**
     * Mark a user message as read (called when student opens it).
     */
    public function markMessageRead(UserMessage $message)
    {
        // Only the recipient can mark it read
        if ($message->to_user_id === Auth::id()) {
            $message->update(['is_read' => true]);
        }
        return back();
    }
}