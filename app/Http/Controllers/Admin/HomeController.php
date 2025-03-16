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
        $totalUsers = User::count();
        $totalNews = Posts::count();
        $newsThisYear = Posts::whereYear('created_at', date('Y'))->count();
        $newsToday = Posts::whereDate('created_at', date('Y-m-d'))->count();
    
        return view('pages.admin.home.index', [
            'totalUsers' => $totalUsers,
            'totalNews' => $totalNews,
            'newsThisYear' => $newsThisYear,
            'newsToday' => $newsToday,
            'page' => 'Dashboard',
        ]);
    }
    
}
