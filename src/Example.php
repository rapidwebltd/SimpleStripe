<?php

require_once '../vendor/autoload.php';

use \RapidWeb\SimpleStripe\Factories\SimpleStripeFactory;

$simpleStripe = SimpleStripeFactory::create('PUBLISHABLE_KEY', 'SECRET_KEY', 'GBP'); // GBP = Great British Pounds

if (isset($_POST['stripeToken'])) {

    $amount = 500; // Five hundred pence = Five pounds (5 GBP)

    $charge = $simpleStripe->charge($amount, $_POST['stripeToken']);

    if ($charge->succeeded) {
        echo "Success! <a href=\"Example.php\">Make another payment.</a>";
    } else {
        if ($charge->problemType=='Card') {
            echo $charge->problem;
        } else {
            echo "Sorry, there was a problem processing your payment. <a href=\"Example.php\">Please try again.</a>";
        }
    }

    die;
}

echo $simpleStripe->paymentForm();