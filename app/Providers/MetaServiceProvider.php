<?php

namespace App\Providers;

use App\Models\WebIdentity;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class MetaServiceProvider extends ServiceProvider
{
    
    private function cleanText($text)
    {
        $text = strip_tags($text); 
        $text = preg_replace('/[^a-zA-Z0-9\s]/', '', $text);
        $text = preg_replace('/\s+/', ' ', trim($text)); 
        return $text;
    }

    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        $webIdentity = WebIdentity::orderBy('id', 'desc')->first();

        $defaultMeta = [
            'web_name' => $webIdentity->web_name ?? config('app.name', 'Portal Informasi'),
            'domain' => $webIdentity->domain ?? url('/'),
            'email' => $webIdentity->email ?? 'info@example.com',
            'phone_number' => $webIdentity->phone_number ?? '#',
            'facebook_link' => $webIdentity->facebook_link ?? '#',
            'instagram_link' => $webIdentity->instagram_link ?? '#',
            'youtube_link' => $webIdentity->youtube_link ?? '#',
            'twitter_link' => $webIdentity->twitter_link ?? '#',
            'google_maps' => $webIdentity->google_maps ?? 'https://maps.google.com/',
            'meta_title' => $webIdentity->meta_title ?? 'Portal Informasi kuli it tecno',
            'meta_description' => $webIdentity->meta_description ?? 'Description Portal Informasi kuli it tecno',
            'meta_keywords' => $webIdentity->meta_keywords ?? 'portal, informasi',
            'og_image' => $webIdentity->og_image ? asset('storage/web-identities/' . $webIdentity->og_image) : asset('assets/img/kuliit.png'),
            'favicon' => $webIdentity->favicon ? asset('storage/web-identities/' . $webIdentity->favicon) : asset('assets/img/logo_2.png'),
            'logo' => $webIdentity->logo ? asset('storage/web-identities/' . $webIdentity->logo) : asset('assets/img/kuliit.png'),
            'status' => $webIdentity->status ?? 'active',
            'version' => $webIdentity->version ?? '1.0.0',
        ];

        View::composer('*', function ($view) use ($defaultMeta) {
            $data = $view->getData();

            if (isset($data['page'])) {
                $content = $data['page'];
                if (is_object($content)) {
                    $defaultMeta['meta_title'] = $content->title ?? $defaultMeta['meta_title'];
                    $defaultMeta['meta_description'] = $this->cleanText($content->description ?? $content->title ?? $content);
                    $defaultMeta['meta_keywords'] = $defaultMeta['meta_keywords'] . ', ' . $content->title;
                } else {
                    $defaultMeta['meta_title'] = $content ?? $defaultMeta['meta_title'];
                    $defaultMeta['meta_description'] = $this->cleanText($content);
                    $defaultMeta['meta_keywords'] = $defaultMeta['meta_keywords'] . ', ' . $content;
                }
                $defaultMeta['og_image'] = $defaultMeta['og_image'];
            } elseif (isset($data['info'])) {
                $content = $data['info'];
                $defaultMeta['meta_title'] = $content->title ?? $defaultMeta['meta_title'];
                $defaultMeta['meta_description'] = $this->cleanText($content->description ?? $content->title);
                $defaultMeta['meta_keywords'] = $defaultMeta['meta_keywords'] . ', ' . $content->title;
                $defaultMeta['og_image'] = $defaultMeta['og_image'];
            } elseif (isset($data['banner'])) {
                $content = $data['banner'];
                $defaultMeta['meta_title'] = $content->title ?? $defaultMeta['meta_title'];
                $defaultMeta['meta_description'] = $this->cleanText($content->description ?? $content->title);
                $defaultMeta['meta_keywords'] = $defaultMeta['meta_keywords'] . ', ' . $content->title;
                $defaultMeta['og_image'] = $defaultMeta['og_image'];
            } elseif (isset($data['video'])) {
                $content = $data['video'];
                $defaultMeta['meta_title'] = $content->title ?? $defaultMeta['meta_title'];
                $defaultMeta['meta_description'] = $this->cleanText($content->description ?? $content->title);
                $defaultMeta['meta_keywords'] = $defaultMeta['meta_keywords'] . ', ' . $content->title;
                $defaultMeta['og_image'] = $content->image ? asset('storage/videos/' . $content->image) : $defaultMeta['og_image'];
            } elseif (isset($data['post'])) {
                $content = $data['post'];
                $defaultMeta['meta_title'] = $content->title ?? $defaultMeta['meta_title'];
                $defaultMeta['meta_description'] = $this->cleanText($content->description ?? $content->title);
                $defaultMeta['meta_keywords'] = $defaultMeta['meta_keywords'] . ', ' . $content->title;
                $defaultMeta['og_image'] = $content->image ? asset('storage/posts/' . $content->image) : $defaultMeta['og_image'];
            }

            $view->with('meta', (object) $defaultMeta);
        });
    }
}
