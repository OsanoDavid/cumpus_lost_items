<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'phone',
        'is_admin',
        'is_super_admin',
        'password',
        'reg_number',
        'course',
        'year_of_study',
        'school',
        'reason_for_registering',
        'what_lost',
        'what_searching',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_admin' => 'boolean',
            'is_super_admin' => 'boolean',
        ];
    }

    /**
     * Determine if user is a Super Admin.
     */
    public function isSuperAdmin(): bool
    {
        return (bool) $this->is_super_admin;
    }

    /**
     * Determine if user has administrator privileges (Admin or Super Admin).
     */
    public function isAdmin(): bool
    {
        return (bool) ($this->is_admin || $this->is_super_admin);
    }

    /**
     * Get user role display label.
     */
    public function getRoleNameAttribute(): string
    {
        if ($this->isSuperAdmin()) {
            return 'Super Administrator';
        }
        if ($this->isAdmin()) {
            return 'Campus Administrator';
        }
        return 'Standard User';
    }


    /**
     * Relationship: A user can report many items.
     */
    public function items()
    {
        return $this->hasMany(Item::class);
    }

    /**
     * Relationship: A user can submit many claims for lost items.
     */
    public function claims()
    {
        return $this->hasMany(Claim::class);
    }

    /**
     * Get all found items that match any active lost item reports submitted by this user.
     */
    public function getActiveLostItemMatches()
    {
        $lostItems = $this->items()->where('status', 'lost')->where('is_resolved', 0)->get();
        $allMatches = collect();

        foreach ($lostItems as $lost) {
            $matches = Item::findMatchesForLostItem($lost);
            foreach ($matches as $match) {
                $clonedMatch = clone $match;
                $clonedMatch->matched_lost_item = $lost;
                $allMatches->push($clonedMatch);
            }
        }

        return $allMatches->unique('id')->sortByDesc('match_priority')->values();
    }

    /**
     * Messages sent TO this user (from admin).
     */
    public function receivedMessages()
    {
        return $this->hasMany(UserMessage::class, 'to_user_id')->latest();
    }

    /**
     * Messages this user has sent.
     */
    public function sentMessages()
    {
        return $this->hasMany(UserMessage::class, 'from_user_id')->latest();
    }

    /**
     * Unread message count for bell badge.
     */
    public function unreadMessageCount(): int
    {
        return $this->receivedMessages()->where('is_read', false)->count();
    }
}