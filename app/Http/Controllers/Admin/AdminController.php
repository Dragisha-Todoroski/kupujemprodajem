<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Ad;
use App\Models\Category;
use Illuminate\View\View;

class AdminController extends Controller
{
    public function __construct()
    {
        // Only allows admins
        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            if (!auth()->user()->isAdmin()) {
                abort(403);
            }
            return $next($request);
        });
    }

    public function index(): View
    {
        $userCount = User::count();
        $adCount = Ad::count();
        $categoryCount = Category::count();

        return view('admin.dashboard', compact('userCount', 'adCount', 'categoryCount'));
    }
}
