<?php
    include_once dirname(__FILE__)."\..\controllers\mailbox.php";

    class MailBox {
        private $id;
        private $box_name;
        private $owner_id;
        private $owner_email;

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

        public function createMailBox($email) {
            return create_mailbox($email, $this->box_name);
        }

        public function getMails() {
            $response = array();
            try {
                $mails = selectWhereQuery("mail", "mailbox_id", $this->getId());
                if ($mails) {
                    http_response_code(200);
                    echo json_encode($mails);
                } else {
                    http_response_code(404);
                    echo json_encode(array(
                        "mailbox_id" => $this->id,
                        "owner_email" => $this->owner_email,
                        "owner_id" => $this->owner_id,
                        "box_name" => $this->box_name
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