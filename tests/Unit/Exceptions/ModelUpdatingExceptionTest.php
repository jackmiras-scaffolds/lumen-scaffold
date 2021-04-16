<?php

namespace Tests\Unit\Exceptions;

use Illuminate\Support\Str;
use Illuminate\Http\Response;
use App\Exceptions\ModelUpdatingException;

beforeEach(function () {
    $this->id = 1;
    $this->model = 'App\Models\User';
    $this->exception = new ModelUpdatingException($this->id, $this->model);
});

it('expects render to return a response instance when invoked', function () {
    $response = $this->exception->render(request());

    expect($response)->toBeInstanceOf(Response::class);
});

it('expects status code 400 when an exception is thrown', function () {
    $status = $this->exception->status();

    expect($status)->toBe(Response::HTTP_BAD_REQUEST);
});

it('expects help to be anonymous help when an exception is thrown', function () {
    $help = $this->exception->help();

    expect($help)->toBe(trans('exception.model_not_updated.help'));
});

it('expects error to be an anonymous error when an exception is thrown', function () {
    $error = $this->exception->error();
    $replace = ['id' => $this->id, 'model' => Str::afterLast($this->model, '\\')];

    expect($error)->toBe(trans('exception.model_not_updated.error', $replace));
});
