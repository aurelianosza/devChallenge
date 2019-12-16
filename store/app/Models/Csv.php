<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Csv extends Model
{
    use SoftDeletes;

    protected $table        = 'csv';
    protected $primaryKey   = 'id';

    protected $fillable= [
        'file',
        'user_id'
    ];


}
