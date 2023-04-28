<?php
    declare(strict_types = 1);
    require_once(__DIR__ . '/../database/ticket.class.php');

    class User {
        public ?int $id;
        public ?string $username;
        public ?string $email;
        public ?string $firstName;
        public ?string $lastName;
        public ?string $type;
        public ?int $department_id;

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
            $stmt = $db->prepare('UPDATE Users SET firstName = ?, lastName = ?, username = ?, email = ? WHERE id = ?');
            $stmt->execute(array($this->firstName, $this->lastName, $this->username, $this->email, $this->id));
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

        static function getUser(PDO $db, ?int $id) : ?User {
            $stmt = $db->prepare('SELECT id, username, email, firstName, lastName, type, department_id FROM Users WHERE id = ?');
            $stmt -> execute(array($id));

            $stmt->execute(array($id));
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

        static function getAgents (PDO $db) : array {
            $stmt = $db->prepare('SELECT * FROM Users WHERE type = ?');
            $stmt->execute(array('agent'));
            $stmt = $stmt->fetchAll();
            $agents = array();
            foreach ($stmt as $agent) {
                array_push($agents, new User(
                    $agent['id'],
                    $agent['username'],
                    $agent['email'],
                    $agent['firstName'],
                    $agent['lastName'],
                    $agent['type'],
                    $agent['department_id']
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
                array_push($users, new User(
                    $user['id'],
                    $user['username'],
                    $user['email'],
                    $user['firstName'],
                    $user['lastName'],
                    $user['type'],
                    $user['department_id']
                ));
            }
            return $users;
        } 

        public function getMyTickets(PDO $db) : array {
            $stmt = $db->prepare('SELECT id, user_id, agent_id, department_id, title, description, status, priority, date, faq FROM Tickets WHERE user_id = ?');
            $stmt->execute(array($this->id));
        
            $tickets = array();
        
            foreach ($stmt->fetchAll() as $ticket) {
                $ticketCreator = $this;
                $ticketAssignee = null;
                if ($ticket['agent_id'] != null) $ticketAssignee = User::getUser($db, $ticket['agent_id']);
                $department = $db->prepare('SELECT name FROM Departments WHERE id = ?');
                $department->execute(array($ticket['department_id']));
                $department = $department->fetch()['name'];
                $department = $department == null ? "None" : $department;
        
                $hashtags = array();
                $stmt = $db->prepare('SELECT th.hashtag FROM TicketHashtags th JOIN TicketTagJunction ttj ON th.id = ttj.hashtag_id WHERE ttj.ticket_id = ?');
                $stmt->execute(array($ticket['id']));
                foreach ($stmt->fetchAll() as $hashtag) {
                    array_push($hashtags, $hashtag['hashtag']);
                }
        
                array_push($tickets, new Ticket(
                    $ticket['id'],
                    $ticket['title'],
                    $ticket['description'],
                    $ticketCreator,
                    $ticketAssignee,
                    $department,
                    $ticket['status'],
                    $ticket['priority'],
                    new DateTime($ticket['date']),
                    $hashtags,
                    $ticket['faq'] == 1
                ));
            }
            return $tickets;
        }

        public function getMyAssignedTickets(PDO $db) : array {
            // this functionality is only for agents
            if ($this->type != 'agent') return NULL;

            $stmt = $db->prepare('SELECT id, user_id, agent_id, department_id, title, description, status, priority, date, faq FROM Tickets WHERE agent_id = ?');
            $stmt->execute(array($this->id));
        
            $tickets = array();
        
            foreach ($stmt->fetchAll() as $ticket) {
                $ticketCreator = User::getUser($db, $ticket['user_id']);
                $ticketAssignee = $this;
                $department = $db->prepare('SELECT name FROM Departments WHERE id = ?');
                $department->execute(array($ticket['department_id']));
                $department = $department->fetch()['name'];
                $department = $department == null ? "None" : $department;

                $hashtags = array();
                $stmt = $db->prepare('SELECT th.hashtag FROM TicketHashtags th JOIN TicketTagJunction ttj ON th.id = ttj.hashtag_id WHERE ttj.ticket_id = ?');
                $stmt->execute(array($ticket['id']));
                foreach ($stmt->fetchAll() as $hashtag) {
                    array_push($hashtags, $hashtag['hashtag']);
                }
        
                array_push($tickets, new Ticket(
                    $ticket['id'],
                    $ticket['title'],
                    $ticket['description'],
                    $ticketCreator,
                    $ticketAssignee,
                    $department,
                    $ticket['status'],
                    $ticket['priority'],
                    new DateTime($ticket['date']),
                    $hashtags,
                    $ticket['faq'] == 1
                ));
            }
            return $tickets;
        }
    }
?>