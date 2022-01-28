<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrdersController extends Controller
{
    public function index() {
        $orders = Order::with([
            "user" => function($q) {
                $q->select("id", "name", "email");
            },
            "product" => function($q) {
                $q->select("id", "category_id",  "title");
            },
            "product.productPhotos" => function($q) {
                $q->select("product_id", "image");
            },
            "product.category"  => function($q) {
                $q->select("id", "name");
            }
        ])->paginate(10);
        return view("backend.pages.orders.index", compact("orders"));
    }

    public function detail($id) {
        $order = Order::with([
            "user" => function($q) {
                $q->select("id", "name", "email");
            },
            "product" => function($q) {
                $q->select("id", "category_id",  "title");
            },
            "product.productPhotos" => function($q) {
                $q->select("product_id", "image");
            },
            "product.category"  => function($q) {
                $q->select("id", "name");
            },
            "invoice_details", "invoice_details.invoice"
        ])->findOrFail($id);

        return view("backend.pages.orders.detail", compact("order"));
    }
}
