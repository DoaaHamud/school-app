<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'username',
        'school_name',
        'role',
        'status',
        'phone',
        'school_logo',
        'primary_color',
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
        ];
    }

    public function childrenAsMother()
    {
        return $this->hasMany(chaldrin::class, 'mother_id');
    }

    public function childrenAsTeacher()
    {
        return $this->belongsToMany(
            chaldrin::class,
            'child_teacher',
            'teacher_id',
            'child_id'
        );
    }

    public function childrenAsAmanager()
    {
        return $this->hasMany(chaldrin::class, 'manager_id');
    }

  

    public function dailyVariables()
    {
        return $this->hasMany(Daily_variables::class, 'teacher_id');
    }
}
