<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Model::creating(function ($model) {
        if ($model->getTable() === 'organisations') {
            logger()->error('ORGANISATION MUTATION', [
                'attributes' => $model->getAttributes(),
                'trace' => collect(debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS))
                            ->take(10)
                            ->toArray(),
            ]);
        }
    });
    }
}
