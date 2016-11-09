<?php

namespace RapidWeb\SimpleStripe\Objects;

use \Stripe\Stripe;
use \Exception;
use \ReflectionClass;

class Charge
{
    private $simpleStripe = null;

    private $amount = null;
    private $token = null;
    private $description = null;

    public $succeeded = null;
    public $problem = null;
    public $problemType = null;

    public function __construct($simpleStripe, $amount, $token, $description)
    {
        $this->simpleStripe = $simpleStripe;
        $this->amount = $amount;
        $this->token = $token;
        $this->description = $description;
    }

    public function process()
    {
        try {

            $charge = \Stripe\Charge::create(array(
                "amount" => $this->amount,
                "currency" => $this->simpleStripe->currency,
                "source" => $this->token,
                "description" => $this->description
                ));
            $this->succeeded = true;

        } catch(Exception $e) {
            
            $this->succeeded = false;
            $this->problem = $e->getMessage();
            $this->problemType = (new ReflectionClass($e))->getShortName();

        }

        return $this->succeeded;
    }
}