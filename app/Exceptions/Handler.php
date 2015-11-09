<?php

namespace App\Exceptions;

use Exception;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        HttpException::class,
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception  $e
     * @return void
     */
    public function report(Exception $e)
    {
        return parent::report($e);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $e
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $e)
    {
        $headers = ['Access-Control-Allow-Origin' => '*'];
        if ($e instanceof \Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException){
            return response()->json(['error' => 'method_not_allowed'], 405, $headers);
        } else if  ($e instanceof Tymon\JWTAuth\Exceptions\TokenExpiredException) {
            return response()->json(['token_expired'], $e->getStatusCode(), $headers);
        } else if ($e instanceof Tymon\JWTAuth\Exceptions\TokenInvalidException) {
            return response()->json(['token_invalid'], $e->getStatusCode(), $headers);
        } else if ($e instanceof Tymon\JWTAuth\Exceptions\JWTException) {
            return response()->json(['token_absent'], $e->getStatusCode(), $headers);
        } else if ($e instanceof HttpException) {
            if ($e->getStatusCode() == 403) {
                return response()->json([
                    'error' => 'No estas autorizado para realizar esta acción'
                ], 403);
            }
        }
        return parent::render($request, $e);
    }
}
