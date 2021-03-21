<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\PostCategory;
use App\Models\PostTag;
use App\Models\User;
use Faker\Factory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PostSeeder extends Seeder
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
        PostCategory::query()
            ->insert($data);

        $data = [];
        for ($c = 0; $c < rand(20, 50); $c++){
            $data[] = [
                'name' => $name = Str::title($faker->unique()->word()),
                'slug' => Str::slug($name),
                'meta_title' => Str::title(Str::slug($name, ' ')),
                'meta_keywords' => collect($faker->words)->join(', '),
                'meta_description' => Str::slug(Str::limit($desc), ' '),
                'created_at' => $createdAt = $faker->dateTime,
                'updated_at' => $createdAt
            ];
        }
        PostTag::query()
            ->insert($data);

        $data = [];
        $users = User::query()
            ->select('id')
            ->get()
            ->pluck('id');
        for ($c = 0; $c < rand(300, 500); $c++){
            $data[] = [
                'user_id' => $users->random(),
                'title' => $title = $faker->unique()->realText(rand(30, 50)),
                'slug' => Str::slug($title),
                'summary' => $faker->realText(rand(30, 60)),
                'body' => $faker->realText(),
                'meta_title' => Str::title(Str::slug($title, ' ')),
                'meta_keywords' => collect($faker->words)->join(', '),
                'meta_description' => Str::slug(Str::limit($desc), ' '),
                'created_at' => $createdAt = $faker->dateTime,
                'updated_at' => $createdAt,
                'published_at' => $createdAt
            ];
        }
        Post::query()
            ->insert($data);

        $data = [];
        $dataTag = [];
        $dataCategory = [];
        $tags = PostTag::query()
            ->select('id')
            ->get()
            ->pluck('id');
        $categories = PostCategory::query()
            ->select('id')
            ->get()
            ->pluck('id');
        Post::query()
            ->select('id')
            ->get()
            ->pluck('id')
            ->each(function ($postId) use ($tags, $categories, &$dataCategory, &$dataTag) {
                foreach ($tags->random(rand(2, 6)) as $tagId){
                    $dataTag[] = [
                        'post_id' => $postId,
                        'post_tag_id' => $tagId
                    ];
                }

                foreach ($categories->random(rand(1, 4)) as $categoryId){
                    $dataCategory[] = [
                        'post_id' => $postId,
                        'post_category_id' => $categoryId
                    ];
                }
            });
        DB::table('post_tag')
            ->insert($dataTag);
        DB::table('post_category')
            ->insert($dataCategory);

        DB::commit();
    }
}
