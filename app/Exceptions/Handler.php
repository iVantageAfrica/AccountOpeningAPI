<?php

namespace App\Exceptions;

use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Contracts\Debug\ExceptionHandler as ExceptionHandlerContract;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Psr\Log\LogLevel;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\TooManyRequestsHttpException;
use Throwable;

class Handler extends ExceptionHandler implements ExceptionHandlerContract
{
    /**
     * A list of exception types with their corresponding custom log levels.
     *
     * @var array<class-string<Throwable>, LogLevel::*>
     */
    protected $levels = [
        // Customize log levels for exceptions here if needed
    ];

    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<Throwable>>
     */
    protected $dontReport = [
        UnauthorizedException::class,
        GuzzleException::class,
        NotFoundHttpException::class,
        HttpException::class,
        NotFound::class,
        InternalServerException::class,
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(
            function (Throwable $e) {
                // Log or perform any additional reporting here if needed
            }
        );
    }

    public function render($request, Throwable $e): JsonResponse
    {
        if ($e instanceof ValidationException) {
            return $this->validationException($e);
        }
        if ($e instanceof GuzzleException) {
            return $this->guzzleException($e);
        }
        if ($e instanceof ModelNotFoundException) {
            return $this->modelNotFoundException($e);
        }
        if ($e instanceof NotFoundHttpException) {
            return $this->notFoundHttpException($e);
        }
        if ($e instanceof NotFound) {
            return $this->notFoundException($e);
        }
        if ($e instanceof AuthenticationException) {
            return $this->authenticationException($e);
        }
        if ($e instanceof TooManyRequestsHttpException) {
            return $this->tooManyRequestsHttpException($e);
        }
        if (method_exists($e, 'render')) {
            return $e->render($request);
        }

        // Default fallback if no custom handler matches
        return $this->defaultException($e);
    }

    private function defaultException(Throwable $e): JsonResponse
    {
        Log::error($e);
        $code = $e->getCode();
        $statusCode = (is_int($code) && $code >= 100 && $code <= 599) ? $code : Response::HTTP_INTERNAL_SERVER_ERROR;
        //        $message = !app()->environment('production')  ? $e->getMessage()  : 'There was an error. Please try again later.';

        return response()->json(
            [
                'statusCode' => $statusCode,
                'message' => $e->getMessage(),
            ],
            $statusCode
        );
    }

    private function validationException(ValidationException $exception): JsonResponse
    {
        return response()->json(
            [
                'statusCode' => false,
                'message' => 'Invalid Data Provided',
                'errors' => $exception->errors(),
            ],
            Response::HTTP_EXPECTATION_FAILED
        );
    }

    private function guzzleException(GuzzleException $exception): JsonResponse
    {
        return response()->json(
            [
                'statusCode' => false,
                'message' => 'Server Error: Issue communicating with third-party.',
            ],
            Response::HTTP_INTERNAL_SERVER_ERROR
        );
    }

    private function modelNotFoundException(ModelNotFoundException $e): JsonResponse
    {
        return response()->json(
            [
                'statusCode' => false,
                'message' => 'Model Data Not Found: ' . $e->getMessage(),
            ],
            Response::HTTP_NOT_FOUND
        );
    }

    private function authenticationException(AuthenticationException $e): JsonResponse
    {
        return response()->json(
            [
                'statusCode' => false,
                'message' => $e->getMessage(),
            ],
            Response::HTTP_UNAUTHORIZED
        );
    }

    private function notFoundHttpException(NotFoundHttpException $e): JsonResponse
    {
        return response()->json(
            [
                'statusCode' => false,
                'message' => 'URL Not Found.',
            ],
            Response::HTTP_NOT_FOUND
        );
    }
    private function notFoundException(NotFound $exception): JsonResponse
    {
        return response()->json(
            [
                'statusCode' => false,
                'message' => $exception->getMessage() ?? 'Resource not found',
            ],
            Response::HTTP_NOT_FOUND
        );
    }


    private function tooManyRequestsHttpException(TooManyRequestsHttpException $e): JsonResponse
    {
        return response()->json(
            [
                'statusCode' => false,
                'message' => 'Too many attempts made. Kindly try again later.',
            ],
            Response::HTTP_TOO_MANY_REQUESTS
        );
    }
}
