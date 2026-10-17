<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Claim extends Model
{
    protected $fillable = [
        'item_id',
        'user_id',
        'student_registration_number',
        'phone_number',
        'proof_details',
        'claimed_loss_date',
        'claimed_location',
        'is_suspicious',
        'flag_reason',
        'admin_notes',
        'claim_status',
    ];

    protected $casts = [
        'claimed_loss_date' => 'date',
        'is_suspicious' => 'boolean',
    ];


    public function item()
    {
        return $this->belongsTo(Item::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
