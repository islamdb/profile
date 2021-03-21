<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Orchid\Platform\Dashboard;
use Orchid\Platform\ItemPermission;

class PermissionProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot(Dashboard $dashboard)
    {
        $dashboard->registerPermissions(
            ItemPermission::group('Slider')
                ->addPermission('slider.browse', 'Browse Slider')
                ->addPermission('slider.read', 'Read Slider')
                ->addPermission('slider.edit', 'Edit Slider')
                ->addPermission('slider.add', 'Add Slider')
                ->addPermission('slider.delete', 'Delete Slider')
        );
    }
}
