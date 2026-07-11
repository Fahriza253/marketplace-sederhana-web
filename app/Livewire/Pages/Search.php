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

    #[Url]
    public string $condition = '';

    #[Url]
    public string $brand = '';

    #[Url]
    public string $min_price = '';

    #[Url]
    public string $max_price = '';

    public function updatingKeyword(): void
    {
        $this->resetPage();
    }

    public function updatingCondition(): void
    {
        $this->resetPage();
    }

    public function updatingBrand(): void
    {
        $this->resetPage();
    }

    public function updatingMinPrice(): void
    {
        $this->resetPage();
    }

    public function updatingMaxPrice(): void
    {
        $this->resetPage();
    }

    public function clearFilters(): void
    {
        $this->reset(['keyword', 'condition', 'brand', 'min_price', 'max_price']);
        $this->resetPage();
    }

    public function render()
    {
        $driver = Product::query()->getConnection()->getDriverName();
        $like = $driver === 'pgsql' ? 'ilike' : 'like';

        $products = Product::query()
            ->available()
            ->basicRelations()
            ->with('vehicle')
            ->where('stock', '>', 0)
            ->when($this->keyword !== '', function ($query) use ($like) {
                $term = '%'.$this->keyword.'%';
                $query->where(function ($q) use ($like, $term) {
                    $q->where('name', $like, $term)
                        ->orWhere('description', $like, $term)
                        ->orWhereHas('vehicle', function ($vq) use ($like, $term) {
                            $vq->where('brand', $like, $term)
                                ->orWhere('model', $like, $term);
                        });
                });
            })
            ->when($this->condition !== '', fn ($q) => $q->where('condition', $this->condition))
            ->when($this->brand !== '', function ($query) use ($like) {
                $query->whereHas('vehicle', function ($vq) use ($like) {
                    $vq->where('brand', $like, '%'.$this->brand.'%');
                });
            })
            ->when($this->min_price !== '' && is_numeric($this->min_price), fn ($q) => $q->where('price', '>=', $this->min_price))
            ->when($this->max_price !== '' && is_numeric($this->max_price), fn ($q) => $q->where('price', '<=', $this->max_price))
            ->latest()
            ->paginate(20);

        return view('livewire.pages.search', [
            'products' => $products,
        ]);
    }
}
