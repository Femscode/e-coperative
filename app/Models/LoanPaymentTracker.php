<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LoanPaymentTracker extends Model
{
    use HasFactory;
    protected $table = 'loan_payment_trackers';
    protected $guarded = [];
}
