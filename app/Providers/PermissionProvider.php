<?php

namespace App\Providers;

use App\Models\Permission;
use App\Support\MyField;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
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
     * @param Dashboard $dashboard
     * @return void
     */
    public function boot(Dashboard $dashboard)
    {
        // Resource permissions
        collect(File::allFiles(base_path('app/Orchid/Resources')))
            ->map(function (\SplFileInfo $file) {
                $name = str_replace('Resource.php', '', $file->getFilename());
                $name = Str::snake($name, ' ');

                $permissions = [];
                foreach (['menu', 'browse', 'read', 'edit', 'add', 'delete'] as $item) {
                    $permissions[] = (object)[
                        'group' => Str::title($name),
                        'slug' => str_replace(' ', '-', $name.'.'.$item),
                        'name' => ucfirst($item).' '.$name,
                    ];
                }

                return $permissions;
            })
            ->flatten(1)
            ->groupBy('group')
            ->each(function (Collection $permissions, $group) use ( &$dashboard) {
                $itemPermission = ItemPermission::group($group);
                $permissions->each(function ($permission) use (&$itemPermission) {
                    $itemPermission->addPermission($permission->slug, $permission->name);
                });
                $dashboard->registerPermissions($itemPermission);
            });
    }
}
