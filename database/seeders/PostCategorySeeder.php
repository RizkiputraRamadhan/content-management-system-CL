<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PostCategory; 
use Illuminate\Support\Str;

class PostCategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Technology',
                'slug' => 'technology',
            ],
            [
                'name' => 'Lifestyle',
                'slug' => 'lifestyle',
            ],
            [
                'name' => 'Programming',
                'slug' => 'programming',
            ],
            [
                'name' => 'News',
                'slug' => 'news',
            ],
            [
                'name' => 'Tutorials',
                'slug' => 'tutorials',
            ],
        ];

        foreach ($categories as $category) {
            PostCategory::firstOrCreate(
                ['slug' => $category['slug']], 
                [
                    'name' => $category['name'],
                ]
            );
        }
    }
}