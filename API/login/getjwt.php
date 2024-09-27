<?php
require('../vendor/autoload.php');

use Firebase\JWT\JWT;
try {
    $secreteKey = "c50be242171e9b8449c17765eff742993b6bd7b5b0ca3195ff74fe17ddd5ebb4";

    $payload = array(
        'iss' => $_SERVER['SERVER_NAME'],
        'iat' => time(),
        'exp' => strtotime('+1 hour'),
        'email' => 'hellow@gmail.com'
    );
    
    $jwt = JWT::encode($payload,$secreteKey, 'HS256');
    if($jwt){
        echo json_encode(["status" => "success", "message" => $jwt]);
    }else{
        exit(json_encode('error'));
    }
} catch (\Throwable $th) {
    echo $jwt;
}
