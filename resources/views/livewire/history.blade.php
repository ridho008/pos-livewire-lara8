<div class="container">
   <div class="row">
      <div class="col-md-12">
         <div class="card">
            <div class="card-header"><h5>History</h5></div>
            <div class="card-body">
               <div class="table-responsive">
                  <table class="table table-bordered table-striped">
                     <thead>
                        <tr>
                           <th>#</th>
                           <th>Product</th>
                           <th>Quantity</th>
                           <th>Payment</th>
                           <th>Total</th>
                        </tr>
                     </thead>
                     <tbody>
                        @forelse($history as $value)
                        <tr>
                           <td>{{ $value->invoice_number }}</td>
                           <td>{{ $value->name }}</td>
                           <td>{{ $value->qty }}</td>
                           <td>{{ number_format($value->pay, 0, ',', '.') }}</td>
                           <td>{{ number_format($value->total, 0, ',', '.') }}</td>
                        </tr>
                        @empty
                        @endforelse
                     </tbody>
                  </table>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
