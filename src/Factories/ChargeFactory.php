<?php

namespace RapidWeb\SimpleStripe\Factories;

use \RapidWeb\SimpleStripe\Objects\Charge;

abstract class ChargeFactory
{
    public static function create($simpleStripe, $amount, $token, $description)
    {
        return new Charge($simpleStripe, $amount, $token, $description);
    }
}