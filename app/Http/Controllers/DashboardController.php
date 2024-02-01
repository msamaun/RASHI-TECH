<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function dashboardList()
    {
        $user_id = Auth::id();
        $post = Post::where('user_id', $user_id)->count();
        $active = Post::where('user_id', $user_id)->where('status', '0')->count();
        $inactive = Post::where('user_id', $user_id)->where('status', '1')->count();

        return [
            'posts' => $post,
            'active' => $active,
            'inactive' => $inactive
        ];
    }

}
