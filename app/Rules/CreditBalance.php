<?php

namespace App\Rules;

use App\PCReservation;
use Auth;
use Illuminate\Contracts\Validation\Rule;

class CreditBalance implements Rule
{
    protected $user;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->user = Auth::user();
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $requiredCredits = PCReservation::requiredCredits($value);
        $creditBalance = $this->user->remainingCredits();
        return $requiredCredits <= $creditBalance;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Insufficient credit balance.';
    }
}
