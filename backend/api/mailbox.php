<?php
require __DIR__.'\..\vendor\autoload.php';
use \Firebase\JWT\JWT;

include_once dirname(__FILE__)."\..\common\base.php";
include_once dirname(__FILE__)."\..\controllers\db_requests.php";
include_once dirname(__FILE__)."\..\base_models\mailbox.php";

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");


// check if user is logged in
JWT::$leeway = 5;
$secret_key = "secret_key_test";
$jwt = null;

$request_method = $_SERVER['REQUEST_METHOD'];
$authHeader = $_SERVER['HTTP_AUTHORIZATION'];
$email = $_SERVER["HTTP_EMAIL"];

$input = json_decode(file_get_contents('php://input'), TRUE);

$arr = explode(" ", $authHeader);
$jwt = $arr[1];

if($jwt) {
    try {
        $decoded = JWT::decode($jwt, $secret_key, array('HS256'));

        if($request_method == "GET") {
            echo get_user_mailboxes($email);
        } else {
            $mailbox = new MailBox();
            $mailbox->setOwnerEmail($email);
            $mailbox->setBoxName($input["name"]);
            $mailbox->setBoxType($input["type"]);
            $mailbox->setRefNumber($input["ref_number"]);
            $box_response = $mailbox->createMailBox();
        
            http_response_code($box_response["statusCode"]);
            echo response($box_response);
        }
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
        "error" => $e->getMessage()
    ));
}
?>