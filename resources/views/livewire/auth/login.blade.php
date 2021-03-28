<div class="container">
   <div class="row">
      <div class="col-md-12">
         <div class="row">
            <div class="col-md-4 offset-md-4">
               <div class="card">
                  <div class="card-body">
                     <div class="row">
                        <div class="col-md-12">
                           <h4>Login</h4>
                           @if(session()->has('error'))
                           <span class="alert-danger">{{ session('error') }}</span>
                           @endif
                        </div>
                     </div>
                     <form wire:submit.prevent="submit">
                        <div class="form-group">
                           <label for="email">Email</label>
                           <input type="email" wire:model="email" id="email" class="form-control" placeholder="Email address" value="{{ old('email') }}">
                           @error('email')
                               <span class="text-danger">
                                   <strong>{{ $message }}</strong>
                               </span>
                           @enderror
                        </div>
                        <div class="form-group">
                           <label for="password">Password</label>
                           <input type="password" wire:model="password" id="password" class="form-control" placeholder="Your password">
                           @error('password')
                               <span class="text-danger">
                                   <strong>{{ $message }}</strong>
                               </span>
                           @enderror
                        </div>
                        <div class="form-group">
                           <button type="submit" class="btn btn-primary btn-block">Login</button>
                        </div>
                     </form>
                     <a href="{{ route('register') }}">Register</a>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
