<?php

namespace App\Traits;

use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Model;

trait FileHandler
{
    /**
     * Delete images directory for the model from the server.
     *
     * @param Model $model
     */
    public static function deleteDirectory(Model $model)
    {
        Storage::disk('public')->deleteDirectory("{$model->getTable()}/{$model->id}");
    }
}
