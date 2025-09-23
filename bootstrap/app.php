<?php

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Illuminate\Session\TokenMismatchException;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        //
    })
    ->withExceptions(function (Exceptions $exceptions): void {

        $sendError = function ($errors, $message, $code) {
            return response()->json([
                'status' => 'false',
                'message' => $errors,
                'statuscode' => $code,
            ], $code);
        };

        $sendError = function ($errors, $message, $code) {
            return response()->json([
                'status' => 'false',
                'message' => $errors,
                'statuscode' => $code,
            ], $code);
        };

        $exceptions->render(function (Throwable $exception, Request $request) use ($sendError) {

            if($exception instanceof AuthenticationException) {
                if($exception->guards() === ['api']) {
                    return $sendError($exception->getMessage(), '', 401);
                }
            }

            if($exception instanceof ValidationException) {
                $errors = $exception->validator->errors()->getMessages();
                $validationError = [];
                foreach($errors as $error) {
                    // \Log::info($error);
                    array_push($validationError, $error[0]);
                }
                return $sendError($validationError, '', 422);
            }

            if($exception instanceof AuthorizationException) {
                return $sendError('Та энэ үйлдлийг хийх эрхгүй байна.', '', 403);
            }

            if($exception instanceof MethodNotAllowedHttpException) {
                return $sendError('Not allowed method for the request', '', 405);
            }

            if($exception instanceof TokenMismatchException) {
                return $sendError($exception->getMessage(),'',200);
            }

            if($exception instanceof TokenInvalidException) {
                return $sendError($exception->getMessage(),'',401);
            }

            if($exception instanceof NotFoundHttpException) {
                return $sendError('Not found url', '', 404);
            }

            if($exception instanceof HttpException) {
                return $sendError($exception->getMessage(), '', $exception->getStatusCode());
            }

            if(config('app.debug')) {
                return parent::render($request, $exception);
            }
            
            if($exception instanceof QueryException) {
                $errorCode = $exception->errorInfo[1];
                if($errorCode == 1451) {
                    return $sendError('Cannot remove this resource permanently, It is related with any other resource','', 409);
                }
            }

            return $sendError('Unexpected exception, Try later', '', 500);
        });

    })->create();
