<?php

namespace App\Models\Temporal;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    // protected $table = 'users';

    // protected $fillable =['name', 'isActive'];
    protected $fillable = {!! json_encode($fillable, JSON_PRETTY_PRINT) !!};
}
