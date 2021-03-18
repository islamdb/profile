<?php

namespace Database\Seeders;

use App\Models\Page;
use Faker\Factory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Factory::create('id_ID');

        DB::beginTransaction();

        $data = [];
        for ($c = 0; $c < rand(2, 5); $c++){
            $data[] = [
                'title' => $title = Str::title($faker->realText(rand(20, 40))),
                'image' => $faker->imageUrl(640, 380, null, true, $title),
                'slug' => Str::slug($title),
                'placement' => ['main navbar', 'navbar dropdown'][rand(0, 1)],
                'body' => $body = $faker->realText(500),
                'meta_title' => Str::title(Str::slug($title, ' ')),
                'meta_keywords' => collect($faker->words)->join(', '),
                'meta_description' => Str::slug(Str::limit($body), ' '),
                'created_at' => $createdAt = $faker->dateTime,
                'updated_at' => $createdAt
            ];
        }
        Page::query()
            ->insert($data);

        DB::commit();
    }
}
