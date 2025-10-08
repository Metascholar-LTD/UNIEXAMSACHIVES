<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'first_name',
        'last_name',
        'is_admin',
        'is_approve',
        'profile_picture',
        'department_id',
        'staff_category',
        'password_changed',
        'admin_access_requested',
        'admin_access_reason',
        'admin_access_supervisor',
        'admin_access_supervisor_email',
        'admin_access_requested_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
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

    public function messages()
    {
        return $this->belongsToMany(Message::class, 'message_user_read')
                    ->withPivot('is_read')
                    ->withTimestamps();
    }

    /**
     * Get the profile picture URL
     */
    public function getProfilePictureUrlAttribute()
    {
        if ($this->profile_picture) {
            return asset('profile_pictures/' . $this->profile_picture);
        }
        return asset('profile_pictures/default-profile.png'); // Default profile picture
    }

    /**
     * Get the department that the user belongs to
     */
    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    /**
     * Check if user needs to change their temporary password
     */
    public function needsPasswordChange()
    {
        return !$this->password_changed;
    }

    /**
     * Check if user is using a temporary password
     */
    public function isUsingTemporaryPassword()
    {
        return $this->is_approve && !$this->password_changed;
    }
}
