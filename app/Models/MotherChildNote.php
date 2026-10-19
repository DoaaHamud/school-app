<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MotherChildNote extends Model
{
    protected $fillable = [
        'child_id',
        'mother_id',
        'teacher_id',
        'note',
        'reply',
        'replied_at',
    ];

    protected function casts(): array
    {
        return [
            'replied_at' => 'datetime',
        ];
    }

    public function child()
    {
        return $this->belongsTo(chaldrin::class, 'child_id');
    }

    public function mother()
    {
        return $this->belongsTo(User::class, 'mother_id');
    }

    public function teacher()
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }
}
