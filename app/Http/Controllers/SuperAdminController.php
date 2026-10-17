<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class SuperAdminController extends Controller
{
    /**
     * Display a listing of administrators and user promotion candidates.
     */
    public function index(Request $request)
    {
        $search = $request->query('search');

        $admins = User::where(function ($query) {
            $query->where('is_admin', true)
                  ->orWhere('is_super_admin', true);
        })
        ->when($search, function ($query, $search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            });
        })
        ->orderByDesc('is_super_admin')
        ->latest()
        ->paginate(15, ['*'], 'admins_page');

        $candidates = User::where('is_admin', false)
            ->where('is_super_admin', false)
            ->when($search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                      ->orWhere('email', 'like', "%{$search}%")
                      ->orWhere('reg_number', 'like', "%{$search}%");
                });
            })
            ->latest()
            ->paginate(10, ['*'], 'candidates_page');

        return view('admin.administrators', compact('admins', 'candidates', 'search'));
    }

    /**
     * Show form to create a new administrator.
     */
    public function create()
    {
        return view('admin.create-admin');
    }

    /**
     * Store a newly created administrator.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users,email'],
            'phone' => ['nullable', 'string', 'max:20'],
            'role' => ['required', 'in:admin,super_admin'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $isSuperAdmin = $validated['role'] === 'super_admin';

        $admin = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'] ?? null,
            'password' => Hash::make($validated['password']),
            'is_admin' => true,
            'is_super_admin' => $isSuperAdmin,
            'reason_for_registering' => $isSuperAdmin ? 'Super Administrator Desk' : 'Campus Property & Security Administration',
            'email_verified_at' => now(),
        ]);

        $roleText = $isSuperAdmin ? 'Super Administrator' : 'Campus Lost & Found Administrator';

        return redirect()->route('admin.administrators.index')
            ->with('success', "New {$roleText} [{$admin->name}] created successfully.");
    }

    /**
     * Promote an existing user to Administrator.
     */
    public function promote(Request $request, User $user)
    {
        $role = $request->input('role', 'admin');

        if ($role === 'super_admin') {
            $user->update([
                'is_admin' => true,
                'is_super_admin' => true,
            ]);
            $msg = "User [{$user->name}] elevated to Super Administrator!";
        } else {
            $user->update([
                'is_admin' => true,
                'is_super_admin' => false,
            ]);
            $msg = "User [{$user->name}] successfully assigned as Campus Administrator!";
        }

        return back()->with('success', $msg);
    }

    /**
     * Revoke administrator privileges from a user.
     */
    public function demote(User $user)
    {
        if ($user->id === auth()->id()) {
            return back()->with('error', 'You cannot revoke your own administrator privileges.');
        }

        // Prevent demoting the last super admin
        if ($user->is_super_admin && User::where('is_super_admin', true)->count() <= 1) {
            return back()->with('error', 'Cannot demote the sole remaining Super Administrator.');
        }

        $user->update([
            'is_admin' => false,
            'is_super_admin' => false,
        ]);

        return back()->with('success', "Administrator privileges revoked for [{$user->name}].");
    }

    /**
     * Delete an administrator account.
     */
    public function destroy(User $user)
    {
        if ($user->id === auth()->id()) {
            return back()->with('error', 'You cannot delete your own account.');
        }

        if ($user->is_super_admin && User::where('is_super_admin', true)->count() <= 1) {
            return back()->with('error', 'Cannot delete the sole remaining Super Administrator.');
        }

        $name = $user->name;
        $user->delete();

        return back()->with('success', "Administrator account [{$name}] deleted successfully.");
    }
}

