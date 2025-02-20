<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Student extends Model
{
    use HasFactory;

    // Especificamos la tabla en caso de que sea diferente
    protected $table = "student";

    // Permitimos asignación masiva
    protected $fillable = [
        'name',
        'email',
        'phone',
        'age',
        'language'
    ];

    // Indicamos que la llave primaria no es incremental y su tipo es string
    public $incrementing = false;
    protected $keyType = 'string';

    // Generar automáticamente el UUID al crear un registro
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->{$model->getKeyName()})) {
                $model->{$model->getKeyName()} = (string) Str::uuid();
            }
        });
    }
}
