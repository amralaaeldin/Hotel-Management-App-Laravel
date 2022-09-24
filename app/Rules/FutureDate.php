<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\InvokableRule;
use Carbon\Carbon;


class FutureDate implements InvokableRule
{
    /**
     * Run the validation rule.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     * @return void
     */
    public function __invoke($attribute, $value, $fail)
    {
        // if (st_date in the past || st_date is today & request happens after 1:00 pm) 
        // fail

        if ($value < date('Y-m-d') || ($value == date('Y-m-d') && Carbon::now('+02:00')->hour < 13)) {
            $fail('The :attribute must be valid future date. We support same day reservations until 01:00 PM.');
        }
    }
}
