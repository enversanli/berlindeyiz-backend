<?php

namespace App\Services\PayPal;

use App\Models\Order;
use App\Models\Payment;
use App\Support\Enum\ErrorLogEnum;
use App\Support\ResponseMessage;

class PaypalOrderService extends PaypalCommon
{
    public function create(Order $order, Payment $payment)
    {
        $orderInstance = $this->createOrderInstance($order, $payment);

        $response = $this->provider->createOrder($orderInstance);

        if (isset($response['status']) && $response['status'] == 'CREATED') {
            foreach ($response['links'] as $links) {
                if ($links['rel'] == 'approve') {
                    $payment->update(['provider_id' => $response['id']]);
                    return $links['href'];
                }
            }
        }
    }

    /**
     * Capture order
     *
     * @param string $token
     * @return mixed|string
     * @throws \Throwable
     */
    public function capture(string $token)
    {
        $response = $this->provider->capturePaymentOrder($token);

        if (isset($response['error']) && isset($response['error']['details'])){
            foreach ($response['error']['details'] as $errorDetail){
                activity('paypal_capture')
                    ->event($errorDetail['issue'])
                    ->log($errorDetail['description']);
            }

            return ResponseMessage::custumized('Payment could not completed.');
        }

        if (isset($response['status']) && $response['status'] == 'COMPLETED') {
            $payment = Payment::where('provider_id', $response['id'])->first();

            $payment->update([
                'status' => $response['status'],
                'payer_first_name' => $response['payer']['name']['given_name'] ?? 'not found',
                'payer_last_name' => $response['payer']['name']['surname'] ?? 'not found',
                'payer_email' => $response['payer']['email_address'] ?? 'not found',
                'provider_fee' => $response['purchase_units'][0]['payments']['captures'][0]['seller_receivable_breakdown']['paypal_fee']['value'],
                'net_amount' => $response['purchase_units'][0]['payments']['captures'][0]['seller_receivable_breakdown']['net_amount']['value'],
                'meta' => $response['purchase_units'][0]['payments']['captures'][0]['links']
            ]);

            return ResponseMessage::success('Payment completed successfully');
        }

        activity('paypal_capture')
            ->event('no_info');

        return ResponseMessage::custumized('Payment could not be completed.');
    }

    private function createOrderInstance(Order $order, Payment $payment): array
    {
        return [
            "intent" => "CAPTURE",
            "application_context" => [
                "return_url" => env('FRONT_APP_URL') . "/etkinlikler/{$order->model->slug}" . env('PAYPAL_REDIRECT_ENDPOINT'),
                "cancel_url" => 'https://berlindeyiz.de/cancel',
            ],
            "purchase_units" => [
                [
                    "amount" => [
                        "currency_code" => $this->currencyCode,
                        "value" => $order->total
                    ],
                    'description' => 'Product description',
                    'custom_id' => $payment->id, // Custom ID for the purchase unit
                    'custom_fields' => [
                        [
                            'label' => 'Commission',
                            'value' => '1.00',
                            'description' => 'Berlindeyiz commission'
                        ],
                        [
                            'order_id' => $order->id,
                            'payment_id' => $payment->id,
                            'description' => 'örnek',
                        ]
                    ]
                ]
            ]
        ];
    }

}