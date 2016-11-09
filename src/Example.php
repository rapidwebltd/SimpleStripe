<?php

require_once '../vendor/autoload.php';

use \RapidWeb\SimpleStripe\Factories\SimpleStripeFactory;

$publishableKey = 'pk_test_tmdmCoJxEaUKDhNYkOBnXXOO';
$secretKey = 'sk_test_n4IUmv3VMmPPxDXSReIbergg';

$currency = 'GBP'; // Great British Pounds

$simpleStripe = SimpleStripeFactory::create($publishableKey, $secretKey, $currency);

if (isset($_POST['stripeToken'])) {

    $amount = 500; // Five hundred pence = Five pounds (5 GBP)

    $charge = $simpleStripe->charge($amount, $_POST['stripeToken']);

    if ($charge->succeeded) {
        echo "Success!";
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