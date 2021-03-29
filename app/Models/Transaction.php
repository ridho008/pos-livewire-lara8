<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
   protected $table = 'transactions';
   use HasFactory;

   public function product()
   {
      return $this->hasMany(ProductTransaction::class, 'invoice_number', 'invoice_number');
   }

   public function user()
   {
      return $this->belongsTo(User::class);
   }
}
