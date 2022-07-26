<?php

namespace App\Exports;

use App\Models\ActivityLog;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class LogsExport implements FromCollection, WithHeadings
{

    public function headings() : array {
        return ["id", "case_id", "session",  "log_name", "description", "product_id", "product_name", "category_id", "category_name", "causer_id", "email", 'created_at'];
    }
    public function collection()
    {
        $activityLogs = ActivityLog::with(['product', 'category', "case"])
            ->orderBy("created_at", "DESC")
            ->get();

        $array = collect([]);
        $activityLogs->each(function($item) use($array) {
            $array->push([
                $item->id,
                $item->case_id,
                $item->case->session ?? "-",
                $item->log_name,
                $item->description,
                $item->product_id ?? "-",
                $item->product->title ?? "-",
                $item->category_id ?? "-",
                $item->category->name ?? "-",
                $item->causer_id ?? "-",
                $item->user->email ?? "-",
                $item->created_at
            ]);
        });

        return $array;
    }
}
