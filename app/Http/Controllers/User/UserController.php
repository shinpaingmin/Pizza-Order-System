<?php

namespace App\Http\Controllers\User;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    // direct user home page
    public function home() {
        $products = Product::orderBy('created_at', 'desc')->get();

        return view('user.main.home', compact('products'));
    }
}
