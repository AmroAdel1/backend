<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Todo extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'description',
        'due_date',
        'is_completed',
        'priority',
        'user_id',
    ];

    protected $casts = [
        'due_date' => 'datetime',
        'is_completed' => 'boolean',
    ];

    public function user()      // Get the user that owns the todo
    {
        return $this->belongsTo(User::class);
    }
}
