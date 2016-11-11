<?php

namespace RapidWeb\SimpleStripe\Objects;

use \RapidWeb\SimpleStripe\Factories\ChargeFactory;
use \Stripe\Stripe;

class SimpleStripe
{
    private $paymentFormDirectory = null;

    private $publishableKey = null;
    private $secretKey = null;

    public $currency = null;

    public function __construct($publishableKey, $secretKey, $currency)
    {
        $this->publishableKey = $publishableKey;
        $this->secretKey = $secretKey;
        $this->currency = strtolower($currency);

        $this->paymentFormDirectory = __DIR__.'/../Resources/PaymentForms/';

        Stripe::setApiKey($this->secretKey);
        Stripe::setAppInfo('SimpleStripe', '', 'https://github.com/rapidwebltd/SimpleStripe');
    }

    private function getPaymentForm($type)
    {
        $filename = basename($type).'.html';
        $html = file_get_contents($this->paymentFormDirectory.$filename);
        $html = str_replace('[[SIMPLESTRIPE_PUBLISHABLE_KEY]]', $this->publishableKey, $html);
        $html = str_replace('[[CSRF_FIELD]]', function_exists("csrf_field") ? csrf_field() : '', $html);
        return $html;
    }

    public function paymentForm()
    {
        return $this->getPaymentForm('Simple');
    }

    public function charge($amount, $stripeToken, $description = '')
    {
        $charge = ChargeFactory::create($this, $amount, $stripeToken, $description);

        $charge->process();

        return $charge;
    }
}