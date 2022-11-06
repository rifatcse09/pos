<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use App\Traits\RespondsWithHttpStatusTrait;
use App\Models\Order;
use Yajra\Datatables\Datatables;

class OrderController extends Controller
{


    public function index(Request $request): JsonResponse
    {

        $order = Order::select(['id', 'invoice_id', 'customer_name']);

        return Datatables::of($order)->make();
    }
}
