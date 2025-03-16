<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Admin\PostCategories;
use App\Http\Controllers\Controller;
use App\Models\AlbumPhoto;
use App\Models\Information;
use App\Models\PostCategory;
use App\Models\Posts;
use App\Models\PostTags;
use App\Models\Video;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class DataController extends Controller
{
    /**
     * 1. Berita Terbaru yang sudah dipublikasikan dan statusnya active
     */
    public static function latestPublished($limit)
    {
        return Posts::where('status', 'active')
            ->whereNotNull('published_at')
            ->where('published_at', '<=', Carbon::now())
            ->latest('published_at')
            ->limit($limit)
            ->get();
    }

    /**
     * 2. Berita Terpopuler berdasarkan counter dalam 30 hari terakhir
     */
    public static function mostPopular($limit)
    {
        $thirtyDaysAgo = Carbon::now()->subDays(30);

        return Posts::where('status', 'active')
            ->whereNotNull('published_at')
            ->where('published_at', '>=', $thirtyDaysAgo)
            ->where('published_at', '<=', Carbon::now())
            ->orderBy('counter', 'desc')
            ->limit($limit)
            ->get();
    }

    /**
     * 3. Berita Terkini (berdasarkan waktu pembuatan terbaru)
     */
    public static function latestNews($limit)
    {
        return Posts::where('status', 'active')
            ->whereNotNull('published_at')
            ->where('published_at', '<=', Carbon::now())
            ->latest('created_at')
            ->limit($limit)
            ->get();
    }

    /**
     * 4. Rekomendasi (random) dari 30 hari terakhir
     */
    public static function recommended($limit)
    {
        $thirtyDaysAgo = Carbon::now()->subDays(30);

        return Posts::where('status', 'active')
            ->whereNotNull('published_at')
            ->where('published_at', '>=', $thirtyDaysAgo)
            ->where('published_at', '<=', Carbon::now())
            ->inRandomOrder()
            ->limit($limit)
            ->get();
    }

    /**
     * 5. Video Terbaru yang sudah dipublikasikan dan statusnya active
     */

    public static function videos($paginate)
    {
        return Video::latest('created_at')->paginate($paginate);
    }

    /**
     * 6. Video Terbaru yang sudah dipublikasikan dan statusnya active
     */

    public static function photo($paginate)
    {
        return AlbumPhoto::latest('created_at')->paginate($paginate);
    }


    /**
     * 7. Mengambil data information terbaru yang sudah dipublikasikan dan berstatus active.
     *
     * @param string $type Jenis information yang diambil, hanya boleh 'text' atau 'banner'.
     * @param int $paginate Jumlah item per halaman untuk paginasi.
     * @param bool $random Jika true, urutan data akan acak; jika false, diurutkan berdasarkan created_at terbaru.
     */
    public static function information($type, $paginate, $random = false)
    {
        $query = Information::where('type', $type);
        
        if ($random) {
            $query->inRandomOrder();
        } else {
            $query->latest('created_at');
        }

        return $query->paginate($paginate);
    }

     /**
     * 8. rileate posts
     */

    public static function relate($limit, $post)
    {
         $thirtyDaysAgo = Carbon::now()->subDays(30);
         
         $tags = json_decode($post->tags, true) ?? [];
         
         return Posts::where('status', 'active')
             ->whereNotNull('published_at')
             ->where('published_at', '>=', $thirtyDaysAgo)
             ->where('published_at', '<=', Carbon::now())
             ->where('id', '!=', $post->id) 
             ->where(function ($query) use ($tags, $post) {
                 if (!empty($tags)) {
                     foreach ($tags as $tag) {
                         $query->orWhereJsonContains('tags', $tag);
                     }
                 }
                 $query->orWhere('category_id', $post->category_id);
             })
             ->inRandomOrder()
             ->limit($limit)
             ->get();
    }


     /**
     * 8. category
     */

     public static function category($limit) {
        return PostCategory::latest()->inRandomOrder()
        ->limit($limit)
        ->get();
     }

     /**
     * 8. tags
     */

     public static function tags($limit) {
        return PostTags::latest()->inRandomOrder()
        ->limit($limit)
        ->get();
     }

}