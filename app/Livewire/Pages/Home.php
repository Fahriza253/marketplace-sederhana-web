<?php

namespace App\Livewire\Pages;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Product;
use Livewire\Attributes\Layout;

#[Layout('components.layouts.app')]
class Home extends Component
{
    use WithPagination;

    protected $paginationTheme = 'tailwind';

    public function render()
    {
        return view('livewire.pages.home', [
            'products' => Product::query()
                ->available()
                ->basicRelations()
                ->where('stock', '>', 0)
                ->latest()
                ->paginate(100),
        ]);
    }
}
