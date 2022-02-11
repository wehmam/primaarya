<?php

namespace App\Exports;

use App\Models\Category;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;



class CategoryExport implements FromCollection, WithHeadings
{
   
    public function headings() : array {
        return ["slug", "name", "main_image"];
    }

    public function collection()
    {
        return Category::select("slug", "name", "main_image")->get();
    }
}
