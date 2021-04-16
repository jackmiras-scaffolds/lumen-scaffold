<?php

namespace App\Exceptions;

use Throwable;
use Illuminate\Support\Arr;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Laravel\Lumen\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\HttpException;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        AuthorizationException::class,
        HttpException::class,
        ModelNotFoundException::class,
        ValidationException::class,
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
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
     * @param  \Throwable  $e
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \Throwable
     */
    public function render($request, Throwable $e)
    {
        if ($e instanceof ValidationException) {
            $error = new Error();
            $error->help = $e->validator->errors()->first();
            $error->error = trans('exception.data_validation');

            return response($error->toJson(), Response::HTTP_BAD_REQUEST);
        }

        if ($e instanceof ModelNotFoundException) {
            $ids = $e->getIds();

            $replacement = [
                'id' => is_int($ids) ? $ids : Arr::first($ids),
                'model' => Arr::last(explode('\\', $e->getModel())),
            ];

            $error = app(Error::class);
            $error->help = trans('exception.model_not_found.help');
            $error->error = trans('exception.model_not_found.error', $replacement);

            return response($error->toJson(), Response::HTTP_NOT_FOUND);
        }

        if ($e->getCode() === Response::HTTP_INTERNAL_SERVER_ERROR) {
            $error = app(Error::class);
            $error->error = 'server_error';
            $error->help = $e->getMessage() ?: get_class($e);

            return response($error->toJson(), Response::HTTP_BAD_REQUEST);
        }

        return parent::render($request, $e);
    }
}
