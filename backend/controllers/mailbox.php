<?php
    function create_mailbox($user_email, $box_name) {
        $response = array();

        $user_response = selectWhereQuery("user", "email", $user_email);

        if ($user_response){
            $owner_id = $user_response[0]["id"];

            $insert_request = insertQuery(
                "mail_box",
                ["box_name", "owner_id"],
                [$box_name, $owner_id]
            );
                if ($insert_request["status"]) {
                $response["statusCode"] = 200;
                $response["message"] = "Mailbox created!";
            } else {
                $response["statusCode"] = 400;
                $response["message"] = "Could not create the mailbox";
            }
        } else {
            $response["statusCode"] = 404;
            $response["message"] = "User not found";
        }
        return $response;
    }

    function get_user_mailboxes($user_email) {
        $response = array();
        $user_info = selectWhereQuery("user", "email", $user_email);

        if ($user_info) {
            $owner_id = $user_info[0]["id"];
            $mailbox_info = selectWhereQuery("mail_box", "owner_id", $owner_id);
            if ($mailbox_info) {
                http_response_code(200);
                echo json_encode($mailbox_info);
            } else {
                http_response_code(404);
                echo json_encode(array("message" => ""));
            }
        } else {
            http_response_code(404);
            echo response(array("message" => "User not found"));
        }
    }
?>