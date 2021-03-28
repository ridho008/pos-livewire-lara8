<div class="row">
   <div class="col-md-8">
      <div class="card">
         <div class="card-header"><h5>Products List</h5>
          <div class="input-group mb-3">
            <input type="text" wire:model="search" autofocus="on" autocomplete="off" class="form-control" placeholder="Search product">
            <div class="input-group-append">
              <button class="btn btn-outline-primary" type="button" id="button-addon2">Search</button>
            </div>
          </div>
         </div>
         <div class="card-body">
            <div class="row">
               @forelse($products as $product)
               <div class="col-md-3 mb-4">
                  <div class="card shadow bg-white rounded">
                    <img src="{{ asset('storage/images/'.$product->img) }}" style="object-fit: cover;width: 100%;height: 125px; object-position: center;" alt="{{ $product->name }}">
                    <div class="card-body">
                      <h5 class="card-title">{{ $product->name }}</h5>
                      {{-- <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p> --}}
                      <button wire:click="addItem({{ $product->id }})" class="btn btn-primary btn-block btn-sm">Add to Cart</button>
                    </div>
                  </div>
               </div>
               @empty
               <div class="col-md-12">
                 <h4 class="text-danger">Products not found</h4>
               </div>
               @endforelse
            </div>
            <div class="row">
              <div class="col-md-5 offset-md-5 mt-4">
                {{ $products->links() }}
              </div>
            </div>
         </div>
      </div>
   </div>
   <div class="col-md-4">
      <div class="card">
         <div class="card-header"><h5>Cart</h5></div>
         <div class="card-body">
            @if (session()->has('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif
            <table class="table table-sm table-bordered">
               <thead>
                  <tr>
                     <th>No</th>
                     <th>Name</th>
                     <th>Qty</th>
                     <th>Price</th>
                  </tr>
               </thead>
               <tbody>
                  @forelse($carts as $key => $cart)
                  <tr class="text-center">
                     <td>{{ $key + 1 }}</td>
                     <td>{{ $cart['name'] }}</td>
                     <td>
                       <button wire:click="increaseItem('{{ $cart['rowId'] }}')" class="btn-xs btn btn-success">+</button>
                       <strong><u>{{ $cart['qty'] }}</u></strong>
                       <button wire:click="decreaseItem('{{ $cart['rowId'] }}')" class="btn-xs btn btn-info">-</button>
                       <button wire:click="removeItem('{{ $cart['rowId'] }}')" class="btn-xs btn btn-danger">X</button>
                     </td>
                     <td>{{ number_format($cart['pricesingle'], 0, ',', '.') }}</td>
                  </tr>
                  @empty
                     <td colspan="3">Empty Cart</td>
                  @endforelse
               </tbody>
            </table>
         </div>
      </div>

      <div class="card mt-3">
         <div class="card-body">
          <div class="row">
            <div class="col-md-12">
              <h6 class="font-weight-bold">Cart Summary</h6>
            </div>
          </div>
            <div class="row col-md-12">
              <table class="table">
                <tr>
                  <th>Subtotal</th>
                  <td>{{ number_format($summary['subTotal'], 0, ',', '.') }}</td>
                </tr>
                <tr>
                  <th>Pajak</th>
                  <td>{{ number_format($summary['pajak'], 0, ',', '.') }}</td>
                </tr>
                <tr>
                  <th>Total</th>
                  <td>{{ number_format($summary['total'], 0, ',', '.') }}</td>
                </tr>
              </table>
            </div>
            <div class="row">
              <div class="col-md-4">
                <button wire:click="enableTax" class="btn btn-secondary btn-block">Add Tax</button>
              </div>
              <div class="col-md-4">
                <button wire:click="disableTax" class="btn btn-danger btn-block">Remove Tax</button>
              </div>
              <div class="col-md-4">
                <button class="btn btn-success btn-block">Save</button>
              </div>
            </div>
         </div>
      </div>
   </div>
</div>
