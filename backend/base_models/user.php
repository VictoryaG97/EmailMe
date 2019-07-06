<?php
    use \Firebase\JWT\JWT;

    class User {
        private $id;
        private $email;
        private $first_name;
        private $last_name;
        private $password;
        private $fn;
        private $role;
        private $token;

        public function setId($id) {
            $this->id = $id;
        }

        public function setEmail($email) {
            $this->email = $email;
        }

        public function setFirstName($first_name) {
            $this->first_name = $first_name;
        }

        public function setLastName($last_name) {
            $this->last_name = $last_name;
        }

        public function setPass($password) {
            $this->password = $password;
        }

        public function setFn($fn) {
            $this->fn = $fn;
        }

        public function setRole($role) {
            $this->role = $role;
        }

        public function setToken($token) {
            $this->token = $token;
        }

        public function getId() {
            return $this->id;
        }

        public function getEmail() {
            return $this->email;
        }

        public function getPass() {
            return $this->password;
        }

        public function getFirstName() {
            return $this->first_name;
        }

        public function getLastName() {
            return $this->last_name;
        }

        public function getFn() {
            return $this->fn;
        }

        public function getRole() {
            return $this->role;
        }

        public function createUser() {
            $response = null;
            $insert_request = insertQuery(
                "user",
                ["email", "first_name", "last_name", "password_hash", "fn", "role"],
                [$this->email, $this->first_name, $this->last_name, $this->password, $this->fn, $this->role]
            );
            if ($insert_request["status"]) {
                $box_response = create_mailbox($this->email, "Главна");
                
                if ($box_response["statusCode"] == 200){
                    $response = array(
                        "statusCode" => 200,
                        "message" => "User created!"
                    );
                } else {
                    $response = array(
                        "statusCode" => $box_response["statusCode"],
                        "message" => $box_response["message"],
                        "error" => $box_response["error"]
                    );
                }
            } else {
                $response = array(
                    "statusCode" => 400,
                    "message" => "Something happened!",
                    "error" => $insert_request["error"]
                );
            }
            return $response;
        }

        public function login() {
            $response = null;

            if ($this->verifyUser()) {
                $secret_key = "secret_key_test";
                $issuer_claim = "muffin";
                $audience_claim = "THE_AUDIENCE";
                $issuedat_claim = time();
                $notbefore_claim = $issuedat_claim + 10;
                $expire_claim = $issuedat_claim + 3600; // expire time in seconds

                $token = array(
                    "iss" => $issuer_claim,
                    "aud" => $audience_claim,
                    "iat" => $issuedat_claim,
                    "nbf" => $notbefore_claim,
                    "exp" => $expire_claim,
                    "data" => array(
                        "id" => $this->id,
                        "email" => $this->email
                ));

                $this->token = JWT::encode($token, $secret_key);
                $response = json_encode(
                    array(
                        "message" => "Successful login.",
                        "jwt" => $this->token,
                        "email" => $this->email,
                        "expireAt" => $expire_claim
                    ));
            }
            return $response;
        }

        private function verifyUser() {
            $user_info = selectWhereQuery("user", "email", $this->email);
            if ($user_info){
                $this->setId = $user_info[0]["id"];

                if (password_verify($this->password, $user_info[0]["password_hash"])){
                    return true;
                } else {
                    return false;
                }
            }
        }
    }
?>