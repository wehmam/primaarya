<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\ActivityLogs;
use App\Models\Category;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index() {
        $totalIncome    = Order::select("price_total")->sum('price_total');
        $categoryTotal  = DB::table("categories")->count();
        $productsTotal  = DB::table("products")->count();
        $totalOrders    = DB::table("orders")->count();

        return view("backend.pages.dashboard", compact("totalOrders", "categoryTotal", "totalIncome", "productsTotal"));
    }

    public function activityLogs() {
        $activityLogs = ActivityLog::with(['product', 'category'])
            ->orderBy("created_at", "DESC")
            ->paginate(10);

        return view("backend.pages.index-activity-logs", compact('activityLogs'));
    }
}
