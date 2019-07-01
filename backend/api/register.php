<?php
include_once dirname(__FILE__)."\..\common\user_checks.php";
include_once dirname(__FILE__)."\..\common\base.php"; // response 
include_once dirname(__FILE__)."\..\controllers\mailbox.php";
include_once dirname(__FILE__)."\..\controllers\db_requests.php";
include_once dirname(__FILE__)."\..\base_models\user.php";

header("Access-Control-Allow-Origin: * ");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

$input = json_decode(file_get_contents('php://input'), TRUE);

$email = $input["email"];
$first_name = $input["first_name"];
$last_name = $input["last_name"];
$password = $input["password"];
$fn = $input["fn"];

# check if user with this emal exists in the db and if not, add the user
if (userExists($email)) {
    http_response_code(409);
    echo response(array("message" => "User already exists"));
} else {
    $password_hash = password_hash($password, PASSWORD_DEFAULT);

    $user = new User();
    $user->setEmail($email);
    $user->setPass($password_hash);
    $user->setFirstName($first_name);
    $user->setLastName($last_name);
    $user->setFn($fn);
    $user->setRole("User");

    $user_response = $user->createUser();
    http_response_code($user_response["statusCode"]);
    echo response($user_response);  
}
?>