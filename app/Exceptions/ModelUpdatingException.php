<?php

namespace App\Exceptions;

use Illuminate\Support\Str;
use Illuminate\Http\Response;

class ModelUpdatingException extends ApplicationException
{
    private int $id;
    private string $model;

    public function __construct(int $id, string $model)
    {
        $this->id = $id;
        $this->model = Str::afterLast($model, '\\');
    }

    public function status(): int
    {
        return Response::HTTP_BAD_REQUEST;
    }

    public function help(): string
    {
        return trans('exception.model_not_updated.help');
    }

    public function error(): string
    {
        return trans('exception.model_not_updated.error', [
            'id' => $this->id,
            'model' => $this->model
        ]);
    }
}
