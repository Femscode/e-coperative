<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'image',
        'user_id',
        'is_global',
        'date',
    ];

    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id')->withDefault(['name' => '']);
    }
}
