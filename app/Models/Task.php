<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $fillable = [
        'title',
        'description',
        'priority',
        'creator_id',
        'assignee_id',
        'client_id',
        'parent_id',
        'due_date',
        'status',
        'completed_at',
    ];

    protected $casts = [
        'due_date' => 'date',
        'completed_at' => 'datetime',
    ];

    public function creator()
    {
        return $this->belongsTo(User::class, 'creator_id');
    }

    public function client()
    {
        return $this->belongsTo(Client::class, 'client_id');
    }

    public function parent()
    {
        return $this->belongsTo(Task::class, 'parent_id');
    }

    public function subtasks()
    {
        return $this->hasMany(Task::class, 'parent_id');
    }

    public function assignees()
    {
        return $this->belongsToMany(User::class, 'task_user');
    }

    public function comments()
    {
        return $this->hasMany(TaskComment::class)->latest(); // Order by newest
    }
}
