<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Product as ProductModel;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Livewire\WithPagination;
class Product extends Component
{
  use WithFileUploads;
  use WithPagination;

  public $name, $img, $description, $qty, $price;
  public $paginate = 5;
    public function render()
    {
      $products = ProductModel::orderBy('created_at', 'desc')->paginate($this->paginate);
      return view('livewire.product', [
        'products' => $products
      ]);
    }

  public function previewImg()
  {
    $this->validate([
      'img' => 'image|max:2048'
    ]);
  }

  public function store()
  {
    $this->validate([
      'name' => 'required',
      'img' => 'image|max:2048',
      'description' => 'required',
      'qty' => 'required',
      'price' => 'required',
    ]);

    $imgName = md5($this->img.microtime(). '.'. $this->img->extension());

    Storage::putFileAs(
      'public/images',
      $this->img,
      $imgName
    );

    ProductModel::create([
      'name' => $this->name,
      'img' => $imgName,
      'description' => $this->description,
      'qty' => $this->qty,
      'price' => $this->price
    ]);

    session()->flash('info', 'Product Created Successfully.');

    // setelah berhasil buat product baru, kosongkan inputannya.
    $this->name = '';
    $this->img = '';
    $this->description = '';
    $this->qty = '';
    $this->price = '';
  }
}
