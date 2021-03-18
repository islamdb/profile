<?php

namespace App\Providers;

use Carbon\Carbon;
use Illuminate\Support\Facades\Schema;
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
        setlocale(LC_ALL, 'id_ID.utf8');
        config(['app.locale' => 'id']);
        Carbon::setLocale('id');
        date_default_timezone_set('Asia/Jakarta');

        ini_set('max_execution_time', 1200000);
        ini_set('post_max_size', '200M');
        ini_set('upload_max_filesize', '100M');

        Schema::defaultStringLength(191);

        require_once(__DIR__ . '/../Support/helpers.php');
    }
}
