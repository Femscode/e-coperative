<?php

namespace App\Models;
use App\Models\Plan;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Laravel\Sanctum\HasApiTokens;
use Laravel\Scout\Searchable;
use OwenIt\Auditing\Auditable as AuditableTrait;
use OwenIt\Auditing\Contracts\Auditable;

class User extends Authenticatable implements Auditable
{
    use SoftDeletes, HasApiTokens, HasFactory, Notifiable,AuditableTrait;
    // use Searchable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'company_id',
        'email',
        'password',
        'user_type',
        'referred_by',
        'plan_id',
        'coop_id',
        'phone',
        'bio',
        'username',
        'referred_by',
        'month',
        'active',
        'tfa',
        'tfa_code',
        'city',
        'state',
        'designation',
        'country',
        'gender',
        'address',
        'profile_image',
        'cover_image',
        'bank_code',
        'account_name',
        'account_number',
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
    ];

    public function plan(){
        $plan = Plan::find($this->plan_id);
        return $plan;
    }

    public function refers(){
        $referers = User::where('referred_by', $this->coop_id)->get();
        return $referers;
    }
    public function toSearchableArray()
    {
        return [
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'address' => $this->address,
            // Add other searchable attributes
        ];
    }

    public function scopeSearch($query, $term)
    {
        return empty($term) ? $query : $query->search($term);
    }

    public function company() {
        return $this->belongsTo(Company::class, 'company_id', 'uuid');
    }

    protected static function boot()
    {
        parent::boot();
        static::saving(function ($user) {
            
            $user->uuid = $user->uuid ?? Str::uuid();
        });
    }
}
