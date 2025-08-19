<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Ad;
use App\Models\Category;
use App\Enums\UserRole;
use Illuminate\View\View;

class AdminController extends Controller
{
    public function __construct()
    {
        // Only allows admins
        $this->middleware(['auth', 'is_admin']);
    }

    public function index(): View
    {
        $customerCount = User::where('role', UserRole::CUSTOMER->value)->count();
        $adCount = Ad::count();
        $categoryCount = Category::count();

        return view('admin.dashboard', compact('customerCount', 'adCount', 'categoryCount'));
    }
}
