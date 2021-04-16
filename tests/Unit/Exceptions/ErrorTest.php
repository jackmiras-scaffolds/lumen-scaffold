<?php

use App\Exceptions\Error;

beforeEach(function () {
    $this->error = new Error();
});

it('expects help to be empty when the error constructor is empty', function () {
    expect($this->error->help)->toBe('');
});

it('expects error to be empty when error constructor is empty', function () {
    expect($this->error->error)->toBe('');
});

it('expects help to be lorem-ipsum when error property is set', function () {
    $this->error->help = 'lorem-ipsum';

    expect($this->error->help)->toBe('lorem-ipsum');
});

it('expects error to be lorem-ipsum when error property is set', function () {
    $this->error->error = 'lorem-ipsum';

    expect($this->error->error)->toBe('lorem-ipsum');
});

it('expects error to match struct when JSON serializing', function () {
    $keys = array_keys([
        'error' => '',
        'help' => ''
    ]);

    expect($this->error->jsonSerialize())->toHaveKeys($keys);
});

it('expects error to match string when to json parsed', function () {
    $json = '{"error":"","help":""}';

    expect($this->error->toJson())->toBe($json);
});

it('expects error to match structure when to array transformed', function () {
    $keys = array_keys([
        'error' => '',
        'help' => ''
    ]);

    expect($this->error->toArray())->toHaveKeys($keys);
});
