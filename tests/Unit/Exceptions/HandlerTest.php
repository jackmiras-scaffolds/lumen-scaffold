<?php

use App\Models\User;
use App\Exceptions\Error;
use App\Exceptions\Handler;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;

beforeEach(function () {
    $this->handler = app(Handler::class);
    $this->request = Mockery::mock(Request::class);
});

it('expects status code 404 when validation has errors', function () {
    $validator = Mockery::mock(Validator::class);
    $validator->shouldReceive('errors')->andReturn(collect(['message']));
    $exception = new ValidationException($validator);

    $response = $this->handler->render($this->request, $exception);

    expect($response->status())->toBe(Response::HTTP_BAD_REQUEST);
});

it('expects status code 404 when model not found', function () {
    $exception = new ModelNotFoundException();
    $exception->setModel(User::class, [1]);

    $response = $this->handler->render($this->request, $exception);

    expect($response->status())->toBe(Response::HTTP_NOT_FOUND);
});

it('expects model not found error message when model not found', function () {
    $exception = new ModelNotFoundException();
    $exception->setModel(User::class, [1]);

    $error = app(Error::class);
    $error->help = trans('exception.model_not_found.help');
    $error->error = trans('exception.model_not_found.error', ['id' => 1, 'model' => 'User']);

    $response = $this->handler->render($this->request, $exception);

    expect($response->original)->toBe($error->toJson());
});

it('expects status code 404 when an internal server error', function () {
    $exception = new Exception('', Response::HTTP_INTERNAL_SERVER_ERROR);

    $response = $this->handler->render($this->request, $exception);

    expect($response->status())->toBe(Response::HTTP_BAD_REQUEST);
});

it('expects server_error error message when an internal server error', function () {
    $exception = new Exception('', Response::HTTP_INTERNAL_SERVER_ERROR);
    $error = new Error('Exception', 'server_error');

    $response = $this->handler->render($this->request, $exception);

    expect($response->original)->toBe($error->toJson());
});

it('expects response class when non-exception can be handled', function () {
    $this->request->shouldReceive('expectsJson')->andReturn(false);

    $response = $this->handler->render($this->request, new Exception());

    expect($response)->toBeInstanceOf(Response::class);
});
