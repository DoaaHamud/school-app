<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;


class School extends Model
{
    use HasFactory, Notifiable, HasApiTokens;

    protected $fillable = [
        'name',
        'logo',
        'color',
        'classes',
        'sections',
        'subjects',
    ];

    protected function casts(): array
    {
        return [
            'classes' => 'array',
            'sections' => 'array',
        ];
    }

    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    public function children(): HasMany
    {
        return $this->hasMany(chaldrin::class);
    }

    public function motherRequests(): HasMany
    {
        return $this->hasMany(SchoolMotherRequest::class);
    }
}
