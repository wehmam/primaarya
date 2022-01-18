<?php 

namespace App\Repository;

use App\Models\Product;
use App\Models\ProductPhoto;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ProductRepository {

    public function saveProduct($request) {
        try {
            $validator = \Validator::make($request->all(), [
                "category_id"       => "required",
                "title"             => "required",
                "qty"               => "required",
                "price"             => "required",
                "description"       => "required",
                "is_active"         => "required",
                "upload_image"      => "required",
                "upload_image.*"    => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048'
            ]);

            if($validator->fails()) {
                return responseCustom("Err PR-SP(Val) : " . implode(" - ", $validator->messages()->all()));
            }

            DB::beginTransaction();

            $product                = new Product();
            $product->category_id   = $request->get("category_id");
            $product->title         = $request->get("title");
            $product->qty           = $request->get("qty");
            $product->description   = $request->get("description");
            $product->price         = $request->get("price");
            $product->is_active     = $request->get("is_active");
            $product->save();

            foreach($request->file("upload_image") as $image) {
                $pathFile = Storage::putFile("public/images/products", $image);
                $productPhotos              = new ProductPhoto();
                $productPhotos->product_id  = $product['id'];
                $productPhotos->image       = $pathFile;
                $productPhotos->save();
            }

            DB::commit();
            
            return responseCustom("Success Save Product", true);
        } catch (\Exception $e) {
            return responseCustom("Err PR-SP(e) : " . $e->getMessage());
        }
    }

    public function updateProduct($request, $id) {
        try {
            $validator = \Validator::make($request->all(), [
                "category_id"       => "required",
                "title"             => "required",
                "qty"               => "required",
                "price"             => "required",
                "description"       => "required",
                "is_active"         => "required",
                // "upload_image"      => "required",
                // "upload_image.*"    => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048'
            ]);

            if($validator->fails()) {
                return responseCustom("Err PR-UP(Val) : " . implode(" - ", $validator->messages()->all()));
            }

            DB::beginTransaction();

            $product                = Product::find($id);
            if(!$product) {
                return responseCustom("Err PR-UP(1) : Product Not Found" );
            }

            $product->category_id   = $request->get("category_id");
            $product->title         = $request->get("title");
            $product->qty           = $request->get("qty");
            $product->description   = $request->get("description");
            $product->price         = $request->get("price");
            $product->is_active     = $request->get("is_active");
            $product->save();


            if($request->hasFile("upload_image")) {
                $validator = \Validator::make($request->all(), [
                    "upload_image.*"    => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048'
                ]);
                if($validator->fails()) {
                    return responseCustom("Err Validation PR-UP(Val 2) :" . implode(" - ", $validator->messages()->all()));
                }    

                foreach($request->file("upload_image") as $image) {
                    $pathFile = Storage::putFile("public/images/products", $image);
                    $productPhotos              = new ProductPhoto();
                    $productPhotos->product_id  = $product['id'];
                    $productPhotos->image       = $pathFile;
                    $productPhotos->save();
                }
            }

            DB::commit();
            
            return responseCustom("Success Update Product", true);
        } catch (\Exception $e) {
            return responseCustom("Err PR-SP(e) : " . $e->getMessage());
        }
    }
}