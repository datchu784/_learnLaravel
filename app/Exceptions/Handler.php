<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\RelationNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Validation\UnauthorizedException;
use Illuminate\Support\Facades\Log;
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
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        $this->reportable(function (Throwable $e) {
            //
        });

        $this->renderable(function (Throwable $e, $request) {
            Log::debug($e);
            if ($request->is('api/*')) {
                return $this->handleApiException($e, $request);
            }
        });
    }

    private function handleApiException(Throwable $e, $request)
    {
        if ($e instanceof ValidationException) {
            return response()->json([
                'message' => 'The given data was invalid.',
                'errors' => $e->validator->errors()->getMessages()
            ], 422);
        }

        if ($e instanceof \InvalidArgumentException) {
            return response()->json([
                'message' => 'Invalid data from client side',
                'error' => $e->getMessage(),
            ], 400);
        }

        if ($e instanceof AuthorizationException) {
            return response()->json([
                'message' => 'Not authorized to request.',
                'error' => $e->getMessage()
            ], 403);
        }
        if ($e instanceof UnauthorizedException) {
            return response()->json([
                'message' => 'Not authenticated.',
                'error' => $e->getMessage()
            ], 401);
        }
        if ($e instanceof QueryException) {
            return response()->json([
                'message' => 'An error occurred during a database query..',
                'error' => $e->getMessage()
            ], 500);
        }
        if ($e instanceof RelationNotFoundException) {
            return response()->json([
                'message' => 'Relation Not Found',
                'error' => $e->getMessage()
            ], 404);
        }

        if ($e instanceof ModelNotFoundException) {
            return response()->json([
                'message' => 'Resource not found in database.'
            ], 404);
        }

        if ($e instanceof NotFoundHttpException) {
            return response()->json([
                'message' => 'The requested resource was not found.',
                'error' => $e->getMessage()
            ], 404);
        }
        return response()->json([
            'message' => 'Front-end Error.',
            'error' => $e->getMessage()
        ], 400);
    }
}
