<?php

namespace App\Http\Requests;

use App\Exceptions\ThrottleException;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;

class CreatePostRequest extends FormRequest
{

    public function authorize()
    {
        //protect against spam creating replies
        return Gate::allows('create', new \App\Reply);
    }

    protected function failedAuthorization()
    {
        throw new ThrottleException(
            'You are Repling too frequently, Take a Break :)'
        ); //a custom exception that we create
    }

    public function rules()
    {
        return [
            'body' => 'required|spamfree'
        ];
    }
}
