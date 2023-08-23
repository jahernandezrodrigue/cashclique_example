<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TemporalUno/User extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'tipos';

    protected $fillable = ['producto_referencia','producto_serie_texto','producto_nombreÍndice','producto_activo','producto_serie','producto_modeloÍndice','producto_codigo','producto_costo','producto_precio','producto_contador','producto_numero_parte'];
}
