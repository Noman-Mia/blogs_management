<?php
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;

 function boot()
{
    Inertia::share([
        'auth' => function () {
            return [
                'user' => Auth::user(),
            ];
        },
    ]);
}
return [
    App\Providers\AppServiceProvider::class,
];
