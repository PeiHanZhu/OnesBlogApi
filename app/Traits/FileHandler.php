<?php

namespace App\Traits;

use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Model;

trait FileHandler
{

    public static function deleteDirectory(Model $model)
    {
        Storage::disk('public')->deleteDirectory("{$model->getTable()}/{$model->id}");
    }
}
