<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Company extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $table = 'companies';
    // protected $primaryKey = 'uuid';
    protected static function boot()
    {
        parent::boot();
        static::saving(function ($company) {
            $company->uuid = $company->uuid ?? Str::uuid();
        });
    }
}
