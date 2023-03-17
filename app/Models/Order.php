<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'product_name',
        'weight',
        'description',
        'total_price'
    ];

    public function getCreatedAtAttribute($value) {
        return Carbon::parse($value)->format('Y-m-d H:i:s');
    }
}
