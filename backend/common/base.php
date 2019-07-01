<?php
function response($body){
    # Formats a API response
    if (!array_key_exists("error", $body)) {
        return json_encode(array(
            "message" => $body["message"]
        ));
    } else {
        return json_encode(array(
            "message" => $body["message"],
            "error"   => $body["error"]
        ));
    }
}
?>