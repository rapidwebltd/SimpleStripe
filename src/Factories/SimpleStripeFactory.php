<?php

namespace RapidWeb\SimpleStripe\Factories;

use \RapidWeb\SimpleStripe\Objects\SimpleStripe;

abstract class SimpleStripeFactory
{
    public static function create($publishableKey, $secretKey, $currency)
    {
        return new SimpleStripe($publishableKey, $secretKey, $currency);
    }
}