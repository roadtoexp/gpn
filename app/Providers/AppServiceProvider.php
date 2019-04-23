<?php

namespace App\Providers;

use App\Http\Models\Repositories\BillRepository;
use App\Http\Models\Repositories\BillStatusRepository;
use App\Http\Models\Repositories\CardRepository;
use App\Http\Models\Repositories\CardTypeRepository;
use App\Http\Models\Repositories\EloquentBillRepository;
use App\Http\Models\Repositories\EloquentBillStatusRepository;
use App\Http\Models\Repositories\EloquentCardRepository;
use App\Http\Models\Repositories\EloquentCardTypeRepository;
use App\Http\Models\Repositories\EloquentSessionRepository;
use App\Http\Models\Repositories\EloquentUserRepository;
use App\Http\Models\Repositories\SessionRepository;
use App\Http\Models\Repositories\UserRepository;
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
        if ($this->app->environment() !== 'production') {
            $this->app->register(\Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider::class);
        }
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->bind(UserRepository::class, EloquentUserRepository::class);
        $this->app->bind(BillRepository::class, EloquentBillRepository::class);
        $this->app->bind(CardRepository::class, EloquentCardRepository::class);
        $this->app->bind(SessionRepository::class, EloquentSessionRepository::class);
        $this->app->bind(BillStatusRepository::class, EloquentBillStatusRepository::class);
        $this->app->bind(CardTypeRepository::class, EloquentCardTypeRepository::class);
    }
}
