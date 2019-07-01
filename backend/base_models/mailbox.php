<?php
    include_once dirname(__FILE__)."\..\controllers\mailbox.php";

    class MailBox {
        private $id;
        private $box_name;
        private $owner_id;

        public function setId($id) {
            $this->id = $id;
        }

        public function setBoxName($box_name) {
            $this->box_name = $box_name;
        }

        public function setOwnerId($owner_id) {
            $this->owner_id = $owner_id;
        }

        public function getId() {
            return $this->id;
        }
        
        public function getBoxName() {
            return $this->box_name;
        }

        public function getOwnerId() {
            return $this->owner_id;
        }

        public function createMailBox($email) {
            return create_mailbox($email, $this->box_name);
        }
    }
?>