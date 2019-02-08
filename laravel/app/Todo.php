<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * Attributes
 *
 * @property \App\User $user
 * @property \App\User[] $assignees
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

    public function assignees(): BelongsToMany
    {
        return $this->belongsToMany(User::class)
            ->withTimestamps();
    }

    public function markAsDoing()
    {
        $this->update(['status' => 'doing']);
    }

    public function markAsDone()
    {
        $this->update(['status' => 'done']);
    }

    public function markAsTodo()
    {
        $this->update(['status' => 'todo']);
    }

    public function removeAssignee(User $user): void
    {
        $this->assignees()
            ->detach($user->getKey());
    }
}
