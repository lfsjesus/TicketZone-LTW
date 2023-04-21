<?php
    require_once(__DIR__ . '/../database/user.class.php');
    class Session {
        private array $messages; 
        public function __construct() {
            session_start();
            $this->messages = isset($_SESSION['messages']) ? $_SESSION['messages'] : array();
            unset($_SESSION['messages']);
        }

        public function isLoggedIn() : bool {
            return isset($_SESSION['id']);
        }

        public function logout() {
            session_destroy();
        }

        public function getId() : int {
            return isset($_SESSION['id']) ? $_SESSION['id'] : null;
        }

        // this can be used to get information about the user (type, username, etc.)
        public function getUser() : User {
            return isset($_SESSION['user']) ? $_SESSION['user'] : null;
        } 

        public function setId(int $id) {
            $_SESSION['id'] = $id;
        }

        public function setUser(User $user) {
            $_SESSION['user'] = $user;
        }
        
        public function getMessages() {
            return $this->messages;
        }

        public function addMessage(string $type, string $message) {
            $this->messages[] = array('type' => $type, 'message' => $message);
        }
    }
?>