<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\ProductCategory;
use Faker\Factory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
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
                'name' => $name = Str::title($faker->unique()->word()),
                'slug' => Str::slug($name),
                'description' => $desc = $faker->realText(100),
                'meta_title' => Str::title(Str::slug($name, ' ')),
                'meta_keywords' => collect($faker->words)->join(', '),
                'meta_description' => Str::slug(Str::limit($desc), ' '),
                'created_at' => $createdAt = $faker->dateTime,
                'updated_at' => $createdAt
            ];
        }
        ProductCategory::query()
            ->insert($data);

        $data = [];
        for ($c = 0; $c < rand(25, 50); $c++){
            $data[] = [
                'name' => $name = Str::title($faker->unique()->word()),
                'slug' => Str::slug($name),
                'active' => rand(0, 1),
                'price' => $price = rand(5, 1000) * 1000,
                'discount' => $price * rand(0, 25) / 100,
                'body' => $faker->realText(),
                'meta_title' => Str::title(Str::slug($name, ' ')),
                'meta_keywords' => collect($faker->words)->join(', '),
                'meta_description' => Str::slug(Str::limit($desc), ' '),
                'created_at' => $createdAt = $faker->dateTime,
                'updated_at' => $createdAt
            ];
        }
        Product::query()
            ->insert($data);

        $data = [];
        $dataCategory = [];
        $categories = ProductCategory::query()
            ->select('id')
            ->get()
            ->pluck('id');
        Product::query()
            ->select('id')
            ->get()
            ->pluck('id')
            ->each(function ($productId) use ($categories, &$dataCategory) {
                foreach ($categories->random(rand(1, 4)) as $categoryId){
                    $dataCategory[] = [
                        'product_id' => $productId,
                        'product_category_id' => $categoryId
                    ];
                }
            });
        DB::table('product_category')
            ->insert($dataCategory);

        DB::commit();
    }
}
