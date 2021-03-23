<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class StorefrontsServiceProvider extends ServiceProvider {
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot() {
            //
    }

    /**
     * Register any application services.
     *
     * This service provider is a great spot to register your various container
     * bindings with the application. As you can see, we are registering our
     * "Registrar" implementation here. You can add your own bindings too!
     *
     * @return void
     */
    public function register() {
        $this->app->bind('paginationHelper', 'App\Http\Helpers\PaginationHelper');
        $this->app->bind('sortfilterHelper', 'App\Http\Helpers\SortFilterHelper');
        $this->app->bind('ShoppingCartHelper', 'App\Http\Helpers\ShoppingCartHelper');
        $this->app->bind('CronHelper', 'App\Http\Helpers\CronHelper');
        $this->app->bind('lookupHelper', 'App\Http\Helpers\LookupHelper');
        $this->app->bind('imageHelper', 'App\Http\Helpers\ImageHelper');
        $this->app->bind('EcocashHelper', 'App\Http\Helpers\EcocashHelper');
        $this->app->bind('ProductSyncHelper',  'App\Http\Helpers\ProductSyncHelper');
        $this->app->bind('NotificationHelper', 'App\Http\Helpers\NotificationHelper');
        
        
    }
}