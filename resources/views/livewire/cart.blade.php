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
               @if($product->qty == 0)
               <div class="col-md-3 mb-4">
                  <div class="card shadow bg-white rounded">
                    <img src="{{ asset('storage/images/'.$product->img) }}" style="object-fit: cover;width: 100%;height: 125px; object-position: center;" alt="{{ $product->name }}">
                    <div class="card-body">
                      <h5 class="card-title">{{ $product->name }}</h5>
                      <small class="text-danger">Qty sedang kosong</small>
                      <button disabled wire:click="addItem({{ $product->id }})" class="btn btn-primary btn-block btn-sm">Add to Cart</button>
                    </div>
                  </div>
               </div>
               <?php else : ?>
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
               <?php endif; ?>
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
            <form wire:submit.prevent="handleSubmit">
            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <input type="number" wire:model="payment" id="payment" class="form-control">
                  <input type="hidden" id="total" value="{{ $summary['total'] }}">
                </div>
                <div class="form-group">
                  <label>Payment</label>
                  <h3 id="paymentText" wire:ignore>Rp.0</h3>
                </div>
                <div class="form-group">
                  <label>Kembalian</label>
                  <h3 id="kembalianText" wire:ignore>Rp.0</h3>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-4">
                <button wire:click="enableTax" class="btn btn-secondary btn-block">Add Tax</button>
              </div>
              <div class="col-md-4">
                <button wire:click="disableTax" class="btn btn-danger btn-block">Remove Tax</button>
              </div>
              <div class="col-md-4">
                <button wire:ignore type="submit" id="saveButton" disabled class="btn btn-success btn-block">Save</button>
              </div>
            </div>
            </form>
         </div>
      </div>
   </div>
</div>

@push('script-custom')
<script>
  payment.oninput = () => {
    const paymentAmount = document.getElementById('payment').value;
    const totalAmount = document.getElementById('total').value;

    const kembalian = paymentAmount - totalAmount;
    // console.log(kembalian);
    document.getElementById('kembalianText').innerHTML = `Rp ${rupiah(kembalian)} ,00`;
    document.getElementById('paymentText').innerHTML = `Rp ${rupiah(paymentAmount)} ,00`;

    const saveButton = document.getElementById('saveButton');
    if(kembalian < 0) {
      saveButton.disabled = true;
    }
      saveButton.disabled = false;
  }

  const rupiah = (angka) => {
    const numberString = angka.toString();
    const split = numberString.split(',');
    const sisa = split[0].length % 3;
    let rupiah = split[0].substr(0, sisa);
    const ribuan = split[0].substr(sisa).match(/\d{1,3}/gi);

    if(ribuan) {
      const separator = sisa ? '.' : '';
      rupiah += separator + ribuan.join('.');
    }

    return split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
  }
</script>
@endpush