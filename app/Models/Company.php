<?php

namespace App\Models;
use Carbon\Carbon;
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
    public function getMondays($month){
        $dateString = $month;
        // Parse the input date string using Carbon
        $date = Carbon::parse($dateString);
        // Get the number of Mondays in the month
        // $mondaysCount = $date->month($date->month)->mondaysInMonth;
        $currentMonth = $date->month;
        // Create a Carbon instance for the first day of the current month
        $firstDayOfMonth = Carbon::createFromDate(null, $currentMonth, 1);

        // Get the day of the week for the first day of the month (0=Sunday, 1=Monday, etc.)
        $firstDayOfWeek = $firstDayOfMonth->dayOfWeek;

        // Calculate the number of Mondays in the month based on the day of the week for the first day
        $numMondays = intval($firstDayOfMonth->daysInMonth / 7) + ($firstDayOfWeek <= Carbon::MONDAY && ($firstDayOfMonth->daysInMonth % 7 >= Carbon::MONDAY - $firstDayOfWeek));
        return $numMondays;
    }
}
