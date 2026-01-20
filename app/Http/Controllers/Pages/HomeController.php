<?php

namespace App\Http\Controllers\Pages;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\Product;

class HomeController extends Controller
{
    public function render(): View
    {
        $products = Product::query()
            ->available()
            ->basicRelations()
            ->where('stock', '>', 0)
            ->latest()
            ->paginate(20);

        return view('livewire.pages.home', compact('products'));
    }
}
