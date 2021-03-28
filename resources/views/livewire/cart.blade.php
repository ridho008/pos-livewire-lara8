<div class="row">
   <div class="col-md-8">
      <div class="card">
         <div class="card-header"><h5>Products List</h5>
          <div class="input-group mb-3">
            <input type="text" wire:model="search" class="form-control" placeholder="Search product">
            <div class="input-group-append">
              <button class="btn btn-outline-secondary" type="button" id="button-addon2">Search</button>
            </div>
          </div>
         </div>
         <div class="card-body">
            <div class="row">
               @forelse($products as $product)
               <div class="col-md-3">
                  <div class="card">
                    <img src="{{ asset('storage/images/'.$product->img) }}" style="object-fit: contain;width: 100%;height: 125px;" alt="{{ $product->name }}">
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
                     <th>Price</th>
                  </tr>
               </thead>
               <tbody>
                  @forelse($carts as $key => $cart)
                  <tr class="text-center">
                     <td>{{ $key + 1 }}</td>
                     <td>{{ $cart['name'] }}<br> Qty <strong>{{ $cart['qty'] }}</strong>
                        <button wire:click="increaseItem('{{ $cart['rowId'] }}')" class="btn-xs">+</button>
                        <button wire:click="decreaseItem('{{ $cart['rowId'] }}')" class="btn-xs">-</button>
                        <button wire:click="removeItem('{{ $cart['rowId'] }}')" class="btn-xs">X</button>
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

      <div class="card">
         <div class="card-body">
            <h4 class="font-weight-bold">Cart Summary</h4>
            <h4 class="font-weight-bold">Sub Total : {{ number_format($summary['subTotal'], 0, ',', '.') }}</h4>
            <h4 class="font-weight-bold">Pajak : {{ number_format($summary['pajak'], 0, ',', '.') }}</h4>
            <h4 class="font-weight-bold">Total : {{ number_format($summary['total'], 0, ',', '.') }}</h4>
            <div>
               <button wire:click="enableTax" class="btn btn-secondary btn-block">Add Tax</button>
               <button wire:click="disableTax" class="btn btn-danger btn-block">Remove Tax</button>
            </div>
            <div class="mt-2">
               <button class="btn btn-success btn-block">Save</button>
            </div>
         </div>
      </div>
   </div>
</div>
