<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Zttp\Zttp;

class Recaptcha implements Rule
{
    public function passes($attribute, $value)
    {
        //recaptcha confirmation
        $res = Zttp::asFormParams()->post('https://www.google.com/recaptcha/api/siteverify', [

            'secret' => config('services.recaptcha.secret'),
            'response' => $value, //comes form with recaptcha element
            'remoteip' => request()->ip() //server global for user ip address
        ]);

        return $res->json()['success'];
    }


    public function message()
    {
        return 'Recaptcha Failed !!! ';
    }
}
