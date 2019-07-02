<?php
require __DIR__.'\..\vendor\autoload.php';
use \Firebase\JWT\JWT;

include_once dirname(__FILE__)."\..\common\base.php";
include_once dirname(__FILE__)."\..\base_models\mailbox.php";
include_once dirname(__FILE__)."\..\controllers\mailbox.php";
include_once dirname(__FILE__)."\..\controllers\db_requests.php";

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");


// check if user is logged in
JWT::$leeway = 5;
$secret_key = "secret_key_test";
$jwt = null;
$authHeader = $_SERVER['HTTP_AUTHORIZATION'];
$email = $_SERVER["HTTP_EMAIL"];

$input = json_decode(file_get_contents('php://input'), TRUE);

$arr = explode(" ", $authHeader);
$jwt = $arr[1];

if($jwt) {
    try {
        $decoded = JWT::decode($jwt, $secret_key, array('HS256'));

        $mail = new MailBox();
        $mail->setBoxName($input["box_name"]);
        $mail->setOwnerEmail($email);
        echo $mail->getMails();
    } catch (Exception $e) {
        http_response_code(401);
    
        echo json_encode(array(
            "message" => "Access denied.",
            "error" => $e->getMessage()
        ));
    }
} else {
    http_response_code(401);
    
    echo json_encode(array(
        "message" => "Access denied.",
        "error" => "No token provided"
    ));
}
?>