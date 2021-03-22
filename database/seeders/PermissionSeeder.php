<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $resources = collect(File::allFiles(base_path('app/Orchid/Resources')))
            ->map(function (\SplFileInfo $file) {
                $name = str_replace('Resource.php', '', $file->getFilename());
                $name = Str::snake($name, ' ');

                $permissions = [];
                foreach (['browse', 'read', 'edit', 'add', 'delete'] as $item) {
                    $permissions[] = [
                        'group' => Str::title($name),
                        'slug' => str_replace(' ', '-', $name.'.'.$item),
                        'name' => ucfirst($item).' '.$name,
                        'created_at' => now(),
                        'updated_at' => now()
                    ];
                }

                return $permissions;
            })
            ->flatten(1)
            ->toArray();

        Permission::query()
            ->insert($resources);
    }
}
