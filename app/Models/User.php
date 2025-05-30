<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'name',
        'email',
        'join_date',
        'phone_number',
        'status',
        'role_name',
        'avatar',
        'position',
        'department',
        'password',
        'encryption_enabled'
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
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'encryption_enabled' => 'boolean',
    ];

    protected static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $getUser = self::orderBy('user_id', 'desc')->first();

            if ($getUser) {
                $latestID = intval(substr($getUser->user_id, 3));
                $nextID = $latestID + 1;
            } else {
                $nextID = 1;
            }
            $model->user_id = '000' . sprintf("%03s", $nextID);
            while (self::where('user_id', $model->user_id)->exists()) {
                $nextID++;
                $model->user_id = '000' . sprintf("%03s", $nextID);
            }
        });
    }

    // Accessor to decrypt data when encryption is disabled
    public function getNameAttribute($value)
    {
        return $this->encryption_enabled ? $value : $this->decryptData($value);
    }

    public function getEmailAttribute($value)
    {
        return $this->encryption_enabled ? $value : $this->decryptData($value);
    }

    public function getRoleNameAttribute($value)
    {
        return $this->encryption_enabled ? $value : $this->decryptData($value);
    }

    public function getDepartmentAttribute($value)
    {
        return $this->encryption_enabled ? $value : $this->decryptData($value);
    }

    public function getPositionAttribute($value)
    {
        return $this->encryption_enabled ? $value : $this->decryptData($value);
    }

    // Helper method to decrypt data
    private function decryptData($value)
    {
        // Since we're using SHA-256 (one-way hash), we can't decrypt
        // Instead, we'll return a placeholder when encryption is disabled
        return '[Encrypted]';
    }

    // Method to toggle encryption
    public function toggleEncryption($enabled)
    {
        $this->encryption_enabled = $enabled;
        $this->save();
    }
}
