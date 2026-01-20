<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\Product;

class ProductDetailController extends Controller
{
    public function __invoke(Product $product)
    {
        abort_if(
            $product->status !== 'available' || $product->stock < 1,
            404
        );

        return view('livewire.pages.product-details', compact('product'));
    }
}
