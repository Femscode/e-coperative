<?php

namespace App\Models;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($loan) {
            // Set the value for the 'user id' column
            $loan->company_id = Auth::user()->id;
        });
    }

    public function members()
    {
        return $this->hasMany('App\Models\GroupMember', 'group_id');
    }
}
