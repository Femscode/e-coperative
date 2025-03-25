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
use Carbon\Carbon;
use Laravel\Scout\Searchable;
use OwenIt\Auditing\Auditable as AuditableTrait;
use OwenIt\Auditing\Contracts\Auditable;

class User extends Authenticatable implements Auditable
{
    use SoftDeletes, HasApiTokens, HasFactory, Notifiable, AuditableTrait;
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
        'photo',
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

    public function plans()
    {
        $plan = Plan::find($this->plan_id);
        return $plan;
    }
    public function plan()
    {
        $plan = Company::where('id', $this->company_id)->orwhere('uuid', $this->company_id)->first();
        return $plan;
    }
    public function totalSavings()
    {
        $plan = Transaction::where('user_id', $this->id)->where('status', 'Success')->whereIn('payment_type', ['Weekly Dues', 'Monthly Dues', 'Anytime'])->sum('original');
        return $plan;
    }

    public function refers()
    {
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

    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id','uuid');
    }

    protected static function getTotalDues()
    {
        $startDate = Carbon::parse(Auth::user()->created_at);
        $endDate = Carbon::now();
        $mode = Auth::user()->plan()->mode;
        $data['user'] = $user = Auth::user();

        //dd($mode);
        switch ($mode) {
            case 'Anytime':

                return view('cooperative.member.admin.payment.anytime', $data);
                return view('member.payment.anytime', $data);
                break;

            case 'Monthly':

                $currentDate = $startDate->copy()->startOfMonth();
                while ($currentDate->lte($endDate) && $currentDate->month <= $endDate->month) {
                    $monthsToView[] = $currentDate->format('F Y');
                    $currentDate->addMonth();
                }
                // dd($monthsToView);
                $myMonths = Transaction::where('user_id', auth()->user()->id)->where([['status', 'Success'], ['payment_type', 'Monthly Dues']])->pluck('month')->toArray();
                // dd($monthsToView, $myMonths);
                $months = [];
                foreach ($monthsToView as $thisMonth) {
                    $check = in_array($thisMonth, $myMonths);
                    if ($check == false) {
                        $months[] = ['source' => '1', 'month' => $thisMonth];
                    }
                }
                // $data['months'] = $months ;
                $data['plan'] = Auth::user()->plan();
                // check if member has ongoing loan application
                $check = MemberLoan::where([['user_id', auth()->user()->id], ['status', 'Ongoing']])->first();
                $dateArray = [];
                if ($check) {
                    $payback = $data['plan']->loan_month_repayment - 1;
                    $loanDate = Carbon::parse($check->disbursed_date);
                    // dd($loanDate);
                    $endMonth = Carbon::parse($check->disbursed_date)->addMonths($payback);
                    // Loop through the months between start date and current date
                    while ($loanDate->lessThanOrEqualTo($endMonth)) {
                        $availableNow[] = $loanDate->format('F Y');
                        $loanDate->addMonth();
                    }
                    //check if any payment has been made for this loan
                    $checkPayment = Transaction::where('user_id', auth()->user()->id)->where([['status', 'Success'], ['payment_type', 'Repayment'], ['uuid', $check->uuid]])->pluck('month')->toArray();
                    // $dateArray = [];
                    // dd($availableNow);
                    foreach ($availableNow as $pay) {
                        $spue = in_array($pay, $checkPayment);
                        $now = now()->format('F Y');
                        // dd($now,$pay);
                        if ($spue == false && \DateTime::createFromFormat('F Y', $pay) <= \DateTime::createFromFormat('F Y', $now)) {
                            $dateArray[] = ['source' => '2', 'month' => $pay, 'amount' => $check->monthly_return, 'uuid' => $check->uuid];
                        }
                    }
                }
                // dd($dateArray);
                $data['months'] = array_merge($months, $dateArray);
                // $data['months'] = $months + $dateArray;
                // dd($check, $data);
                return view('cooperative.member.admin.payment.monthly', $data);
                return view('member.payment.monthly', $data);
                break;
            case 'Weekly':

                //     $this->redirectTo = '/member';

                // return $this->redirectTo;
                break;


        }
        $currentDate = $startDate->copy()->startOfWeek();  // Start at the beginning of the week
        $weeksToView = [];

        while ($currentDate->lte($endDate)) {
            $weekStart = $currentDate->format('M d');
            $weekEnd = $currentDate->copy()->endOfWeek()->format('M d, Y');
            $weeksToView[] = "$weekStart - $weekEnd";
            $currentDate->addWeek();  // Move to the next week
        }
        // dd("here");
        // Assuming your `Transaction` records store weeks in a similar format as above (or adjust the format as needed)
        $myWeeks = Transaction::where('user_id', auth()->user()->id)
            ->where([
                ['status', 'Success'],
                ['payment_type', 'Weekly Dues']
            ])
            ->pluck('week')  // Change 'month' to 'week' if you have a week field
            ->toArray();

        $weeks = [];
        // dd()
        foreach ($weeksToView as $thisWeek) {
            $check = in_array($thisWeek, $myWeeks);
            if (!$check) {
                $weeks[] = ['source' => '1', 'week' => $thisWeek];
            }
        }
        dd($weeks);
    }

    protected static function boot()
    {
        parent::boot();
        static::saving(function ($user) {

            $user->uuid = $user->uuid ?? Str::uuid();
        });
    }


}
