<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PostTags; 
use Illuminate\Support\Str;

class PostTagSeeder extends Seeder
{
    public function run(): void
    {
        $tags = [
            [
                'name' => 'PHP',
                'slug' => 'php',
            ],
            [
                'name' => 'Laravel',
                'slug' => 'laravel',
            ],
            [
                'name' => 'Web Development',
                'slug' => 'web-development',
            ],
            [
                'name' => 'Tutorial',
                'slug' => 'tutorial',
            ],
            [
                'name' => 'Tips',
                'slug' => 'tips',
            ],
        ];

        foreach ($tags as $tag) {
            PostTags::firstOrCreate(
                ['slug' => $tag['slug']],
                [
                    'name' => $tag['name'],
                ]
            );
        }
    }
}