<?php
    declare(strict_types = 1);

    class User {
        public int $id;
        public string $username;
        public string $email;
        public string $firstName;
        public string $lastName;
        public string $type;
        public int $department_id;

        public function __construct(int $id, string $username, string $email, string $firstName, string $lastName, string $type, int $department_id) {
            $this->id = $id;
            $this->username = $username;
            $this->email = $email;
            $this->firstName = $firstName;
            $this->lastName = $lastName;
            $this->type = $type;
            $this->department_id = $department_id;
        }

        function name() {
            return $this->firstName . ' ' . $this->lastName;
        }

        function save($db) {
            $stmt = $db->prepare('UPDATE USERS SET firstName = ?, lastName = ? WHERE id = ?');
            $stmt->execute(array($this->firstName, $this->lastName, $this->id));
        }

        static function getUserWithEmail(PDO $db, string $email) : ?User {
            $stmt = $db->prepare('SELECT id, username, email, firstName, lastName, type, department_id FROM Users WHERE lower(email) = ?');
            $stmt -> execute(array(strtolower($email)));

            $user = $stmt->fetch(); 
            
            if ($user) {
                return new User(
                    $user['id'],
                    $user['username'],
                    $user['email'],
                    $user['firstName'],
                    $user['lastName'],
                    $user['type'],
                    $user['department_id']
                );
            } else return null;
        }

        static function getUser(PDO $db, int $id) : ?User {
            $stmt = $db->prepare('SELECT id, username, email, firstName, lastName, type, department_id FROM Users WHERE id = ?');
            $stmt -> execute(array($id));

            $stmt->execute(array($id));
            $user = $stmt->fetch();
            
            return new User(
                $user['id'],
                $user['username'],
                $user['email'],
                $user['firstName'],
                $user['lastName'],
                $user['type'],
                $user['department_id']
            );
        }
    }

?>