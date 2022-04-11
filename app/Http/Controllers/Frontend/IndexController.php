<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Category;
use App\Models\Product;
use App\Repository\CartRepository;
use App\Repository\CheckoutRepository;
use App\Services\ActivityService;
use Illuminate\Http\Request;
class IndexController extends Controller
{
    public function indexHome(Request $request) {
        $categorys = Category::with([])->get();
        $products  = Product::with(['category'])->get();

        ActivityService::listenEvent("Home", "Page");
        
        return view("frontend.pages.home", compact('categorys'));
    }

    public function listProduct(Request $request) {
        $categorys     = Category::get();
        $products      = Product::with(["category"]);
        $filters       = $request->only("keyword");

        if(isset($filters['keyword'])) {
            $products->where("title", "LIKE", "%". $filters['keyword'] ."%");
        }
        $products = $products->paginate(6);
        ActivityService::listenEvent("List_Products", "Page");


        return view("frontend.pages.products", compact("categorys", "products"));
    }

    public function listCarts() {
        $carts = Cart::with(['user', 'product', 'product.productPhotos'])
            ->where("user_id", \Auth::user()->id)
            ->get();

        ActivityService::listenEvent("Carts", "Page");

        return view("frontend.pages.cart", compact('carts'));
    }

    public function checkout() {
        $provinces = listProvinces();
        $carts = Cart::with(['user', 'product', 'product.productPhotos'])
            ->where("user_id", \Auth::user()->id)
            ->get();

        ActivityService::listenEvent("Checkout", "Page");

        return view("frontend.pages.checkout", compact('provinces', 'carts'));
    }

    public function detailProduct($id) {
        $product      = Product::with(['productPhotos', 'category'])
            ->find($id);

        ActivityService::listenEvent("Detail_Product", "Page", "Visited", $product->id .".".$product->category_id);

        return view("frontend.pages.product-detail", compact("product"));
    }

    public function listProductSlug(Request $request, $slug) {
        $slugCategory  = Category::where('slug', $slug)->first();
        $categorys     = Category::get();
        $products      = Product::with(['productPhotos'])
            ->where('category_id', $slugCategory->id)
            ->paginate(6);

        ActivityService::listenEvent("List_Products", "Page", "Visited", $slugCategory->id);

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
        ActivityService::listenEvent("Add_To_Carts", "Page", "Action");

        return redirect(url("/products"));
    }

    public function checkoutPost(Request $request) {
        $response = (new CheckoutRepository())->checkout($request);
        alertNotify($response['status'], $response['data'], $request);
        if(!$response['status']) {
            return redirect()
                ->back()
                ->withInput();
        }

        ActivityService::listenEvent("Checkout_Products", "Page" ,"Action");
        return redirect(url("/"));
    }

    public function getListCityByProvinceId($id) {
        try {
            $response = json_decode(file_get_contents("http://api.iksgroup.co.id/apilokasi/kabupaten?provinsi=31"), true);
            if(isset($response['data'])) {
                return responseCustom($response['data'], true);
            }
            return responseCustom($response, false);
        } catch (\Exception $e) {
            return responseCustom($e->getMessage());
        }
    }
}