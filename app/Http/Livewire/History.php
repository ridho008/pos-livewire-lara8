<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\User;
use App\Models\PruductTransaction;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;

class History extends Component
{
   public function render()
   {
      $user = Auth::id();
      $history = Transaction::where('user_id', $user)
                     ->join('products_transactions', 'transactions.invoice_number', '=', 'products_transactions.invoice_number')
                     ->join('products', 'products_transactions.product_id', '=', 'products.id')
                     ->where('products_transactions.invoice_number', 'INV-000001')
                     ->get();
      // dd($transaction);
      // $history = PruductTransaction::where('invoice_number', $transaction->product->invoice_number);
      
      // dd($transaction->product);
      // $history = Transaction::where('user_id', $user)->get();
      return view('livewire.history', [
         'history' => $history,
      ]);
   }
}
