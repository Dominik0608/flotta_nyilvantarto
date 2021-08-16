<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    use HasFactory;

    public $timestamps = false;
    public $incrementing = false;
    protected $primaryKey  = 'id';
    protected $table = 'vehicles';

    protected $fillable = [
        'brand',
        'plate',
        'mileage',
        'status',
        'user',
    ];
}
