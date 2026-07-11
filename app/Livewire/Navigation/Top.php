<?php

namespace App\Livewire\Navigation;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

class Top extends Component
{
    public function getUserProperty()
    {
        return Auth::user();
    }

    public function getIsHomeProperty()
    {
        return Route::currentRouteNamed('home');
    }

    public function getBreadcrumbsProperty()
    {
        $routeName  = Route::currentRouteName();
        $params     = request()->route()?->parameters() ?? [];
        $user       = Auth::user();

        // Map route names to breadcrumb labels, parent routes, and allowed roles
        $map = [
            'products.index' => [
                [
                    'label' => 'Produk',
                    'url' => 'products.index',
                    'roles' => ['admin', 'seller'],
                ],
            ],
            'products.create' => [
                [
                    'label' => 'Produk',
                    'url' => 'products.index',
                    'roles' => ['admin', 'seller'],
                ],
                [
                    'label' => 'Tambah Produk',
                    'url' => null,
                    'roles' => ['admin', 'seller'],
                ],
            ],
            'products.edit' => [
                [
                    'label' => 'Produk',
                    'url' => 'products.index',
                    'roles' => ['admin', 'seller'],
                ],
                [
                    'label' => 'Edit Produk',
                    'url' => null,
                    'roles' => ['admin', 'seller'],
                ],
            ],
            'products.show' => [
                [
                    'label' => 'Katalog',
                    'url' => 'home',
                    'roles' => null,
                ],
                [
                    'label' => $params['product']->name ?? 'Detail Produk',
                    'url' => null,
                    'roles' => null,
                ],
            ],
            'search' => [
                [
                    'label' => 'Pencarian',
                    'url' => null,
                    'roles' => null,
                ],
            ],
            'dashboard' => [
                [
                    'label' => 'Dashboard',
                    'url' => null,
                    'roles' => ['admin', 'seller'],
                ],
            ],
            'dashboard.finance' => [
                [
                    'label' => 'Dashboard',
                    'url' => 'dashboard',
                    'roles' => ['admin', 'seller'],
                ],
                [
                    'label' => 'Finance',
                    'url' => null,
                    'roles' => ['admin', 'seller'],
                ],
            ],
        ];

        // Tidak tampilkan breadcrumbs di halaman Home
        if ($routeName === 'home' || $routeName === null) {
            return [];
        }

        // Mulai dengan Home
        $breadcrumbs = [
            [
                'label' => 'Home',
                'url' => route('home'),
            ]
        ];

        // Tambahkan breadcrumbs sesuai mapping dan role
        if (isset($map[$routeName])) {
            foreach ($map[$routeName] as $item) {
                // Jika roles di-set, cek apakah user memiliki salah satu role
                $roles = $item['roles'] ?? null;
                $allowed = $roles === null || ($user && $user->hasRole($roles));

                if ($allowed) {
                    $breadcrumbs[] = [
                        'label' => $item['label'],
                        'url' => $item['url'] ? route($item['url']) : null,
                    ];
                }
            }
        } else {
            // Default: tampilkan nama route
            $breadcrumbs[] = [
                'label' => ucfirst(str_replace('.', ' ', $routeName)),
                'url' => null,
            ];
        }

        return $breadcrumbs;
    }

    public function render()
    {
        return view('livewire.navigation.top');
    }
}
