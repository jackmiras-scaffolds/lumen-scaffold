<?php

namespace App\Exceptions;

use JsonSerializable;
use Illuminate\Contracts\Support\Jsonable;
use Illuminate\Contracts\Support\Arrayable;

class Error implements Arrayable, Jsonable, JsonSerializable
{
    public string $help;
    public string $error;

    public function __construct(string $help = '', string $error = '')
    {
        $this->help = $help;
        $this->error = $error;
    }

    public function toJson($options = 0)
    {
        return (string) json_encode($this->jsonSerialize(), $options);
    }

    public function jsonSerialize(): array
    {
        return $this->toArray();
    }

    public function toArray(): array
    {
        return [
            'error' => $this->error,
            'help' => $this->help,
        ];
    }
}
