<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\History;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        // storage link
        Artisan::call("storage:link");

        // serve
        return view('home/index');
    }
}
