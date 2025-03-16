<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Posts;
use App\Models\Information;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        $stats = DB::table('posts')
            ->selectRaw(
                '
                (SELECT COUNT(*) FROM users) as total_users,
                COUNT(*) as total_news,
                SUM(CASE WHEN YEAR(created_at) = ? THEN 1 ELSE 0 END) as news_this_year,
                SUM(CASE WHEN DATE(created_at) = ? THEN 1 ELSE 0 END) as news_today
            ',
            )
            ->setBindings([now()->year, now()->toDateString()])
            ->first();

        return view('pages.admin.home.index', [
            'totalUsers' => $stats->total_users,
            'totalNews' => $stats->total_news,
            'newsThisYear' => $stats->news_this_year,
            'newsToday' => $stats->news_today,
            'page' => 'Dashboard',
        ]);
    }
}
