<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cart extends Model
{
    use HasFactory;
    use SoftDeletes;

    public function user() {
        return $this->belongsTo(User::class,);
    }

    public function product() {
        return $this->belongsTo(Product::class);
    }

    public function getTotalPriceAttribute() {
        $total = 0;
        if($this->product) {
            if($this->product->price) {
                $total = $this->product->price * $this->quantity;
            }
        }
        return $total;
    }
}
