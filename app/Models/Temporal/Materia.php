<?php

namespace App\Models\Temporal;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Materia extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    // protected $table = 'table_name';

    protected $fillable =['name', 'isActive'];
}
