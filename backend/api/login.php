<?php
require __DIR__.'\..\vendor\autoload.php';
use \Firebase\JWT\JWT;

include_once dirname(__FILE__)."\..\controllers\db_requests.php";
include_once dirname(__FILE__)."\..\common\user_checks.php";
include_once dirname(__FILE__)."\..\common\base.php";
include_once dirname(__FILE__)."\..\base_models\user.php";

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

$input = json_decode(file_get_contents('php://input'), TRUE);

$email = $input["email"];
$password = $input["password"];

# check if user with this emal exists in the db and if not, add the user
if (!userExists($email)) {
    http_response_code(404);
    echo response(array("message" => "User not in the database"));
} else {
    $user = new User();
    $user->setEmail($email);
    $user->setPass($password);

    if ($login_response = $user->login()){
        http_response_code(200);
        echo $login_response;
    } else {
        http_response_code(404);
        echo response(array("message" => "Wrong password"));
    }
}
?>