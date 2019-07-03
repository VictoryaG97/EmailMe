<?php
    include_once dirname(__FILE__)."\..\controllers\mailbox.php";

    class MailBox {
        private $id;
        private $box_name;
        private $owner_id;
        private $owner_email;
        private $type;
        private $ref_number;

        public function setId($id) {
            $this->id = $id;
        }

        public function setBoxName($box_name) {
            $this->box_name = $box_name;
        }

        public function setOwnerId($owner_id) {
            $this->owner_id = $owner_id;
        }

        public function setOwnerEmail($owner_email) {
            $this->owner_email = $owner_email;
        }

        public function setBoxType($type) {
            $this->type = $type;
        }

        public function setRefNumber($ref_number) {
            $this->ref_number = $ref_number;
        }

        public function getId() {
            if (!$this->id) {
                $response = selectAndWhereQuery("mail_box", ["box_name", "owner_id"], [$this->box_name, $this->getOwnerId()]);
                if ($response) {
                    $this->id = $response[0]["id"];
                }
            }
            return $this->id;
        }
        
        public function getBoxName() {
            return $this->box_name;
        }

        public function getOwnerId() {
            if (!$this->owner_id) {
                $response = selectWhereQuery("user", "email", $this->owner_email);
                if ($response) {
                    $this->owner_id = $response[0]["id"];
                }
            }
            return $this->owner_id;
        }

        public function getOwnerEmail() {
            return $this->owner_email;
        }

        public function getBoxType() {
            if (!$this->type) {
                $this->type = 1;
            }
            return $this->type;
        }

        public function getRefNumber() {
            if (!$this->ref_number) {
                $this->ref_number = 0;
            }
            return $this->ref_number;
        }

        public function createMailBox() {
            // return create_mailbox($email, $this->box_name);
            $response = array();
            $insert_request = insertQuery(
                "mail_box",
                ["box_name", "owner_id", "type", "ref_number"],
                [$this->getBoxName(), $this->getOwnerId(), $this->getBoxType(), $this->getRefNumber()]
            );
            if ($insert_request["status"]) {
                $response["statusCode"] = 200;
                $response["message"] = "Mailbox created!";
            } else {
                $response["statusCode"] = 400;
                $response["message"] = "Could not create the mailbox";
            }
            return $response;
        }

        public function getMails() {
            $response = array();
            try {
                $mails = selectWhereQuery("mail", "mailbox_id", $this->getId());
                http_response_code(200);
                if ($mails) {
                    foreach ($mails as $mail) {
                        $sender_info = selectWhereQuery("user", "id", $mail["id"]);
                        $response[] = array(
                            "sender"   => $sender_info[0]["email"],
                            "subject"  => $mail["subject"],
                            "send_date"=> $mail["send_date"]
                        );
                    }
                    echo json_encode(array(
                        "body" => $response
                    ));
                } else {
                    echo json_encode(array(
                        "body" => ""
                    ));
                }
            } catch (Exception $e) {
                http_response_code(401);

                echo json_encode(array(
                    "message" => "Error",
                    "error" => $e->getMessage()
                ));
            }
        }

        public function getMail($mail_id) {
            $response = array();
            try {
                $mail = selectWhereQuery("mail", "mail_id", $mail_id);
                if ($mail) {
                    $sender_info = selectWhereQuery("user", "id", $mail[0]["id"]);
                    http_response_code(200);
                    echo json_encode(array(
                        "body" => array(
                            "sender"   => $sender_info[0]["email"],
                            "subject"  => $mail[0]["subject"],
                            "message"  => $mail[0]["message"],
                            "send_date"=> $mail[0]["send_date"]
                        )
                    ));
                } else {
                    http_response_code(404);
                    echo json_encode(array(
                        "message" => "Error",
                        "error" => "Message not found!"
                    ));
                }
            } catch (Exception $e) {
                http_response_code(401);
                echo json_encode(array(
                    "message" => "Error",
                    "error" => $e->getMessage()
                ));
            }
        }
    }
?>