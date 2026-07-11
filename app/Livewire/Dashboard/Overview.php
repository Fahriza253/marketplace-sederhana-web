<?php

namespace App\Livewire\Dashboard;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;
use App\Models\TransactionItem;

#[Layout('components.layouts.app')]
class Overview extends Component
{
    public function render()
    {
        $user = Auth::user();

        $productsQuery = Product::query();
        if ($user->hasRole('seller') && ! $user->hasRole('admin')) {
            $productsQuery->where('user_id', $user->id);
        }

        $total = (clone $productsQuery)->count();
        $available = (clone $productsQuery)->where('status', 'available')->count();
        $sold = (clone $productsQuery)->where('status', 'sold')->count();
        $unavailable = (clone $productsQuery)->where('status', 'unavailable')->count();

        $leadsQuery = TransactionItem::query()
            ->whereHas('transaction', fn ($q) => $q->where('channel', 'whatsapp'))
            ->whereHas('product', function ($q) use ($user) {
                if ($user->hasRole('seller') && ! $user->hasRole('admin')) {
                    $q->where('user_id', $user->id);
                }
            });

        $leads = $leadsQuery->count();

        $recent = (clone $productsQuery)
            ->basicRelations()
            ->with('category:id,name')
            ->latest()
            ->take(5)
            ->get();

        return view('livewire.dashboard.overview', compact(
            'total',
            'available',
            'sold',
            'unavailable',
            'leads',
            'recent'
        ));
    }
}
