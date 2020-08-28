<?php

namespace App\Http\Controllers;
use App\Category;
use App\Tag;
use App\Post;

use Illuminate\Http\Request;

class WelcomeController extends Controller
{
    public function index()
    {
       return redirect()->route('login');
    }
}
