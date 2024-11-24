<?php

namespace App\Models;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class MemberLoan extends Model implements Auditable
{
    use HasFactory,AuditableTrait;
    protected $fillable = [
        'user_id','company_id','plan_id','status','monthly_return','total_left','total_refund','total_applied',
        'applied_date','approval_status','uuid','payment_status','uploaded','released','disbursed_date'
    ];
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($loan) {
            // Set the value for the 'user id' column
            $loan->user_id = Auth::user()->id;
            $loan->plan_id = Auth::user()->company_id;
            $loan->company_id = Auth::user()->company_id;
            $loan->applied_date = now();
        });
    }

    public function user(){
        $user = User::where('id', $this->user_id)->first();
        return $user;
    }
    public function color(){
        $color ="primary";
        switch($this->status) {
            case('Awaiting'):
                $msg = 'warning';
                break;
            case('Ongoing');
                $msg = 'info';
            break;
            default:
                $msg = $color;
        }
        return $msg;
    }
    public function approval(){
        $color ="danger";
        switch($this->approval_status) {
            case('0'):
                $msg = 'warning';
                break;
            case('1');
                $msg = 'info';
            break;
            default:
                $msg = $color;
        }
        return $msg;
    }
    public function approvalText(){
        $color ="Disapproved";
        switch($this->approval_status) {
            case('0'):
                $msg = 'Pending';
                break;
            case('1');
                $msg = 'Approved';
            break;
            default:
                $msg = $color;
        }
        return $msg;
    }
    public function payment(){
        $color ="danger";
        switch($this->payment_status) {
            case('0'):
                $msg = 'warning';
                break;
            case('1');
                $msg = 'primary';
            break;
            default:
                $msg = $color;
        }
        return $msg;
    }
    public function paymentText(){
        $color ="Cancel";
        switch($this->payment_status) {
            case('0'):
                $msg = 'Pending';
                break;
            case('1');
                $msg = 'Paid';
            break;
            default:
                $msg = $color;
        }
        return $msg;
    }

    public function member()
    {
        return $this->belongsTo('App\Models\User', 'user_id')->withDefault(['name' => '']);
    }
}
