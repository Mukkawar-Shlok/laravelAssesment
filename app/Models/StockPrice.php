<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockPrice extends Model
{
    use HasFactory;
    //to automatically fill timestamps
    public $timestamps = true;
    //need to declare it as fillable to create and update
    protected $fillable = [
        'price',
    ];
}