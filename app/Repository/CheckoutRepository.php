<?php

namespace App\Repository;

use App\Models\Cart;
use App\Models\Invoice;
use App\Models\InvoiceDetail;
use App\Models\Order;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class CheckoutRepository {

    public function checkout($request) {
        try {
            $params    = $request->all();
            $validator = \Validator::make($params, [
                "province"  => "required",
                "city"      => "required",
                "district"  => "required",
                "address"   => "required",
                "post_code" => "required",
                "phone"     => "required"
            ]);

            if($validator->fails()) return responseCustom(
                collect($validator->messages()->all())->implode(" - ")
            );

            DB::beginTransaction();
            $carts = Cart::with(['user', 'product', 'product.productPhotos'])
                ->where("user_id", \Auth::user()->id)
                ->get();

            if(!$carts) return responseCustom(
                "carts data not found!"
            );

            // create Invoice
            $invoice            = new Invoice();
            $invoice->title     = "Pembayaran Produk";
            $invoice->amount    = $carts->sum("total_price");
            $invoice->save();


            foreach($carts as $cart) {
                $order                      = new Order();
                $order->user_id             = \Auth::user()->id;
                $order->product_id          = $cart->product_id;
                $order->invoice_no          = "PAO-";
                $order->price_per_product   = $cart->product->price;
                $order->quantity            = $cart->quantity;
                $order->price_total         = $cart->total_price;
                $order->province            = $params['province'];
                $order->city                = $params['city'];
                $order->district            = $params['district'];
                $order->post_code           = $params['post_code'];
                $order->address             = $params['address'];
                $order->phone               = $params['phone'];
                $order->save();

                $order->invoice_no          = "PAO-".$order->id;
                $order->save();

                $invoiceDetail              = new InvoiceDetail();
                $invoiceDetail->invoice_id  = $invoice->id;
                $invoiceDetail->order_id    = $order->id;
                $invoiceDetail->title       = "Bill Produk";
                $invoiceDetail->amount      = $cart->total_price;
                $invoiceDetail->save();

                $cart->delete();
            }

            DB::commit();

            return responseCustom("success to checkout!", true);
        } catch (\Exception $e) {
            DB::rollback();
            return responseCustom($e->getMessage());
        }
    }

}
