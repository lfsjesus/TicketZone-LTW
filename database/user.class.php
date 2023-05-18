<?php
    declare(strict_types = 1);
    require_once(__DIR__ . '/../database/ticket.class.php');
    require_once(__DIR__ . '/../database/department.class.php');

    class User {
        public ?int $id;
        public ?string $username;
        public ?string $email;
        public ?string $firstName;
        public ?string $lastName;
        public ?string $type;
        public ?Department $department;

        public function __construct(int $id, string $username, string $email, string $firstName, string $lastName, string $type, ?Department $department) {
            $this->id = $id;
            $this->username = $username;
            $this->email = $email;
            $this->firstName = $firstName;
            $this->lastName = $lastName;
            $this->type = $type;
            $this->department = $department;
        }

        function name() {
            return $this->firstName . ' ' . $this->lastName;
        }

        function save($db) {
            // Check if updated email or username already exists in database
            $stmt = $db->prepare('SELECT id FROM Users WHERE (email = ? OR username = ?) AND id != ?');
            $stmt->execute(array($this->email, $this->username, $this->id));
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($result) {
                // Email or username already exists, redirect to profile page with error message
                header('Location: ../pages/profile.php');
                exit;
            }
        
            // Email and username do not exist, update user's information
            $stmt = $db->prepare('UPDATE Users SET firstName = ?, lastName = ?, username = ?, email = ?, department_id = ?, type = ? WHERE id = ?');
            $stmt->execute(array($this->firstName, $this->lastName, $this->username, $this->email, $this->department->id, $this->type, $this->id));
        }
        

        static function getUserWithEmail(PDO $db, string $email) : ?User {
            $stmt = $db->prepare('SELECT id, username, email, firstName, lastName, type, department_id FROM Users WHERE lower(email) = ?');
            $stmt -> execute(array(strtolower($email)));

            $user = $stmt->fetch(); 
            $department = Department::getDepartment($db, $user['department_id']);            
            if ($user) {
                return new User(
                    $user['id'],
                    $user['username'],
                    $user['email'],
                    $user['firstName'],
                    $user['lastName'],
                    $user['type'],
                    $department
                );
            } else return null;
        }

        static function getUser(PDO $db, ?int $id) : ?User {
            $stmt = $db->prepare('SELECT id, username, email, firstName, lastName, type, department_id FROM Users WHERE id = ?');
            $stmt -> execute(array($id));

            $user = $stmt->fetch();
            $department = Department::getDepartment($db, $user['department_id']);

            if ($user) {
                return new User(
                    $user['id'],
                    $user['username'],
                    $user['email'],
                    $user['firstName'],
                    $user['lastName'],
                    $user['type'],
                    $department
                );
            } else return null;
        }

        static function getAgents (PDO $db) : array {
            $stmt = $db->prepare('SELECT * FROM Users WHERE type = ?');
            $stmt->execute(array('agent'));
            $stmt = $stmt->fetchAll();
            $agents = array();
            foreach ($stmt as $agent) {
                $department = Department::getDepartment($db, $agent['department_id']);
                array_push($agents, new User(
                    $agent['id'],
                    $agent['username'],
                    $agent['email'],
                    $agent['firstName'],
                    $agent['lastName'],
                    $agent['type'],
                    $department
                ));
            }
            return $agents;
        }
        
        static function getUsers (PDO $db) : array {
            $stmt = $db->prepare('SELECT * FROM Users');
            $stmt->execute();
            $stmt = $stmt->fetchAll();
            $users = array();
            foreach ($stmt as $user) {
                $department = Department::getDepartment($db, $user['department_id']);
                array_push($users, new User(
                    $user['id'],
                    $user['username'],
                    $user['email'],
                    $user['firstName'],
                    $user['lastName'],
                    $user['type'],
                    $department
                ));
            }
            return $users;
        }
        
        static function isAdmin() : bool {
            return $_SESSION['user']->type == 'admin';
        }
    }
