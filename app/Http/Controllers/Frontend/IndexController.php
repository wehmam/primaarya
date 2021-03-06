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
        $categorys = Category::with([])->where('is_active', 1)->get();
        $products  = Product::with(['category'])->get();

        ActivityService::activityLogs('E', 'Home');

        return view("frontend.pages.home", compact('categorys'));
    }

    public function listProduct(Request $request) {
        $categorys     = Category::where('is_active', 1)->get();
        $products      = Product::with(["category"])->where('is_active', 1);
        $filters       = $request->only("keyword");

        if(isset($filters['keyword'])) {
            $products->where("title", "LIKE", "%". $filters['keyword'] ."%");
        }
        $products = $products->paginate(6);
        ActivityService::activityLogs('D', 'Melihat Kategori');


        return view("frontend.pages.products", compact("categorys", "products"));
    }

    public function listCarts() {
        $carts = Cart::with(['user', 'product', 'product.productPhotos'])
            ->where("user_id", \Auth::user()->id)
            ->get();

        ActivityService::activityLogs('I', 'Melihat Keranjang');

        return view("frontend.pages.cart", compact('carts'));
    }

    public function checkout() {
        $provinces = listProvinces();
        $carts = Cart::with(['user', 'product', 'product.productPhotos'])
            ->where("user_id", \Auth::user()->id)
            ->get();

        ActivityService::activityLogs('J', 'Detail Checkout');

        return view("frontend.pages.checkout", compact('provinces', 'carts'));
    }

    public function detailProduct($id) {
        $product      = Product::with(['productPhotos', 'category'])
            ->find($id);

        ActivityService::activityLogs('G', 'Melihat Detail Produk', $id, $product->category_id);

        return view("frontend.pages.product-detail", compact("product"));
    }

    public function listProductSlug(Request $request, $slug) {
        $slugCategory  = Category::where('slug', $slug)->where('is_active', 1)->first();
        if(!$slugCategory) {
            return redirect(url('/products'));
        }
        $categorys     = Category::get();
        $products      = Product::with(['productPhotos'])
            ->where('category_id', $slugCategory->id)
            ->where('is_active', 1)
            ->paginate(6);

        ActivityService::activityLogs('F', 'Melihat Kategori', '', $slugCategory->id);

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
        ActivityService::activityLogs('H', 'Menambahkan Keranjang');

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
        ActivityService::activityLogs('K', 'Checkout');

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
