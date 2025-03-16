<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Posts;
use App\Models\PostCategory;
use App\Models\PostTags;
use App\Models\User;
use Illuminate\Support\Str;
use Faker\Factory as Faker;

class PostSeeder extends Seeder
{
    public function run()
    {

        $faker = Faker::create('id_ID'); 

        // Daftar gambar acak
        $images = ['image-1.jpg', 'image-2.jpg', 'image-3.jpg', 'image-4.jpg', 'image-5.jpg', 'image-6.jpg'];

        $userIds = [16, 18, 19, 20, 21, 22, 23];

        $categories = PostCategory::all();
        $tags = PostTags::all();

        // Buat 100 berita
        for ($i = 0; $i < 100; $i++) {
            $title = $faker->sentence(8); 
            $slug = Str::slug($title);
            $image = $faker->randomElement($images); 
            $content = $this->generateRandomContent($faker);
            $status = $faker->randomElement(['active', 'inactive']);
            $createdBy = $faker->randomElement($userIds);
            $counter = $faker->numberBetween(1, 1000);
            $publishedAt = $faker->dateTimeBetween('-1 year', 'now');

            $categoryIds = $categories->random(rand(1, 2))->pluck('id')->toArray();

            $tagIds = $tags->random(rand(1, 2))->pluck('id')->toArray();
            $tagsJson = json_encode($tagIds);

            // Simpan data ke tabel posts
            Posts::create([
                'title' => $title,
                'slug' => $slug,
                'image' => $image,
                'content' => $content,
                'status' => $status,
                'created_by' => $createdBy,
                'category_id' => $categoryIds[0] ?? null,
                'tags' => $tagsJson,
                'counter' => $counter,
                'published_at' => $publishedAt,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

    /**
     * Generate konten acak dengan HTML untuk text editor
     */
    private function generateRandomContent($faker)
    {
        $paragraphs = $faker->paragraphs(3); 
        $content = '<h2>' . $faker->sentence() . '</h2>'; 
        foreach ($paragraphs as $paragraph) {
            $content .= '<p>' . $paragraph . '</p>';
        }
        $content .= '<ul>';
        for ($i = 0; $i < 3; $i++) {
            $content .= '<li>' . $faker->sentence() . '</li>';
        }
        $content .= '</ul>';
        if ($faker->boolean(70)) { 
            $content .= '<img src="https://picsum.photos/600/400" alt="Random Image" />';
        }
        return $content;
    }
}