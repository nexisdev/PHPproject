<?php

namespace App\Models;

use App\Traits\Searchable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Zilab\Referral\Entities\ReferralTransaction;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles, Searchable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'status',
        'password',
        'referral_hash',
        'referred_by',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'google2fa_secret',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public array $searchableFields = [
        'name',
        'email',
    ];

    public function referralBy()
    {
        return $this->belongsTo(User::class, 'referred_by');
    }

    public function referralTransaction()
    {
        return $this->hasMany(ReferralTransaction::class, 'user_id');
    }

    public function Kyc()
    {
        return $this->hasOne(Kyc::class);
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    public function getBoughtAmountAttribute()
    {
        return $this->transactions->sum('bought_amount');
    }

    public function getIsTwoFactorAuthEnabledAttribute()
    {
        return $this->google2fa_secret !== null;
    }
}
