<?php

namespace App\Models;
use Carbon\Carbon;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Plan extends Model implements Auditable
{
    use HasFactory, AuditableTrait;
    protected $guarded = [];

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
