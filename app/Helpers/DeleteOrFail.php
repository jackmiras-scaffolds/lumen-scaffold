<?php

namespace App\Helpers;

use App\Exceptions\ModelDeletionException;

trait DeleteOrFail
{
    /**
     * Find a model by id, remove the model into the database,
     * otherwise it throws an exception.
     *
     * @param  int  $id
     * @return bool
     *
     * @throws \App\Exceptions\ModelDeletionException
     */
    public static function deleteOrFail(int $id): bool
    {
        $model = static::findOrFail($id);

        if ($model->delete() === false) {
            throw new ModelDeletionException($id, get_class($model));
        }

        return true;
    }
}
