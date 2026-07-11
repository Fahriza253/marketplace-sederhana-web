<?php

namespace App\Livewire\Product;

use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;

class Index extends Component
{
    use WithPagination;
    protected $paginationTheme = 'tailwind';

    public $status   = '';
    public $category = '';
    public $sort     = 'latest';

    protected $queryString = [
        'status'   => ['except' => ''],
        'category' => ['except' => ''],
        'sort'     => ['except' => 'latest'],
    ];

    public function applyFilter()
    {
        $this->resetPage();
    }

    public function delete($id)
    {
        $product = Product::findOrFail($id);

        $user = auth()->user();
        if ($user->hasRole('seller') && ! $user->hasRole('admin') && $product->user_id !== $user->id) {
            abort(403);
        }

        $product->delete();
    }

    public function render()
    {
        $user = Auth::user();

        $query = Product::query()
            ->basicRelations()
            ->with('category:id,name');

        if ($user->hasRole('seller') && ! $user->hasRole('admin')) {
            $query->where('user_id', $user->id);
        }

        // Filter: status
        if ($this->status !== '') {
            $query->where('status', $this->status);
        }

        // Filter: category
        if ($this->category !== '') {
            $query->where('category_id', $this->category);
        }

        // Sorting
        match ($this->sort) {
            'oldest' => $query->oldest(),
            default  => $query->latest(),
        };

        return view('livewire.product.index', [
            'products' => $query->paginate(10),
        ]);
    }
}
