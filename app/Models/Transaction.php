<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
   protected $table = 'transactions';
   protected $primaryKey = 'invoice_number';
   public $incrementing = false;
   protected $keyType = 'string';
   protected $fillable = ['invoice_number', 'user_id', 'pay', 'total'];
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
