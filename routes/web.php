<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ClaimController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\ProfileController;
use App\Models\UserMessage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
});

// Public Item Reporting (Can report without account, but must provide contact details like phone number)
Route::get('/items/create', [ItemController::class, 'create'])->name('items.create');
Route::post('/items', [ItemController::class, 'store'])->name('items.store');

/*
|--------------------------------------------------------------------------
| Authenticated User Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->group(function () {
    // Browsing & Searching Items (Requires login; regular users only see items matching what they are searching for, admins see all)
    Route::get('/items', [ItemController::class, 'index'])->name('items.index');

    // General User Dashboard
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // Profile Management
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // View Item Details & Submit Claims
    Route::get('/items/{item}', [ItemController::class, 'show'])->name('items.show');
    Route::post('/items/{item}/claims', [ClaimController::class, 'store'])->name('claims.store');

    // Specialized Dashboards (Based on user intent)
    Route::get('/dashboard/finder', function () {
        return view('dashboard.finder');
    })->name('dashboard.finder');

    Route::get('/dashboard/seeker', function () {
        return view('dashboard.seeker');
    })->name('dashboard.seeker');

    // Notifications / Inbox
    Route::get('/notifications', function () {
        $messages = Auth::user()->receivedMessages()->with('sender', 'claim.item')->get();
        // Mark all as read when inbox is opened
        Auth::user()->receivedMessages()->where('is_read', false)->update(['is_read' => true]);
        return view('notifications.inbox', compact('messages'));
    })->name('notifications.inbox');

    Route::patch('/notifications/{message}/read', [AdminController::class, 'markMessageRead'])->name('notifications.markRead');
});

use App\Http\Controllers\SuperAdminController;

/*
|--------------------------------------------------------------------------
| Admin & Super Admin Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');
    Route::patch('/items/{item}/resolve', [AdminController::class, 'resolveItem'])->name('items.resolve');
    Route::delete('/items/{item}', [AdminController::class, 'destroyItem'])->name('items.destroy');

    // Claims Decision Actions
    Route::patch('/claims/{claim}/approve', [AdminController::class, 'approveClaim'])->name('claims.approve');
    Route::patch('/claims/{claim}/reject', [AdminController::class, 'rejectClaim'])->name('claims.reject');

    // Admin → Student direct messaging
    Route::post('/messages', [AdminController::class, 'sendMessage'])->name('messages.send');


    // Super Admin Only: Management of Administrators
    Route::middleware(['super_admin'])->group(function () {
        Route::get('/administrators', [SuperAdminController::class, 'index'])->name('administrators.index');
        Route::get('/administrators/create', [SuperAdminController::class, 'create'])->name('administrators.create');
        Route::post('/administrators', [SuperAdminController::class, 'store'])->name('administrators.store');
        Route::patch('/administrators/{user}/promote', [SuperAdminController::class, 'promote'])->name('administrators.promote');
        Route::patch('/administrators/{user}/demote', [SuperAdminController::class, 'demote'])->name('administrators.demote');
        Route::delete('/administrators/{user}', [SuperAdminController::class, 'destroy'])->name('administrators.destroy');
    });
});


/*
|--------------------------------------------------------------------------
| Authentication Routes (Laravel Breeze)
|--------------------------------------------------------------------------
*/

require __DIR__.'/auth.php';