<?php

namespace App\Exports;

use App\Models\ActivityLogs;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class LogsExport implements FromCollection, WithHeadings
{
  
    public function headings() : array {
        return ["Date", "Title", "Type", "Email", "Activity", "Ip_Address", "Location", "Custom_Logs"];
    }
    public function collection()
    {
        return ActivityLogs::select("created_at", "title", "type", "email", "activity", "ip_address", "location", "custom_logs")
            ->orderByDesc("id")
            ->get();
    }
}
