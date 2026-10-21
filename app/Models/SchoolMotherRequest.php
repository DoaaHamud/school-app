<?php

namespace App\Models;

use App\Notifications\SchoolMotherRequestNotification;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SchoolMotherRequest extends Model
{
    protected $fillable = [
        'school_id',
        'mother_id',
        'status',
    ];

    public function school(): BelongsTo
    {
        return $this->belongsTo(School::class);
    }

    public function mother(): BelongsTo
    {
        return $this->belongsTo(User::class, 'mother_id');
    }

    protected static function booted(): void
    {
        static::created(function (self $request) {
            $admin = User::where('school_id', $request->school_id)->first();

            $admin?->notify(
                new SchoolMotherRequestNotification($request, 'request_created')
            );
        });

        static::updated(function (self $request) {
            if ($request->wasChanged('status') && $request->status === 'accepted') {
                $request->mother?->notify(
                    new SchoolMotherRequestNotification($request, 'request_accepted')
                );
            }
        });
    }
}
