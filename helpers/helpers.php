<?php 
function baseurl(){
    return sprintf(
      "%s://%s%s",
      isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off' ? 'https' : 'http',
      $_SERVER['SERVER_NAME'],
      $_SERVER['REQUEST_URI']
    );
  }

function validateToken($jwt){
  $secret = 'ssttinirahasia!';
  $tokenParts = explode('.', $jwt);
  $header = base64_decode($tokenParts[0]);
  $payload = base64_decode($tokenParts[1]);
  $signatureProvided = $tokenParts[2];


  $base64UrlHeader = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($header));
  $base64UrlPayload = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($payload));
  $signature = hash_hmac('sha256', $base64UrlHeader . "." . $base64UrlPayload, $secret, true);
  $base64UrlSignature = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($signature));

  // verify it matches the signature provided in the token
  $signatureValid = ($base64UrlSignature === $signatureProvided);
  
  return $signatureValid;

}
?>
