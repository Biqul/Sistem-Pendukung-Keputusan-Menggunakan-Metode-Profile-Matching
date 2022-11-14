<?php

namespace App\Providers;

use App\Models\User;
use App\Models\Pembukaan_seleksi;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Paginator::useBootstrap();

        Gate::define('admin', function(User $user) {
            return $user->role;
        });

        Gate::define('alternatif', function(User $user) {
            return $user->role !== 1;
        });

        $new = Pembukaan_seleksi::where('status_id', '1')->get();
        if($new->isEmpty()){
            $new = false;
            View::share('new', $new);
        }else{
            $new = true;
            View::share('new', $new);
        }
    }
}
