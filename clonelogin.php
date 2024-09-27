<?php
session_start();
require('API/vendor/autoload.php');
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
$secreteKey = "neweandomKey";
use bandwidthThrottle\tokenBucket\Rate;
use bandwidthThrottle\tokenBucket\TokenBucket;
use bandwidthThrottle\tokenBucket\storage\FileStorage;

$storage = new FileStorage(__DIR__ . "/api.bucket");
$rate    = new Rate(100, Rate::SECOND);
$bucket  = new TokenBucket(100, $rate, $storage);
if (!$bucket->consume(1, $seconds)) {
    http_response_code(429);
    header(sprintf("Retry-After: %d", floor($seconds)));
    exit();
}else{
    $headers = apache_request_headers();
    if(isset($headers['Authorization'])){
        $authorizationHeader = $headers['Authorization'];
        $headerVal = explode(' ',$authorizationHeader);
        try {
            $jwt = $headerVal[1];
            JWT::decode($jwt, new key($secreteKey,'HS256'));

            echo 'Authorization process in session';
        } catch (Exception $th) {
            echo 'ERROR: '.$th->getMessage();
        }
    }
}
// try {
//     $calc = hash_hmac('sha256', 'clonelogin.php', $_SESSION['token']);
//     if ($_POST['token']) {
//         if (hash_equals($calc, $_POST['token'])) {

//         }else{
//             echo 'No Authorization error found';
//         }
//     }
// } catch (\Throwable $th) {
//     echo $th->getMessage();
// }