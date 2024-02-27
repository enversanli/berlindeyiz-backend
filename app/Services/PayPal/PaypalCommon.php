<?php

namespace App\Services\PayPal;

use Srmklive\PayPal\Services\PayPal as PayPalClient;

class PaypalCommon
{
    protected $provider;
    protected $accessToken;
    protected $currencyCode = 'EUR';

    public function __construct()
    {
        $this->provider = new PayPalClient();
        $this->provider->setApiCredentials(config('paypal'));
        $this->accessToken = $this->provider->getAccessToken();
    }
}