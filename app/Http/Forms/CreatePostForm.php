<?php

namespace App\Http\Forms;

use App\Exceptions\ThrottleException;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;

class CreatePostForm extends FormRequest
{
    /**
     *This is  a class that is responsible for submiting a form 
     *Validation, authorization, persisting to database, all can be dne here.
     *in the End of this class we can add a method persist() that is responsible 
     *for submting data to database. 
     *
     * @return bool
     */
    public function authorize()
    {
        //protect against spam creating replies
        return Gate::allows('create', new \App\Reply);
    }

    /** Over Ride Failed Authorization Exception  */
    protected function failedAuthorization()
    {
        throw new ThrottleException(
            'You are Repling too frequently, Take a Break :)'
        ); //a custom exception that we create
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'body' => 'required|spamfree'
        ];
    }


    public function persist($thread)
    {
        return $thread->addReply([
            'body' => request('body'),
            'user_id' => auth()->id()
        ])->load('owner');
    }
}
