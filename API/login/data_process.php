<?php
session_start();
require('../vendor/autoload.php');
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
$secreteKey = "c50be242171e9b8449c17765eff742993b6bd7b5b0ca3195ff74fe17ddd5ebb4";
function sanitaize($data)
{
    $data = htmlspecialchars($data, ENT_QUOTES);
    $data = filter_var($data, FILTER_SANITIZE_STRING);
    $data = strip_tags($data);
    return $data;
}
$viewDataClass = new Login\viewData();
$Ip = $_SERVER['REMOTE_ADDR'] || $_SERVER['SERVER_ADDR'];
$dataIp = json_decode($viewDataClass->IpStatus($Ip));
if ($dataIp->status == 'success') {
    try {
        $headers = apache_request_headers();
        if (isset($headers['Authorization'])) {
            $authorizationHeader = $headers['Authorization'];
            $headerVal = explode(' ', $authorizationHeader);
            $jwt = $headerVal[1];
            try {
                if (JWT::decode($jwt, new key($secreteKey, 'HS256'))) {
                    if ($_SESSION['token_data']) {
                        $calc = hash_hmac('sha256', 'http://localhost/database/Church/API/login/data_process.php', $_SESSION['token_data']);
                        $data = json_decode(file_get_contents("php://input"), true);
                        if ($data['token_data']) {
                            if (hash_equals($calc, $data['token_data'])) {
                                $pass = Sanitaize($data['Key']);
                                $token = $data['token_data'];
                                if (isset($_GET['permission'])) {
                                    $result_data = $viewDataClass->CheckPermission($pass);
                                } else {
                                    $name = Sanitaize($data['User']);
                                    $result_data = $viewDataClass->CheckCredentials($pass, $name);
                                }
                                echo json_encode(['status' => 'success', 'message' => $result_data]);
                            } else {
                                echo json_encode(['status' => 'error', 'message' => 'Invalid Token']);
                            }
                        } else {
                            echo json_encode(['status' => 'error', 'message' => 'No Authorization error found']);
                        }
                    } else {
                        echo json_encode(['status' => 'error', 'message' => 'No Authorization error found']);
                    }
                }
            } catch (Exception $th) {
                echo json_encode(['status' => 'error', 'message' => 'ERROR: ' . $th->getMessage()]);
            }
        }
    } catch (\Throwable $th) {
        echo json_encode(['status' => 'error', 'message' => $th->getMessage()]);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => $dataIp->status]);
}
