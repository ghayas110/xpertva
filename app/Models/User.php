<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'status',
        'region',
        'salary',
        'total_leaves',
        'used_leaves',
        'avatar_path',
        'phone',
        'secondary_phone',
        'secondary_email',
    ];

    public function getAvatarUrlAttribute(): string
    {
        if ($this->avatar_path) {
            // New uploads live under public/assets/images/avatars/... matching
            // the blog-image convention (works on shared hosts that block the
            // storage symlink). Legacy rows still reference the old storage path.
            if (str_starts_with($this->avatar_path, 'assets/')) {
                return asset($this->avatar_path);
            }
            return asset('storage/' . $this->avatar_path);
        }
        return 'https://ui-avatars.com/api/?name=' . urlencode($this->name) . '&background=E0E7FF&color=4F46E5';
    }

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

    public function createdTasks()
    {
        return $this->hasMany(Task::class, 'creator_id');
    }

    public function assignedTasks()
    {
        return $this->belongsToMany(Task::class, 'task_user');
    }

    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }

    public function leaves()
    {
        return $this->hasMany(LeaveRequest::class);
    }

    public function lateRecords()
    {
        return $this->hasMany(LateRecord::class);
    }

    public function emailAccount()
    {
        return $this->hasOne(EmailAccount::class);
    }
}
