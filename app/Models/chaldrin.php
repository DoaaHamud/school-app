<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class chaldrin extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'mother_id',
        'manager_id',
        'name',
        'gender',
        'Health_status',
        'class',
        'age',
        'image',
    ];

    public function mother()
    {
        return $this->belongsTo(User::class, 'mother_id');
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

    public function manager()
    {
        return $this->belongsTo(User::class, 'manager_id');
    }
}
