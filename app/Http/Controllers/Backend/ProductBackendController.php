<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductPhoto;
use Illuminate\Http\Request;
use App\Repository\ProductRepository;
use Illuminate\Support\Facades\DB;

class ProductBackendController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::with(['productPhotos', 'category'])->paginate(10);
        return view('backend.pages.product.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $category = Category::with([])->get();
        return view("backend.pages.product.form", compact('category'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $response = (new ProductRepository())->saveProduct($request);
        alertNotify($response['status'], $response['data'], $request);
        if(!$response['status']) {
            return redirect()->back()->withInput();
        }
        return redirect(url("/backend/product"));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product = Product::with(['category', 'productPhotos'])->findOrFail($id);
        return view("backend.pages.product.detail", compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $category = Category::with([])->get();
        $product  = Product::with(['productPhotos'])->findOrFail($id);
        return view("backend.pages.product.form", compact('category', 'product'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $response = (new ProductRepository())->updateProduct($request, $id);
        alertNotify($response['status'], $response['data'], $request);
        if(!$response['status']) {
            return redirect()->back()->withInput();
        }
        return redirect(url("/backend/product"));

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $product = Product::with(['productPhotos'])->findOrFail($id);
        if(!$product) {
            alertNotify(false, "Product Not Found!", $request);
            return redirect()->back();
        }
        DB::beginTransaction();
            $product->productPhotos->delete();
            $product->delete();
        DB::commit();

        alertNotify(true, "Product Succes to delete!", $request);
        return redirect(url("backend/product"));
    }

    public function deletePhotoById($id) {
        $productPhoto = ProductPhoto::findOrFail($id);

        $productPhoto->delete();
        return response()->json(responseCustom(
            "success delete photo",
            true
        ));
    }
}
