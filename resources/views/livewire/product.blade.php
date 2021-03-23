<div>
   <div class="row">
      {{-- Product All --}}
      <div class="col-md-8">
         <div class="card">
            <div class="card-header"><h5>Products List</h5></div>
            <div class="card-body">
               <div class="row">
                  <div class="col-md-6">
                     {{-- Massage Display --}}
                     @if (session()->has('info'))
                         <div class="alert alert-success">
                             {{ session('info') }}
                         </div>
                     @endif
                  </div>
               </div>
               <div class="table-responsive">
                  <table class="table table-striped table-bordered">
                     <thead>
                        <tr>
                           <th>No</th>
                           <th>Name</th>
                           <th>Image</th>
                           <th>Description</th>
                           <th>Quantity</th>
                           <th>Price</th>
                        </tr>
                     </thead>
                     <tbody>
                        <?php 
                        $no = 1;
                        ?>
                        @foreach($products as $key => $product)
                           <tr>
                              <td>{{ $key + $products->firstitem() }}</td>
                              <td>{{ $product->name }}</td>
                              <td>
                                 <img src="{{ asset('storage/images/'.$product->img) }}" alt="{{ $product->name }}" class="img-fluid" style="width: 200px;">
                              </td>
                              <td>{{ $product->description }}</td>
                              <td>{{ $product->qty }}</td>
                              <td>{{ $product->price }}</td>
                           </tr>
                        @endforeach
                     </tbody>
                  </table>
               </div>
               <div class="row">
                  <div class="col-md-12">
                     {{ $products->links() }}
                  </div>
               </div>
            </div>
         </div>
      </div>
      {{-- Create Product --}}
      <div class="col-md-4">
         <div class="card">
            <div class="card-header"><h5>Create Product</h5></div>
            <div class="card-body">
               <form wire:submit.prevent="store">
                  <div class="form-group">
                     <label for="name">Name</label>
                     <input type="text" wire:model="name" class="form-control">
                     @error('name') <small class="text-danger">{{ $message }}</small> @enderror
                  </div>
                  <div class="form-group">
                     <div class="custom-file">
                        <input wire:model="img" type="file" class="custom-file-input" id="customFile">
                        <label for="customFile" class="custom-file-label">Choose Image</label>
                        @error('img') <small class="text-danger">{{ $message }}</small> @enderror
                     </div>
                     @if($img)
                        <label class="mt-2">Preview Image</label>
                        <img src="{{ $img->temporaryUrl() }}" alt="Preview Img" class="img-fluid">
                     @endif
                  </div>
                  <div class="form-group">
                     <label for="description">Description</label>
                     <textarea wire:model="description" id="description" class="form-control"></textarea>
                     @error('description') <small class="text-danger">{{ $message }}</small> @enderror
                  </div>
                  <div class="form-group">
                     <label for="qty">Quantity</label>
                     <input type="number" wire:model="qty" id="qty" class="form-control">
                     @error('qty') <small class="text-danger">{{ $message }}</small> @enderror
                  </div>
                  <div class="form-group">
                     <label for="price">Price</label>
                     <input type="number" wire:model="price" id="price" class="form-control">
                     @error('price') <small class="text-danger">{{ $message }}</small> @enderror
                  </div>
                  <div class="form-group">
                     <button type="submit" class="btn btn-primary btn-block">Save</button>
                  </div>
               </form>
            </div>
         </div>
      </div>
   </div>
</div>
