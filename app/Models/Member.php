<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'email',
        'coop-id',
        'photo',
        'registered_at',
        'bio',
        'phone'
    ];
}
