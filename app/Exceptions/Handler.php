<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;

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
     * @param  \Throwable  $exception
     * @return void
     *
     * @throws \Exception
     */
    public function report(Throwable $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Throwable  $exception
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \Throwable
     */
    // public function render($request, Throwable $exception)
    // {
    //     return parent::render($request, $exception);
    // }


    public function render($request, Throwable $exception)
    {

        if($exception->getCode() == 0){
            return response(
                [
                    'errors' => [
                        'status' => 401,
                        'message' => $exception->getMessage(),
                    ]
                ], 
            401); 
        }

        return response()->json(
            [
                'errors' => [
                    'status' => 500,
                    'message' => $exception->getMessage(),
                    'file' => $exception->getFile(),
                    'line' => $exception->getLine(),
                    'trave' => $exception->getTrace(),
                ]
            ], 
        ); 
    }
}
