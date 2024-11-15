<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function payaza_webhook(Request $request) {
        file_put_contents(__DIR__ . '/payaza.txt', json_encode($request->all(), JSON_PRETTY_PRINT), FILE_APPEND);
        
    }
    public function payaza_callback(Request $request) {
        file_put_contents(__DIR__ . '/paycallback.txt', json_encode($request->all(), JSON_PRETTY_PRINT), FILE_APPEND);

    }
}
