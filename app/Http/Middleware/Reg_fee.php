<?php

namespace App\Http\Middleware;

use App\Models\Transaction;
use Closure;
use Illuminate\Http\Request;

class Reg_fee
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $user = $request->user();

        // Allow non-members to proceed
        // return $next($request);
        if ($user->user_type !== 'Member') {
            return $next($request);
        }

        $company = $user->company;

        // If no registration fee is required, proceed
        if (!$company || $company->reg_fee <= 0) {
            return $next($request);
        }

        $otherpayments = Transaction::where('user_id', $user->uuid)->where('status', 'Success')->exists();
        if($otherpayments){
            return $next($request);
        }
        // Check if registration fee is already paid
        $hasValidPayment = Transaction::where('user_id', $user->uuid)
            ->where('status', 'Success')
            ->where('payment_type', 'Registration')
            ->exists();


        if ($hasValidPayment) {
            return $next($request);
        }

        // Redirect to registration fee payment page if not paid
        return redirect()->route('registration.fee')
            ->with('warning', 'Please complete your registration fee payment to continue.');
    }
}
