<?php

namespace App\Providers;

use App\Models\Permission;
use App\Support\MyField;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
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
        if (Schema::hasTable('permissions')) {
            $permissionGroups = Permission::query()
                ->select(['group', 'slug', 'name'])
                ->get()
                ->groupBy('group');

            foreach ($permissionGroups as $group => $permissionGroup) {
                $itemPermission = ItemPermission::group($group);
                foreach ($permissionGroup as $permission) {
                    $itemPermission->addPermission($permission->slug, $permission->name);
                }
                $dashboard->registerPermissions($itemPermission);
            }
        }
    }
}
