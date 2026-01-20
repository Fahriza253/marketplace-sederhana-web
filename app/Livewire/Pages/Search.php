<?php

namespace App\Livewire\Pages;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Product;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Url;

#[Layout('components.layouts.app')]
class Search extends Component
{
    use WithPagination;

    protected $paginationTheme = 'tailwind';

    #[Url(as: 'q')]
    public string $keyword = '';

    public function updatingKeyword(): void
    {
        // reset pagination when keyword changes
        $this->resetPage();
    }

    public function render()
    {
        $products = Product::query()
            ->available()
            ->basicRelations()
            ->where('stock', '>', 0)
            ->when($this->keyword, function ($query) {
                $query->where(function ($q) {
                    $q->where('name', 'ilike', '%' . $this->keyword . '%')
                      ->orWhere('description', 'ilike', '%' . $this->keyword . '%');
                });
            })
            ->latest()
            ->paginate(20);

        return view('livewire.pages.search', [
            'products' => $products,
        ]);
    }
}
