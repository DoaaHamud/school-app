<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;



class chaldrin extends Model
{
    use HasFactory, Notifiable, HasApiTokens;

    use SoftDeletes;

    protected $fillable = [
        'mother_id',
        'school_id',
        'name',
        'gender',
        'Health_status',
        'class',
        'section',
        'age',
        'image',
    ];

    public function mother()
    {
        return $this->belongsTo(User::class, 'mother_id');
    }

    public function school(): BelongsTo
    {
        return $this->belongsTo(School::class);
    }

    public function teachers()
    {
        return $this->belongsToMany(
            User::class,
            'child_teacher',
            'child_id',
            'teacher_id'
        );
    }

    public function dailyVariables()
    {
        return $this->hasMany(Daily_variables::class, 'child_id');
    }

    public function latestDailyVariable()
    {
        return $this->hasOne(Daily_variables::class, 'child_id')->latestOfMany('report_date');
    }
}
