<?php

namespace App\Http\Actions\PayPl;

use Srmklive\PayPal\Services\PayPal as PayPalClient;

class AccessToken
{
  public function get()
  {
    $provider = new PayPalClient();
    $paypalToken = $provider->getAccessToken();
    $response = $provider->createOrder([
      "intent" => "CAPTURE",
      "application_context" => [
        "return_url" => env('FRONT_APP_URL') . env('PAYPAL_REDIRECT_ENDPOINT'),
        "cancel_url" => 'https://berlindeyiz.de/cancel',
      ],
      "purchase_units" => [
        0 => [
          "amount" => [
            "currency_code" => "USD",
            "value" => "1000.00"
          ]
        ]
      ]
    ]);

    $paymentApproveLink = '';

    if (isset($response['status']) && $response['status'] == 'CREATED') {
      foreach ($response['links'] as $links) {
        if ($links['rel'] == 'approve') {
          return $links['href'];
        }
      }
    }

    dd($response);
  }

  public function capture($token)
  {
    $provider = new PayPalClient;
    $provider->setApiCredentials(config('paypal'));
    $provider->getAccessToken();

    $response = $provider->capturePaymentOrder($token);

    if (isset($response['status']) && $response['status'] == 'COMPLETED') {
      return 'Transactıon Complated';
    } else {
      return  $response['message'] ?? 'Something went wrong.';
    }
  }

}