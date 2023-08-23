<?php

namespace App\Models\Temporal;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    // protected $table = 'table_name';

    protected $fillable =[
        'name', 
        'surname',
        'phone',
        'email',
        'isActive'
    ];
            
}
