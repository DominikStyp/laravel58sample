<?php

namespace App\Http\Controllers;

use App\Http\Resources\PostResource;
use App\Models\Post;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function home(Request $request)
    {
        return view('welcome');
    }

}
