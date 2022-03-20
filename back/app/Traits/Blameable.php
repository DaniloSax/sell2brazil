<?php

namespace App\Traits;

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Auth;

trait Blameable
{
    public static function bootBlameable()
    {
        if (Auth::check()) {

            static::creating(function ($model) {
                if (array_key_exists('deleted_by', $model->attributes)) {
                    $model->created_by = Auth::id();
                    $model->updated_by = Auth::id();
                }
            });

            static::updating(function ($model) {
                if (array_key_exists('deleted_by', $model->attributes)) {
                    $model->updated_by = Auth::id();
                }
            });

            static::deleting(function ($model) {
                if (array_key_exists('deleted_by', $model->attributes)) {
                    $model->deleted_by = Auth::id();
                    $model->save();
                }
            });
        }
    }
}
