<?php
require __DIR__.'\..\vendor\autoload.php';
use \Firebase\JWT\JWT;

include_once dirname(__FILE__)."\..\common\base.php";
include_once dirname(__FILE__)."\..\base_models\mail.php";
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

$request_method = $_SERVER['REQUEST_METHOD'];
$authHeader = $_SERVER['HTTP_AUTHORIZATION'];
$email = $_SERVER["HTTP_EMAIL"];

$input = json_decode(file_get_contents('php://input'), TRUE);

$arr = explode(" ", $authHeader);
$jwt = $arr[1];

if($jwt) {
    try {
        $decoded = JWT::decode($jwt, $secret_key, array('HS256'));

        if ($request_method == 'GET') {
            $mail = new MailBox();
            $mail->setOwnerEmail($email);
            if (isset($_SERVER["HTTP_BOXNAME"])) {
                $box_name = rawurldecode($_SERVER["HTTP_BOXNAME"]);
                $resp = $mail->setBoxName($box_name);
            }
            if (isset($_SERVER["HTTP_MAILID"])) {
                // get specific email
                echo $mail->getMail($_SERVER["HTTP_MAILID"]);
            } else {
                // get all emails in this box
                echo $mail->getMails();
            }
        } else {
                $mail = new Mail();
                $mail->setSenderId($email);
                $mail_type = $input["type"];
                if ($mail_type == 1) {
                    $mail->setRecieverId($input["reciever"]);
                } else {
                    $mail->setRefNumber($input["reciever"], $mail_type);
                }
                $mail->setSubject($input["subject"]);
                $mail->setMessage($input["message"]);
                
                $mail->setMailboxId($mail_type);
                $mail_response = $mail->sendMail();
        
                http_response_code($mail_response["statusCode"]);
                echo response($mail_response);
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
        "error" => "No token provided"
    ));
}
?>