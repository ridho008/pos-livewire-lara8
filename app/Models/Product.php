<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
   protected $fillable = ['name', 'img', 'description', 'qty', 'price'];
    use HasFactory;
}
