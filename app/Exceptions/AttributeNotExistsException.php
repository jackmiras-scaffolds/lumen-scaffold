<?php

namespace App\Exceptions;

use Illuminate\Support\Str;
use Illuminate\Http\Response;

class AttributeNotExistsException extends ApplicationException
{
    private string $attr;
    private string $model;

    public function __construct(string $attr, string $model)
    {
        $this->attr = $attr;
        $this->model = Str::afterLast($model, '\\');
    }

    public function status(): int
    {
        return Response::HTTP_BAD_REQUEST;
    }

    public function help(): string
    {
        return trans('exception.attribute_not_exists.help');
    }

    public function error(): string
    {
        return trans('exception.attribute_not_exists.error', [
            'attr' => $this->attr,
            'model' => $this->model
        ]);
    }
}
