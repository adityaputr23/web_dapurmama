<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CustomOrder extends Model
{
    protected $fillable = [
        'customer_name',
        'email',
        'phone',
        'order_details',
        'delivery_date',
        'status',
    ];
}
