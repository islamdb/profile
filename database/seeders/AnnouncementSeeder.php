<?php

namespace Database\Seeders;

use App\Models\Announcement;
use App\Models\Page;
use Faker\Factory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class AnnouncementSeeder extends Seeder
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
        for ($c = 0; $c < rand(20, 30); $c++){
            $data[] = [
                'title' => $title = Str::title($faker->realText(rand(20, 40))),
                'slug' => Str::slug($title),
                'group' => ['Penerangan Pasukan', 'Pengadaan Barang & Jasa'][rand(0, 1)],
                'body' => $body = $faker->realText(500),
                'meta_title' => Str::title(Str::slug($title, ' ')),
                'meta_keywords' => collect($faker->words)->join(', '),
                'meta_description' => Str::slug(Str::limit($body), ' '),
                'created_at' => $createdAt = $faker->dateTime,
                'updated_at' => $createdAt
            ];
        }
        Announcement::query()
            ->insert($data);

        DB::commit();
    }
}
