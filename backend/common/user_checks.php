<?php
include_once dirname(__FILE__)."\..\controllers\db_requests.php";

function emailValidation($email){
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}

function userExists($email){
    $row = selectWhereQuery("user", "email", $email);
    
    if ($row) {
        return true;
    }
    return false;
}
?>
