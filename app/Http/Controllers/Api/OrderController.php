<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use App\Http\Requests\OrderRequest;
use App\Http\Requests\StatusChnageRequest;
use Illuminate\Http\Request;
use App\Repositories\Interfaces\CurrencyConversionInterface;
use App\Repositories\Interfaces\UserRepositoryInterface;

use App\Traits\RespondsWithHttpStatusTrait;
use App\Models\Order;
use Illuminate\Support\Facades\Http;

use Log;

class OrderController extends Controller
{
    use RespondsWithHttpStatusTrait;

    private $bearer;

    public function __construct()
    {
        $this->bearer = config('api.bearer');
    }

    public function index(Request $request)
    {
        try {
            $limit = (int) $request->input('limit', 50);
        } catch (\Exception $e) {
            $limit = 50;
        }

        if (!is_int($limit) || $limit <= 0) {
            $limit = 50;
        }

        $orders = Order::get();

        return $this::success($orders, __('Order List'), Response::HTTP_OK);
    }


    public function orderCreate(OrderRequest $request): JsonResponse
    {

        $data = array(
            'order' => array(
                "amount" => (float)$request->amount,
                "currency" => "BDT",
                "redirect_url" => config('api.redirect_url')
            ),
            'product' => array(
                'name'   => $request->product_name,
                'description' => $request->product_description,
            ),
            'billing' => array(
                "customer" => array(
                    'name'   => $request->customer_name,
                    'email' => $request->customer_email,
                    'phone' => $request->customer_phone,
                    'address' => array(
                        "street" => $request->customer_street,
                        "city" => $request->customer_city,
                        "state" => $request->customer_state,
                        "zipcode" => $request->customer_zipcode,
                        "country" => $request->customer_country,
                    )
                )

            ),
        );

        $reponse =  Http::withToken($this->bearer)->accept('application/json')->withBody(json_encode($data), 'application/json')
            ->post('https://api-sandbox.portwallet.com/payment/v2/invoice');

        $invoice = json_decode($reponse);

        if ($invoice->result == 'ERROR') {
            return $this::failure(__('External Api Error!'), Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        if ($invoice->result) {
            try {
                $order =  Order::create([
                    'invoice_id' => $invoice->data->invoice_id,
                    'customer_name' => $invoice->data->billing->customer->name,
                    'customer_email' => $invoice->data->billing->customer->email,
                    'customer_phone' => $invoice->data->billing->customer->phone,
                    'customer_street' => $invoice->data->billing->customer->address->street,
                    'customer_city' => $invoice->data->billing->customer->address->city,
                    'customer_state' => $invoice->data->billing->customer->address->state,
                    'customer_zipcode' => $invoice->data->billing->customer->address->zipcode,
                    'customer_country' => $invoice->data->billing->customer->address->country,
                    'product_name' => $invoice->data->product->name,
                    'product_details' => $invoice->data->product->description,
                    'payment_url' => $invoice->data->action->url,
                    'amount' => $invoice->data->order->amount,
                ]);
                return $this::success($order, __('Order Created Successfully !'), Response::HTTP_CREATED);
            } catch (\Exception $e) {
                return $this::failure(__('Order Not Created !'), Response::HTTP_INTERNAL_SERVER_ERROR);
            }
        }
    }

    public function orderStatusChange(Request $request)
    {
        $invoice_id = $request->invoice_id;
        $amount = $request->amount;

        $reponse =  Http::withToken($this->bearer)->accept('application/json')
            ->get("https://api-sandbox.portwallet.com/payment/v2/invoice/ipn/${invoice_id}/${amount}");

        $invoice = json_decode($reponse);

        if ($invoice->result == 'ERROR') {
            return $this::failure(__('External Api Error!'), Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        $statusResponse = Order::where('invoice_id', $invoice_id)
            ->update([
                'payment_status' => $invoice->data->order->status
            ]);

        return $this::success($invoice->data, __('Order status changed !'), Response::HTTP_OK);
    }
}
