<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Attributes
 *
 * @property \App\User $user
 */
class Todo extends Model
{
    protected $fillable = [
        'title',
        'description',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function assignees()
    {
        return $this->belongsToMany(User::class)
            ->withTimestamps();
    }
}
