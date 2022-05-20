<?php

namespace App\Exceptions;

use Throwable;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Config;
class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        \Illuminate\Auth\AuthenticationException::class,
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
     * @param  \Exception  $exception
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \Exception
     */
    public function render($request, Throwable $exception)
    { 
        return parent::render($request, $exception);
        if ($request->wantsJson()) { 
            if ($exception instanceof \Illuminate\Auth\AuthenticationException ) {
                return response()->json(
                    [
                        Config::get('constants.key.status') => Config::get('constants.value.failure'),
                        Config::get('constants.key.message') => Config::get('constants.value.unauthenticated')
                    ], Config::get('constants.key.401'));
            } 
            return $this->handleApiException($request, $exception);
        } 
        else
        {  
            return $this->handleWebException($request, $exception);             
        } 
    }

    private function handleApiException($request, Exception $exception)
    {
        $exception = $this->prepareException($exception); 
        return $this->customApiResponse($exception);
    }

    private function customApiResponse($exception)
    {
        if (method_exists($exception, 'getStatusCode')) { 
            $statusCode = $exception->getStatusCode();
        } else {
            $statusCode = 500;
        }
        
        $response = [];

        switch ($statusCode) {
            case 401:
                $response['message'] = 'Unauthorized';
                break;
            case 403:
                $response['message'] = 'Forbidden';
                break;
            case 404:
                $response['message'] = 'Not Found';
                break;
            case 405:
                $response['message'] = 'Method Not Allowed';
                break;
            case 422:
                $response['message'] = $exception->original['message'];
                $response['errors'] = $exception->original['errors'];
                break;
            default:
                $response['message'] = ($statusCode == 500) ? 'Whoops, looks like something went wrong' : $exception->getMessage();
                break;
        }

        if (config('app.debug')) {
            //$response['trace'] = $exception->getTrace();
            //$response['code'] = $exception->getCode();
        }

        $response['status'] = $statusCode;

        return response()->json($response, $statusCode);
    }

    private function handleWebException($request, Exception $exception){ 
        $exception = $this->prepareException($exception); 
        return $this->customWebResponse($exception);
    }

    private function customWebResponse($exception)
    {
        if (method_exists($exception, 'getStatusCode')) { 
            $statusCode = $exception->getStatusCode();
        } else {
            $statusCode = 500;
        }
        
        $response = [];

        switch ($statusCode) {
            case 401:
                $response['message'] = 'Unauthorized';
                break;
            case 403:
                $response['message'] = 'Forbidden';
                break;
            case 404:
                $response['message'] = 'Not Found';
                break;
            case 405:
                $response['message'] = 'Method Not Allowed';
                break;
            case 422:
                $response['message'] = $exception->original['message'];
                $response['errors'] = $exception->original['errors'];
                break;
            default:
                $response['message'] = ($statusCode == 500) ? 'Whoops, looks like something went wrong' : $exception->getMessage();
                break;
        }

        if (config('app.debug')) {
            //$response['trace'] = $exception->getTrace();
            //$response['code'] = $exception->getCode();
        }

        $response['status'] = $statusCode;
        return \Response::view('admin.404',$response,500);
        //return view('admin.404', $response );  
        //return response()->json($response, $statusCode);
    }
}
