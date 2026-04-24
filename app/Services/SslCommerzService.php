<?php

namespace App\Services;

use App\Models\Booking;
use Illuminate\Support\Facades\Http;

class SslCommerzService
{
    public function initPayment(Booking $booking, string $tranId): array
    {
        return Http::asForm()->post(env('SSL_BASE_URL') . '/gwprocess/v4/api.php', [
            'store_id'       => env('SSL_STORE_ID'),
            'store_passwd'   => env('SSL_STORE_PASSWORD'),
            'total_amount'   => $booking->property->rent_price,
            'currency'       => 'BDT',
            'tran_id'        => $tranId,
            'success_url'    => env('SSL_SUCCESS_URL'),
            'fail_url'       => env('SSL_FAIL_URL'),
            'cancel_url'     => env('SSL_CANCEL_URL'),
            'ipn_url'        => env('SSL_IPN_URL'),

            'cus_name'       => $booking->tenant->name ?? 'Tenant User',
            'cus_email'      => $booking->tenant->email ?? 'tenant@example.com',
            'cus_add1'       => 'Dhaka',
            'cus_city'       => 'Dhaka',
            'cus_country'    => 'Bangladesh',
            'cus_phone'      => '01700000000',

            'shipping_method' => 'NO',
            'product_name'    => 'Property Rent Payment',
            'product_category'=> 'Rent',
            'product_profile' => 'general',
        ])->json();
    }
}