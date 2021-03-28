<?php

namespace App\Http\Livewire\Auth;

use Livewire\Component;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class Login extends Component
{
   // public $form = [
   //    'email' => '',
   //    'password' => '',
   // ];

   public $email, $password;

   public function submit()
   {
      $this->validate([
         'email' => 'required|email',
         'password' => 'required',
      ]);

      $user = User::where([
         'email' => $this->email,
      ])->get();

      if(count($user) > 0 && Auth::attempt(['email' => $this->email, 'password' => $this->password])) {
         redirect()->route('home');
      } else {
         session()->flash('error', 'Your credentials does not math, Please Try again later.');
      }
   }
   
   public function render()
   {
      return view('livewire.auth.login');
   }
}
