<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function indexHome() {
        return view("frontend.pages.home");
    }

    public function listProduct() {
        return view("frontend.pages.products");
    }

    public function listCarts() {
        return view("frontend.pages.cart");
    }

    public function checkout() {
        return view("frontend.pages.checkout");
    }

    public function detailProduct($id = 1) {
        return view("frontend.pages.product-detail");
    }
}