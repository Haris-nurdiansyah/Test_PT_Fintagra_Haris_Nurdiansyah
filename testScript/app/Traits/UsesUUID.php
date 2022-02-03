<?php

namespace App\Traits;

use Illuminate\Support\Str;

/**
 *
 */
trait UsesUUID {

    public function getKeyType()
    {
        return 'string';
    }

    public function getIncrementing()
    {
        return false;
    }

    protected static function boot() {
        parent::boot();

        static::creating(function ($model)
        {
            if (empty($model->{$model->getKeyName})) {
                $model->{$model->getKeyName()} = Str::uuid();
            }
        });
    }

}


?>
