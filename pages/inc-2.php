<?php
require_once "vendor/autoload.php";

use QuickBooksOnline\Payments\PaymentClient;
use QuickBooksOnline\Payments\Operations\ChargeOperations;

$accessToken = $_SESSION['token'];

$client2 = new PaymentClient([
  'access_token' => $accessToken,
  'environment' => "sandbox" //  or 'environment' => "production"
]);

$array = [
  "amount" => "10.55",
  "currency" => "USD",
  "context" => [
    "mobile" => "false",
    "isEcommerce" => "true",
  ],
  "card" => [
    "name" => "emulate=0",
    "number" => "4111111111111111",
    "address" => [
      "streetAddress" => "1130 Kifer Rd",
      "city" => "Sunnyvale",
      "region" => "CA",
      "country" => "US",
      "postalCode" => "94086",
    ],
    "expYear" => "2020",
    "expMonth" => "02",
    "cvc" => "123",
    "request-Id" => "435345345345345"
  ],

];
$charge = ChargeOperations::buildFrom($array);
$response = $client2->charge($charge);

if ($response->failed()) {
  $code = $response->getStatusCode();
  $errorMessage = $response->getBody();

  echo "code is $code <br>";
  echo "body is $errorMessage<br>";

}
else {
  $responseCharge = $response->getBody();
  //Get the Id of the charge request
  $id = $responseCharge->id;
  //Get the Status of the charge request
  $status = $responseCharge->status;
  echo "Id is " . $id . "<br>";
  echo "status is " . $status . "<br>";
}

echo "<pre>";
print_r($response);
echo "</pre>";

//echo "<pre>";
//print_r($response);
//echo "</pre>";


?>

<div class="container">
    <div class="pageHome">
        <form action="" method="post">

            <div>
                <strong>USER DETAILS</strong>
                <input type="text" placeholder="Company Name">
                <input type="text" placeholder="Email">
                <input type="text" placeholder="Project ID Number">
                <select name="" id="">
                    <option value="">Takeoff Type</option>
                </select>
            </div>

            <div>
                <strong>CREDIT CARD //img here</strong>
                <input type="text" placeholder="Name on Card">
                <input type="text" placeholder="Card Number">
                <input type="text" placeholder="Expiration Date">
                <input type="text" placeholder="Security Code">
                <input type="text" placeholder="ZIP / Postal Code">
            </div>


            <div>
                <button type="submit">PURCHASE ($100)</button>
                <p>By making this purchase, you agree to the associated terms
                    and conditions.</p>
            </div>
        </form>
    </div>

</div>