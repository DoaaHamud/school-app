<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Daily_variables extends Model
{
   protected $fillable = [
    'child_id',
    'teacher_id',
    'topic',
    'result',
    'notes',
    'report_date',
];


    public function child()
    {
        return $this->belongsTo(chaldrin::class, 'child_id');
    }

    public function teacher()
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }
}
