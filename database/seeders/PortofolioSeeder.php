<?php

namespace Database\Seeders;

use App\Models\Portofolio;
use App\Models\PortofolioCategory;
use Faker\Factory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PortofolioSeeder extends Seeder
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
        for ($c = 0; $c < rand(5, 10); $c++){
            $data[] = [
                'name' => $name = Str::title($faker->realText(rand(20, 40))),
                'slug' => Str::slug($name),
                'description' => $desc = $faker->realText(100),
                'meta_title' => Str::title(Str::slug($name, ' ')),
                'meta_keywords' => collect($faker->words)->join(', '),
                'meta_description' => Str::slug(Str::limit($desc), ' '),
                'created_at' => $createdAt = $faker->dateTime,
                'updated_at' => $createdAt
            ];
        }
        PortofolioCategory::query()
            ->insert($data);

        $data = [];
        for ($c = 0; $c < rand(20, 35); $c++){
            $data[] = [
                'name' => $name = $faker->realText(rand(20, 40)),
                'slug' => Str::slug($name),
                'body' => $body = $faker->realText(500),
                'summary' => Str::limit($body),
                'meta_title' => Str::title(Str::slug($name, ' ')),
                'meta_keywords' => collect($faker->words)->join(', '),
                'meta_description' => Str::slug(Str::limit($body), ' '),
                'created_at' => $createdAt = $faker->dateTime,
                'updated_at' => $createdAt
            ];
        }
        Portofolio::query()
            ->insert($data);

        $categories = PortofolioCategory::query()
            ->select('id')
            ->get()
            ->pluck('id');
        $portofolios = Portofolio::query()
            ->select('id')
            ->get()
            ->pluck('id');
        $data = [];
        foreach ($portofolios as $portofolio){
            foreach ($categories->random(rand(2, 5)) as $category){
                $data[] = [
                    'portofolio_id' => $portofolio,
                    'portofolio_category_id' => $category
                ];
            }
        }
        DB::table('portofolio_category')
            ->insert($data);

        DB::commit();
    }
}
