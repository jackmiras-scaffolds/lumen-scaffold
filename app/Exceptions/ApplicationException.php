<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

abstract class ApplicationException extends Exception
{
    abstract public function status(): int;

    abstract public function help(): string;

    abstract public function error(): string;

    /**
    * @SuppressWarnings(PHPMD.UnusedFormalParameter)
    */
    public function render(Request $request): Response
    {
        $error = new Error();
        $error->help = $this->help();
        $error->error = $this->error();

        return response($error->toArray(), $this->status());
    }
}
