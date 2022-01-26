<?php 

namespace App\Repository;

use App\Models\Cart;
use App\Models\Product;
use App\Models\ProductPhoto;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class CartRepository {

    public function addToCarts($request) {
        try {
            if(!\Auth::check()) {
                return responseCustom("Please Login before add to cart products!");
            }

            $validator = \Validator::make($request->all(), [
                "productId" => "required",
                "quantity"  => "required"
            ]);

            if($validator->fails()) {
                return responseCustom("Err CR-ATC(2) : " . implode(" - ", $validator->messages()->all()));
            }

            $product = Product::find($request->get("productId"));
            if(!$product) {
                return responseCustom("Err CR-ATC(3) : Products not found!");
            }

            if($product->qty < $request->get("quantity")) {
                return responseCustom("Err CR-ATC(4) : Quantity not enough!");
            }

            $cart               = Cart::where("product_id", $product->id)->first();
            if(!$cart) {
                $cart               = new Cart();
                $cart->quantity     = $request->get("quantity");
            } else {
                $cart->quantity     = $request->get("quantity") + $cart->quantity;
            }
            $cart->user_id      = \Auth::user()->id;
            $cart->product_id   = $product->id;
            $cart->save();

            return responseCustom("Success Add Product!", true);
        } catch (\Exception $e) {
            return responseCustom("Err CR-ATC(e) : " . $e->getMessage());
        }
    }
}