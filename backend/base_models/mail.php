<?php
    class Mail {
        private $id;
        private $mailbox_id;
        private $sender_id;
        private $reciever_id;
        private $ref_number;
        private $message;
        private $subject;
        private $send_date;
        private $is_read;

        public function setId($id) {
            $this->id = $id;
        }

        public function setMailboxId($mail_type) {
            $response = selectWhereQuery(
                "mail_box", "type", $mail_type
            );
            if ($mail_type == 1) {
                foreach ($response as $row) {
                    if ($row["owner_id"] == $this->getRecieverId())
                        $this->mailbox_id = $row["id"];
                }
            } else {
                foreach ($response as $row) {
                    if ($row["ref_number"] == $this->ref_number)
                        $this->mailbox_id = $row["id"];
                }
            }
        }

        public function setSenderId($sender_email) {
            $sender_info = selectWhereQuery("user", "email", $sender_email);
            if ($sender_info){
                $this->sender_id = $sender_info[0]["id"];
            }
        }

        public function setRecieverId($reciever_email) {
            $reciever_info = selectWhereQuery("user", "email", $reciever_email);
            if ($reciever_info) {
                $this->reciever_id = $reciever_info[0]["id"];
            }
        }

        public function setRefNumber($ref_number, $box_type) {
            $this->ref_number = $ref_number;

            if ($box_type != 1) {
                $response = selectWhereQuery(
                    "mail_box", "type", $box_type
                );

                foreach ($response as $row) {
                    if ($row["ref_number"] == $this->ref_number)
                        $this->reciever_id = $row["owner_id"];
                }
            }
        }

        public function setMessage($message) {
            $this->message = $message;
        }

        public function setSubject($subject) {
            $this->subject = $subject;
        }

        public function setSendDate($send_date) {
            $this->send_date = $send_date;
        }

        public function getId() {
            return $this->id;
        }
        
        public function getSenderId() {
            return $this->sender_id;
        }

        public function getRecieverId() {
            return $this->reciever_id;
        }

        public function getMessage() {
            return $this->message;
        }

        public function getSubject() {
            return $this->subject;
        }

        public function getSendDate() {
            return $this->send_date;
        }

        public function sendMail() {
            $response = null;

            if ($this->sender_id && $this->reciever_id){
                $insert_request = insertQuery(
                    "mail",
                    ["mailbox_id", "sender_id", "reciever_id", "message", "subject", "send_date", "is_read"],
                    [$this->mailbox_id, $this->sender_id, $this->reciever_id, $this->message, $this->subject, date("Y/m/d"), false]
                );

                if ($insert_request["status"]) {
                    $response["statusCode"] = 200;
                    // $response["message"] = "Mail send!";
                    $response["message"] = array(
                        "queryResponse" => $insert_request["queryResponse"],
                        "status"=> $insert_request["status"],
                        "mailbox_id" => $this->mailbox_id,
                        "sender_id" =>$this->sender_id,
                        "reciever_id" => $this->reciever_id
                    );
                } else {
                    $response["statusCode"] = 400;
                    $response["message"] = "Could not sent the mail";
                }
            } else {
                $response["statusCode"] = 404;
                $response["message"] = "Reciever not found!";
            }
            return $response; 
        }
    }
?>