<?php

namespace App\Exceptions;

use Dotenv\Exception\ValidationException;
use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use App\Exceptions\ThrottleException;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     *
     * @param  \Exception  $exception
     * @return void
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $exception)
    {
        // we are using javascript and dont need a general redirect,so... 
        if ($exception instanceof ValidationException) {
            if ($request->wantsJson()) {
                return response('Sorry, Validation Failed !', 422);
            }
        }


        if ($exception instanceof ThrottleException) {
            //return response('You are Posting Too Frequently !!!', 429);
            return response()->json([
                'message' => 'new message from exception handler',
                'errors' =>  ['body' => ['You are Posting Too Frequently !!!']]
            ], 429);
        }


        return parent::render($request, $exception);
    }
}
