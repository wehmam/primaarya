<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Repository\CartRepository;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function indexHome() {
        $categorys = Category::with([])->get();
        return view("frontend.pages.home", compact('categorys'));
    }

    public function listProduct() {
        $categorys     = Category::get();
        $products      = Product::paginate(6);
        return view("frontend.pages.products", compact("categorys", "products"));
    }

    public function listCarts() {
        return view("frontend.pages.cart");
    }

    public function checkout() {
        return view("frontend.pages.checkout");
    }

    public function detailProduct($id) {
        $product      = Product::with(['productPhotos', 'category'])
            ->find($id);

        return view("frontend.pages.product-detail", compact("product"));
    }

    public function listProductSlug(Request $request, $slug) {
        $slugCategory  = Category::where('slug', $slug)->first();
        $categorys     = Category::get();
        $products      = Product::with(['productPhotos'])
            ->where('category_id', $slugCategory->id)
            ->paginate(6);
        return view("frontend.pages.products", compact('products', 'categorys'));
    }

    public function addToCarts(Request $request) {
        $response = (new CartRepository())->addToCarts($request);
        alertNotify($response['status'], $response['data'], $request);
        if(!$response['status']) {
            return redirect()
                ->back()
                ->withInput();
        }
        return redirect(url("/products"));
    }
}