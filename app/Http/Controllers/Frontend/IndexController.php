<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Category;
use App\Models\Product;
use App\Repository\CartRepository;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xls;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class IndexController extends Controller
{
    public function indexHome() {
        $categorys = Category::with([])->get();
        $products  = Product::with(['category'])->get();

        // $spreadSheet    = new Spreadsheet();
        // $sheet          = $spreadSheet->getActiveSheet();
        // $sheet->setCellValue('A1', 'No');
        // $sheet->setCellValue('B1', 'Category');
        // $sheet->setCellValue('C1', 'Title');
        // $sheet->setCellValue('D1', 'Quantity');
        // $sheet->setCellValue('E1', 'Description');
        // $sheet->setCellValue('F1', 'Price');
        // $sheet->setCellValue('G1', 'Is Active');
        // foreach($products as $key => $product) {
        //     $keyNext = 2;
        //     $sheet->setCellValue('A' . $keyNext, $key++);
        //     $sheet->setCellValue('B' . $keyNext, $product->category->name);
        //     $sheet->setCellValue('C' . $keyNext, $product->title);
        //     $sheet->setCellValue('D' . $keyNext, $product->qty);
        //     $sheet->setCellValue('E' . $keyNext, $product->description);
        //     $sheet->setCellValue('F' . $keyNext, "Rp ." . number_format($product->price));
        //     $sheet->setCellValue('G' . $keyNext, ($product->is_active ? "Yes" : "No"));
        //     $keyNext++;
        // }
        // $writer = New Xlsx($spreadSheet);
        //     // header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        //     header('Content-Disposition: attachment; filename="products.xlsx"');
        // $writer->save("php://output");

        // return "oke";


        return view("frontend.pages.home", compact('categorys'));
    }

    public function listProduct() {
        $categorys     = Category::get();
        $products      = Product::paginate(6);
        return view("frontend.pages.products", compact("categorys", "products"));
    }

    public function listCarts() {
        $carts = Cart::with(['user', 'product', 'product.productPhotos'])
            ->where("user_id", \Auth::user()->id)
            ->get();

        return view("frontend.pages.cart", compact('carts'));
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