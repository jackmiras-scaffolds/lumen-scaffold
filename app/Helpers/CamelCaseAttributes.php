<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use App\Exceptions\AttributeNotExistsException;

trait CamelCaseAttributes
{
    /**
     * Get an attribute from the model.
     *
     * @param  string  $key
     * @return mixed
     */
    public function getAttribute($key)
    {
        $this->validateProperty(Str::snake($key));
        return parent::getAttribute(Str::snake($key));
    }

    /**
     * Set a given attribute on the model.
     *
     * @param  string  $key
     * @param  mixed  $value
     * @return mixed
     */
    public function setAttribute($key, $value)
    {
        $this->validateProperty(Str::snake($key));
        return parent::setAttribute(Str::snake($key), $value);
    }

    /**
     * Validate that a given attribute exists on the model.
     *
     * @param  string  $key
     * @return void
     *
     * @throws \App\Exceptions\AttributeNotExistsException
     */
    private function validateProperty(string $key): void
    {
        if (in_array(Str::snake($key), $this->properties()) === false) {
            throw new AttributeNotExistsException($key, get_class($this));
        }
    }

    /**
     * Merge into an array the main source of attributes of a model.
     *
     * @return array
     */
    private function properties(): array
    {
        return array_merge(
            $this->appends,
            $this->attributes,
            Schema::getColumnListing($this->getTable())
        );
    }
}
