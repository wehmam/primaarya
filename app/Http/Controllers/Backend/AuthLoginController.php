<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AuthLoginController extends Controller
{
    public function index() {
        return view("backend.pages.login");
    }

    public function loginPost(Request $request) {
        $credentials = [
            "email" => $request->get("")
        ]        
    }
}
