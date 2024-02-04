<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function home()

    {
        $posts = Post::where('status', 0)->latest()->paginate(12);
        return view("admin.pages.home.home2", ['posts' => $posts]);
    }

    public function singlePost(Request $request)
    {
        $id = $request->id;

        $post = Post::where('id', $id)->first();
        return view('admin.pages.home.singlePost', ['post' => $post, 'id' => $id]);
    }


}
