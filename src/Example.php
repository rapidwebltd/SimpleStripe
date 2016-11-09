<?php
require_once '../vendor/autoload.php';

// Setup SimpleStripe using Stripe API keys and currency 
$simpleStripe = \RapidWeb\SimpleStripe\Factories\SimpleStripeFactory::create('PUBLISHABLE_KEY', 'SECRET_KEY', 'GBP'); // GBP = Great British Pounds

// If payment form has been submitted
if (isset($_POST['stripeToken'])) {

    // Get the amount to charge (in the currency's lowest denomination)
    $amount = 500; // Five hundred pence = Five pounds (5 GBP)

    // Charge the customer
    $charge = $simpleStripe->charge($amount, $_POST['stripeToken']);

    if ($charge->succeeded) {
        
        // If charge succeeded, display success messsage
        echo "Success! <a href=\"Example.php\">Make another payment.</a>";

    } elseif ($charge->problemType=='Card') {

        // If there was a problem with the card, display details of the problem
        echo $charge->problem;

    } else {

        // Else, display a generic failure message
        echo "Sorry, there was a problem processing your payment. <a href=\"Example.php\">Please try again.</a>";
    }

    die;
}

// Display a simple payment form
echo $simpleStripe->paymentForm();