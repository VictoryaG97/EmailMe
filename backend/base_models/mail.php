<?php
    class Mail {
        private $id;
        private $mailbox_id;
        private $sender_id;
        private $reciever_id;
        private $message;
        private $subject;
        private $send_date;
        private $is_read;

        public function setId($id) {
            $this->id = $id;
        }

        public function setMailboxId($mailbox_name) {
            $all_boxes = selectWhereQuery("mail_box", "owner_id", $this->sender_id);
            foreach ($all_boxes as $box) {
                if ($box["box_name"] == $mailbox_name) {
                    $this->mailbox_id = $box["id"];
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
                    ["mailbox_id", "sender_id", "reciever_id", "message", "subject"],
                    [$this->mailbox_id, $this->sender_id, $this->reciever_id, $this->message, $this->subject]
                );

                if ($insert_request["status"]) {
                    $response["statusCode"] = 200;
                    $response["message"] = "Mail send!";
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