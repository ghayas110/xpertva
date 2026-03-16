<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmployeeActivity extends Model
{
    protected $fillable = [
        'user_id',
        'url',
        'active_time',
        'idle_time',
        'mouse_move_count',
        'click_count',
        'keystroke_count'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Check if the URL belongs to a tracked social media platform.
     */
    public function isSocialMedia(): bool
    {
        if (!$this->url) return false;
        
        $socialDomains = ['facebook.com', 'instagram.com', 'youtube.com', 'fb.com', 'youtu.be'];
        $host = parse_url($this->url, PHP_URL_HOST);
        
        if (!$host) return false;

        foreach ($socialDomains as $domain) {
            if (str_contains(strtolower($host), $domain)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Get the name of the social media platform.
     */
    public function getSocialPlatform(): ?string
    {
        if (!$this->url) return null;

        $socialDomains = [
            'facebook.com' => 'Facebook',
            'fb.com' => 'Facebook',
            'instagram.com' => 'Instagram',
            'youtube.com' => 'YouTube',
            'youtu.be' => 'YouTube',
        ];

        $host = parse_url($this->url, PHP_URL_HOST);
        if (!$host) return null;

        foreach ($socialDomains as $domain => $name) {
            if (str_contains(strtolower($host), $domain)) {
                return $name;
            }
        }

        return null;
    }
}
