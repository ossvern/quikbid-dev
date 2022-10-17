<?php
require_once "vendor/autoload.php";

use QuickBooksOnline\Payments\OAuth\OAuth2Authenticator;
use QuickBooksOnline\Payments\PaymentClient;

$code = $_GET['code'];


$client = new PaymentClient();
$oauth2Helper = OAuth2Authenticator::create([
  'client_id' => 'ABaNmlJgIsNJ0xEeS2KvR6oKCZPhXCFKUJ2bwaBndvyBKVqlwJ',
  'client_secret' => 'cp7HlZuqZoyfsgTlQWI7SlVGhZNAZ3Hm0kjO78rZ',
  'redirect_uri' => 'https://quikbid.oss-studio.com/connect',
  'environment' => 'development' // or 'environment' => 'production'
]);
$scope = "com.intuit.quickbooks.accounting openid profile email phone address";
$authorizationCodeURL = $oauth2Helper->generateAuthCodeURL($scope);
if (!$code) {
  header('Location: ' . $authorizationCodeURL);
}
else {
  $request = $oauth2Helper->createRequestToExchange($code);
  $response = $client->send($request);
  if ($response->failed()) {
    $code = $response->getStatusCode();
    $errorMessage = $response->getBody();
    echo "--code is $code \n";
    echo "---body is $errorMessage \n";
  }
  else {
    $array = json_decode($response->getBody(), TRUE);
    echo "<pre>";
    print_r($array);
    echo "</pre>";
    $refreshToken = $array["refresh_token"];
    $accessToken = $array["access_token"];
//    echo "<h1>$refreshToken ---</h1>";
    $_SESSION['token'] = $accessToken;
    header("Location: $url/");
  }
}


