<div class="row">
   <div class="col-md-8">
      <div class="card">
         <div class="card-header"><h5>Products List</h5></div>
         <div class="card-body">
            <div class="row">
               @foreach($products as $product)
               <div class="col-md-3">
                  <div class="card">
                    <img src="{{ asset('storage/images/'.$product->img) }}" class="card-img-top" alt="{{ $product->name }}">
                    <div class="card-body">
                      <h5 class="card-title">{{ $product->name }}</h5>
                      {{-- <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p> --}}
                      <button wire:click="addItem({{ $product->id }})" class="btn btn-primary">Add to Cart</button>
                    </div>
                  </div>
               </div>
               @endforeach
            </div>
         </div>
      </div>
   </div>
   <div class="col-md-4">
      <div class="card">
         <div class="card-header"><h5>Cart</h5></div>
         <div class="card-body">
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
                  <tr>
                     <td></td>
                     <td>{{ $cart['name'] }} || {{ $cart['qty'] }}</td>
                     <td>{{ $cart['pricesingle'] }}</td>
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
            <h4 class="font-weight-bold">Sub Total : {{ $summary['subTotal'] }}</h4>
            <h4 class="font-weight-bold">Pajak : {{ $summary['pajak'] }}</h4>
            <h4 class="font-weight-bold">Total : {{ $summary['total'] }}</h4>
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
