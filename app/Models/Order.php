<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = ['invoice_id', 'customer_name', 'customer_email', 'customer_phone', 'customer_street', 'customer_city', 'customer_state', 'customer_zipcode', 'customer_country', 'product_name', 'product_details', 'amount', 'payment_status', 'payment_url'];
}
