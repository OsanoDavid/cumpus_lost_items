<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 
        'title', 
        'description', 
        'status', 
        'category', 
        'location', 
        'date_lost_found',
        'contact_phone',
        'contact_name',
        'image_path', 
        'secret_identifier', 
        'is_resolved',
        'is_anonymous'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function claims()
    {
        return $this->hasMany(Claim::class);
    }

    /**
     * Scope query to strictly filter by user's search intent (e.g. Laptops only, not IDs).
     */
    public function scopeForSearchIntent($query, ?string $searchIntent)
    {
        if (empty($searchIntent)) {
            return $query;
        }

        $intentLower = strtolower($searchIntent);

        return $query->where(function ($sub) use ($intentLower, $searchIntent) {
            if (str_contains($intentLower, 'laptop') || str_contains($intentLower, 'electronic')) {
                $sub->where('category', 'Electronics')
                    ->orWhere('title', 'like', '%laptop%')
                    ->orWhere('title', 'like', '%electronic%')
                    ->orWhere('title', 'like', '%phone%')
                    ->orWhere('title', 'like', '%hp%')
                    ->orWhere('title', 'like', '%dell%')
                    ->orWhere('description', 'like', '%laptop%');
            } elseif (str_contains($intentLower, 'id') || str_contains($intentLower, 'card')) {
                $sub->where('category', 'Student ID / Documents')
                    ->orWhere('title', 'like', '%id%')
                    ->orWhere('title', 'like', '%card%')
                    ->orWhere('title', 'like', '%student id%')
                    ->orWhere('description', 'like', '%student id%');
            } elseif (str_contains($intentLower, 'book') || str_contains($intentLower, 'note') || str_contains($intentLower, 'textbook')) {
                $sub->where('category', 'Books / Notes')
                    ->orWhere('title', 'like', '%book%')
                    ->orWhere('title', 'like', '%notes%');
            } elseif (str_contains($intentLower, 'key')) {
                $sub->where('category', 'Keys')
                    ->orWhere('title', 'like', '%key%');
            } elseif (str_contains($intentLower, 'wallet') || str_contains($intentLower, 'purse') || str_contains($intentLower, 'bag')) {
                $sub->where('category', 'Clothing / Bags')
                    ->orWhere('title', 'like', '%wallet%')
                    ->orWhere('title', 'like', '%bag%')
                    ->orWhere('title', 'like', '%purse%');
            } else {
                $sub->where('title', 'like', "%{$searchIntent}%")
                    ->orWhere('description', 'like', "%{$searchIntent}%")
                    ->orWhere('category', 'like', "%{$searchIntent}%");
            }
        });
    }

    /**
     * Smart Match Engine: Search for found items that likely correspond to a reported lost item.
     * Criteria:
     * 1. ID / Reg Number match (exact or partial credential match)
     * 2. Items found from the reported loss date forward up to current date
     * 3. Matching Category or keyword relevance
     */
    public static function findMatchesForLostItem(Item $lostItem)
    {
        if ($lostItem->status !== 'lost') {
            return collect();
        }

        $lostDate = $lostItem->date_lost_found 
            ? \Carbon\Carbon::parse($lostItem->date_lost_found)->startOfDay() 
            : $lostItem->created_at->startOfDay();

        $secretId = trim($lostItem->secret_identifier ?? '');
        $userRegNo = $lostItem->user ? trim($lostItem->user->reg_number ?? '') : '';
        $category = $lostItem->category;
        
        // Clean strings for fuzzy ID matching
        $cleanSecret = strtolower(preg_replace('/[^a-zA-Z0-9]/', '', $secretId));
        $cleanUserReg = strtolower(preg_replace('/[^a-zA-Z0-9]/', '', $userRegNo));

        $titleWords = array_filter(
            explode(' ', strtolower(preg_replace('/[^a-zA-Z0-9\s]/', '', $lostItem->title))),
            fn($w) => strlen($w) >= 3 && !in_array($w, ['the', 'and', 'for', 'lost', 'item', 'with'])
        );

        $query = self::where('status', 'found')
            ->where('is_resolved', 0)
            ->where('id', '!=', $lostItem->id);

        if ($lostItem->user_id) {
            $query->where(function($q) use ($lostItem) {
                $q->whereNull('user_id')->orWhere('user_id', '!=', $lostItem->user_id);
            });
        }

        $foundCandidates = $query->latest()->get();

        $matched = $foundCandidates->filter(function ($found) use ($lostDate, $secretId, $cleanSecret, $cleanUserReg, $category, $titleWords, $lostItem) {
            $foundDate = $found->date_lost_found 
                ? \Carbon\Carbon::parse($found->date_lost_found)->startOfDay() 
                : $found->created_at->startOfDay();

            $foundSecret = trim($found->secret_identifier ?? '');
            $cleanFoundSecret = strtolower(preg_replace('/[^a-zA-Z0-9]/', '', $foundSecret));
            $foundText = strtolower(($found->title ?? '') . ' ' . ($found->description ?? ''));
            $cleanFoundText = strtolower(preg_replace('/[^a-zA-Z0-9]/', '', $foundText));

            // Check 1: Direct ID or Registration Number Match (High Confidence)
            if (!empty($cleanSecret) && $cleanSecret !== 'none' && $cleanSecret !== 'null') {
                if (!empty($cleanFoundSecret) && (str_contains($cleanFoundSecret, $cleanSecret) || str_contains($cleanSecret, $cleanFoundSecret))) {
                    $found->match_priority = 100;
                    $found->match_type = 'exact_id';
                    $found->match_reason = "Direct ID / Reg No Match: '{$secretId}' matched found item marker '{$foundSecret}'";
                    return true;
                }

                if (str_contains($cleanFoundText, $cleanSecret)) {
                    $found->match_priority = 90;
                    $found->match_type = 'exact_id';
                    $found->match_reason = "School ID / Reg Number '{$secretId}' mentioned in found item description";
                    return true;
                }
            }

            // Check 1b: User account registration number match
            if (!empty($cleanUserReg)) {
                if (!empty($cleanFoundSecret) && (str_contains($cleanFoundSecret, $cleanUserReg) || str_contains($cleanUserReg, $cleanFoundSecret))) {
                    $found->match_priority = 95;
                    $found->match_type = 'exact_id';
                    $found->match_reason = "Account Reg No Match: Student registration number matches found ID";
                    return true;
                }

                if (str_contains($cleanFoundText, $cleanUserReg)) {
                    $found->match_priority = 85;
                    $found->match_type = 'exact_id';
                    $found->match_reason = "Student Reg No detected in found item records";
                    return true;
                }
            }

            // Check 2: Date Timeline - Item found ON or AFTER reported loss date up to today
            if ($foundDate->gte($lostDate)) {
                // If in same category (e.g. Student ID / Documents)
                if ($found->category === $category) {
                    $found->match_priority = 70;
                    $found->match_type = 'date_category';
                    $found->match_reason = "Found on {$foundDate->format('M d, Y')} (after your loss date {$lostDate->format('M d, Y')}) in {$category}";
                    return true;
                }

                // If title keywords match
                foreach ($titleWords as $word) {
                    if (str_contains($foundText, $word)) {
                        $found->match_priority = 60;
                        $found->match_type = 'date_keyword';
                        $found->match_reason = "Found on {$foundDate->format('M d, Y')} with keyword match '{$word}'";
                        return true;
                    }
                }
            }

            return false;
        });

        return $matched->sortByDesc('match_priority')->values();
    }
}