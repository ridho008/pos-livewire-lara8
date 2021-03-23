<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Product as ProductModel;
use Carbon\Carbon;

// Mengunakan packages https://github.com/darryldecode/laravelshoppingcart#conditions = untuk cart
class Cart extends Component
{
   public $tax = "0%";

   public function render()
   {
      $products = ProductModel::orderBy('created_at', 'desc')->get();
      $condition = new \Darryldecode\Cart\CartCondition([
          'name' => 'pajak',
          'type' => 'tax',
          'target' => 'total',
          'value' => $this->tax,
          'order' => 1
      ]);

      \Cart::session(Auth()->id())->condition($condition);
      $items = \Cart::session(Auth()->id())->getContent()->sortBy(function ($cart) {
         return $cart->attributes->get('added_at');
      });

      // jika cartnya kosong, jangan tampilkan. sebalinya tampilkan
      if(\Cart::isEmpty()) {
         $cartData = [];
      } else {
         foreach ($items as $item) {
            $cartData[] = [
               'rowId' => $item->id,
               'name' => $item->name,
               'qty' => $item->quantity,
               'pricesingle' => $item->price,
               'price' => $item->getPriceSum(),
            ];
         }
      }

      // menghitung subtotal
      $user = \Cart::session(Auth()->id());
      $subTotal = $user->getSubTotal();
      $total = $user->getTotal();

      $newCondition = $user->getCondition('pajak');
      $pajak = $newCondition->getCalculatedValue($subTotal);

      $summary = [
         'subTotal' => $subTotal,
         'pajak' => $pajak,
         'total' => $total
      ];
      // dd($cartData);
      return view('livewire.cart', [
         'products' => $products,
         'carts' => $cartData,
         'summary' => $summary
      ]);
   }

   public function addItem($id)
   {
      $rowId = "Cart".$id;
      $cart = \Cart::session(Auth()->id())->getContent();
      $cekItemId = $cart->whereIn('id', $rowId);
      // dd($cekItemId);
      if($cekItemId->isNotEmpty()) {
         \Cart::session(Auth()->id())->update($rowId, [
            'quantity' => [
               'relative' => true,
               'value' => 1
            ]
         ]);
      } else {
         $product = ProductModel::findOrFail($id);
         \Cart::session(Auth()->id())->add([
            'id' => "Cart".$product->id,
            'name' => $product->name,
            'price' => $product->price,
            'quantity' => 1,
            'attributes' => [
               'added_at' => Carbon::now()
            ]
         ]);
      }
   }

   public function enableTax()
   {
      $this->tax = "+10%";
   }

   public function disableTax()
   {
      $this->tax = "0%";
   }

   // Menambahkan jumlah item
   public function increaseItem($rowId)
   {
      $productId = substr($rowId, 4,5);
      $product = ProductModel::findOrFail($productId);
      $cart = \Cart::session(Auth()->id())->getContent();

      $getItemById = $cart->whereIn('id', $rowId);
      // cek di hal cart, batasi jumlah qtynya
      if($product->qty == $getItemById[$rowId]->quantity) {
         session()->flash('error', 'Maksimal jumlah product '. $product->name .$product->qty);
      } else {
         \Cart::session(Auth()->id())->update($rowId, [
            'quantity' => [
               'relative' => true,
               'value' => 1
            ]
         ]);

      }

   }

   // Mengurangi jumlah item
   public function decreaseItem($rowId)
   {
      $product = \Cart::session(Auth()->id())->getContent();
      $cekItemId = $product->whereIn('id', $rowId);
      // dd($cekItemId[$rowId]->quantity);

      // Jika qtynya jumlahnya 1, maka hapus product di cart
      if($cekItemId[$rowId]->quantity == 1)
      {
         \Cart::session(Auth()->id())->remove($rowId);
      } else {
         \Cart::session(Auth()->id())->update($rowId, [
            'quantity' => [
               'relative' => true,
               'value' => -1
            ]
         ]);
      }
   }

   // Menhapus item by id
   public function removeItem($rowId)
   {
      \Cart::session(Auth()->id())->remove($rowId);
   }
}
