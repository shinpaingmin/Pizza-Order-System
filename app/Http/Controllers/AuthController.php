<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    // direct login page
    public function loginPage() {
        return view('login');
    }

    // direct register page
    public function registerPage() {
        return view('register');
    }
}
