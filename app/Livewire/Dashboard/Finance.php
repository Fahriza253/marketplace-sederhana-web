<?php

namespace App\Livewire\Dashboard;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Auth;
use App\Models\Transaction;

#[Layout('components.layouts.app')]
class Finance extends Component
{
    use WithPagination;

    protected $paginationTheme = 'tailwind';

    public function render()
    {
        $user = Auth::user();

        $leads = Transaction::query()
            ->with(['items.product:id,name,user_id', 'user:id,name'])
            ->where('channel', 'whatsapp')
            ->whereHas('items.product', function ($q) use ($user) {
                if ($user->hasRole('seller') && ! $user->hasRole('admin')) {
                    $q->where('user_id', $user->id);
                }
            })
            ->latest()
            ->paginate(15);

        return view('livewire.dashboard.finance', [
            'leads' => $leads,
        ]);
    }
}
