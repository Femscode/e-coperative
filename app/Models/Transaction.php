<?php

namespace App\Models;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model implements Auditable
{
    use HasFactory,AuditableTrait;
    protected $auditExclude = ['password', 'original'];
    protected $fillable = [
        'user_id',
        'company_id',
        'amount',
        'transaction_id',
        'status',
        'referred_by',
        'username',
        'phone',
        'email',
        'name',
        'payment_type',
        'password',
        'balance',
        'month',
        'plan_id',
        'original',
        'uuid',
        'week',
    ];

    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id');
    }
}
