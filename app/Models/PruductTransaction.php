<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PruductTransaction extends Model
{
   protected $table = 'products_transactions';
   protected $fillable = ['product_id', 'invoice_number', 'qty'];
   use HasFactory;

   public function product()
   {
      return $this->belongsTo(Product::class);
   }
}
