<?php

namespace App\Http\Requests;

use App\Exceptions\ThrottleException;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;

class CreatePostRequest extends FormRequest
{

    public function authorize()
    {
        $lastReply = auth()->user()->fresh()->lastReply;

        if (!$lastReply) return true;

        return !$lastReply->wasJustPublished();
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
