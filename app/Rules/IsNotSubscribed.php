<?php

namespace App\Rules;

use App\Models\User;
use Illuminate\Contracts\Validation\InvokableRule;

class IsNotSubscribed implements InvokableRule
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
        $user = User::where('email', $value)->get();

        if ($user->isEmpty()) 
            return;

        if ($user->is_subscribed)
            $fail('The email is already in Newsletter list!s');
    }
}
