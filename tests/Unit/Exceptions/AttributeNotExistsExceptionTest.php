<?php

namespace Tests\Unit\Exceptions;

use Illuminate\Support\Str;
use Illuminate\Http\Response;
use App\Exceptions\AttributeNotExistsException;

beforeEach(function () {
    $this->attr = 'unexistent_attribute';
    $this->model = 'App\Models\User';
    $this->exception = new AttributeNotExistsException($this->attr, $this->model);
});

it('expects render to return a response instance when invoked', function () {
    $response = $this->exception->render(request());

    expect($response)->toBeInstanceOf(Response::class);
});

it('expects status code 400 when an exception is thrown', function () {
    $status = $this->exception->status();

    expect($status)->toBe(Response::HTTP_BAD_REQUEST);
});

it('expects help to be anonymous help when expection is thrown', function () {
    $help = $this->exception->help();

    expect($help)->toBe(trans('exception.attribute_not_exists.help'));
});

it('expects error to be anonymous error when expection is thrown', function () {
    $error = $this->exception->error();
    $replace = ['attr' => $this->attr, 'model' => Str::afterLast($this->model, '\\')];

    expect($error)->toBe(trans('exception.attribute_not_exists.error', $replace));
});
