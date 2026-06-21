<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\Transaction;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'phone',
        'address',
        'avatar',
        'password',
        'role',
        'kode_admin',
        'jenis_kelamin',
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
        'password' => 'hashed',
    ];

    /**
     * Get user's initials for avatar placeholder
     */
    public function getInitialsAttribute()
    {
        $words = explode(' ', $this->name);
        $initials = '';
        foreach ($words as $word) {
            $initials .= strtoupper(substr($word, 0, 1));
        }
        return substr($initials, 0, 2);
    }

    /**
     * Get user's transactions
     */
    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    /**
     * Get user's saved/favorite properties
     */
    public function savedProperties()
    {
        return $this->belongsToMany(Property::class, 'saved_properties')
            ->withTimestamps();
    }

    /**
     * Check if user has saved a specific property
     */
    public function hasSavedProperty($propertyId)
    {
        return $this->savedProperties()->where('property_id', $propertyId)->exists();
    }

    public function visitSchedules()
    {
        return $this->hasMany(VisitSchedule::class);
    }

    public function scopeAdmins($query)
    {
        return $query->where('role', 'admin');
    }

    public static function boot(): void
    {
        parent::boot();

        static::creating(function (User $user) {
            if ($user->role === 'admin' && empty($user->kode_admin)) {
                $user->kode_admin = self::generateKodeAdmin($user->name, $user->jenis_kelamin);
            }
        });

        static::updating(function (User $user) {
            if ($user->isDirty('role') && $user->role === 'admin' && empty($user->kode_admin)) {
                $user->kode_admin = self::generateKodeAdmin($user->name, $user->jenis_kelamin);
            }
        });
    }

    public static function generateKodeAdmin(?string $name, ?string $jenisKelamin): string
    {
        $initials = self::getInitialsFromName($name);
        $gender = $jenisKelamin ?? 'P';
        $year = now()->format('y');
        $lastAdmin = self::admins()
            ->where('kode_admin', 'like', "WHP-ADM-{$initials}-{$gender}{$year}-%")
            ->orderBy('kode_admin', 'desc')
            ->first();

        if ($lastAdmin && preg_match('/-(\d{3})$/', $lastAdmin->kode_admin, $matches)) {
            $seq = str_pad((int)$matches[1] + 1, 3, '0', STR_PAD_LEFT);
        } else {
            $seq = '001';
        }

        return "WHP-ADM-{$initials}-{$gender}{$year}-{$seq}";
    }

    public static function getInitialsFromName(?string $name): string
    {
        if (empty($name)) return 'XX';
        $words = explode(' ', trim($name));
        $initials = '';
        foreach ($words as $word) {
            if (!empty($word)) {
                $initials .= strtoupper(mb_substr($word, 0, 1));
            }
        }
        return substr($initials, 0, 2);
    }
}
