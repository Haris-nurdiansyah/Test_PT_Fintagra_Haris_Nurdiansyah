<?php

namespace App\Models;

use App\Traits\UsesUUID;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Epresence extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $keyType = 'string';
    public $incrementing = false;

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model)
        {
            if (empty($model->{$model->getKeyName})) {
                $model->{$model->getKeyName()} = Str::uuid();
            }
        });

        static::creating(function ($model)
        {
            date_default_timezone_set('Asia/Jakarta');
            $model->is_approve = false;
            $model->waktu = Carbon::now();
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getDateAttribute()
    {
        return Carbon::parse($this->waktu)->format('Y-m-d');
    }
}
