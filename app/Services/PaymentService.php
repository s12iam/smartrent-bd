<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class PaymentService
{
    public function createPayment($order)
    {
        $tranId = 'TXN-' . Str::upper(Str::random(10));

        $response = Http::asForm()->post(
            env('SSL_BASE_URL') . '/gwprocess/v4/api.php',
            [
                'store_id' => env('SSL_STORE_ID'),
                'store_passwd' => env('SSL_STORE_PASSWORD'),
                'total_amount' => $order->total_amount,
                'currency' => 'BDT',
                'tran_id' => $tranId,

                'success_url' => env('SSL_SUCCESS_URL'),
                'fail_url' => env('SSL_FAIL_URL'),
                'cancel_url' => env('SSL_CANCEL_URL'),
                'ipn_url' => env('SSL_IPN_URL'),

                'cus_name' => $order->user->name ?? 'Test User',
                'cus_email' => $order->user->email ?? 'test@email.com',
                'cus_add1' => 'Dhaka',
                'cus_city' => 'Dhaka',
                'cus_country' => 'Bangladesh',
                'cus_phone' => '01700000000',

                'shipping_method' => 'NO',
                'product_name' => 'Rent Payment',
                'product_category' => 'Service',
                'product_profile' => 'general',
            ]
        );

        return $response->json();
    }
}