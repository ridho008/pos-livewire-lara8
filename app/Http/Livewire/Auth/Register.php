<?php

namespace App\Http\Livewire\Auth;

use Livewire\Component;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class Register extends Component
{
   // public $form = [
   //    'name' => '',
   //    'email' => '',
   //    'password' => '',
   //    'password_confirmation' => '',
   // ];

   public $name, $email, $password, $password_confirmation;

   public function render()
   {
      return view('livewire.auth.register');
   }

   public function submit()
   {
      $this->validate([
         'name' => 'required',
         'email' => 'required|email|unique:users,email',
         'password' => 'required|confirmed',
      ]);

      User::create([
         'name' => $this->name,
         'email' => $this->email,
         'password' => Hash::make($this->password),
      ]);

      return redirect()->route('login');
   }
}
