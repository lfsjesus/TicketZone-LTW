<?php 
declare (strict_types = 1);
require_once(__DIR__ . '/../database/user.class.php');
require_once(__DIR__ . '/../database/comment.class.php');

class Ticket {
    public int $id;
    public string $title;
    public string $description;
    public User $ticketCreator;
    public ?User $ticketAssignee;
    public string $department;
    public string $status;
    public ?string $priority;
    public datetime $dateCreated;
    public array $hashtags;
    public bool $isFaq;

    public function __construct(int $id, string $title, string $description, User $ticketCreator, ?User $ticketAssignee, string $department, string $status, ?string $priority, datetime $dateCreated, array $hashtags, bool $isFaq) {
        $this->id = $id;
        $this->title = $title;
        $this->description = $description;
        $this->ticketCreator = $ticketCreator;
        $this->ticketAssignee = $ticketAssignee;
        $this->department = $department;
        $this->status = $status;
        $this->priority = $priority;
        $this->dateCreated = $dateCreated;
        $this->hashtags = $hashtags;
        $this->isFaq = $isFaq;
    } 

    static function getTicket(PDO $db, int $id) : ?Ticket {
        $stmt = $db->prepare('SELECT id, user_id, agent_id, department_id, title, description, status, priority, date, faq FROM Tickets WHERE id = ?');
        $stmt->execute(array($id));
        $ticket = $stmt->fetch();

        if ($ticket) {
            $ticketCreator = User::getUser($db, $ticket['user_id']);
            $ticketAssignee = User::getUser($db, $ticket['agent_id']);
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

            return new Ticket(
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
            );
        } else return null;

    }

    static function getTicketsByHashtag(PDO $db, string $hashtag) : array {
        $stmt = $db->prepare('SELECT t.* FROM Tickets t JOIN TicketTagJunction ttj ON t.id = ttj.ticket_id JOIN TicketHashtags th on ttj.hashtag_id = th.id WHERE th.hashtag = ?');
        $stmt->execute(array($hashtag));

        $tickets = array();

        foreach ($stmt->fetchAll() as $ticket) {
            $ticketCreator = User::getUser($db, $ticket['user_id']);
            $ticketAssignee = User::getUser($db, $ticket['agent_id']);
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

    static function getTicketsByDepartment(PDO $db, string $department) : array {
        $stmt = $db->prepare('SELECT id, user_id, agent_id, department_id, title, description, status, priority, date, faq FROM Tickets WHERE department_id = ?');
        $stmt->execute(array($department));

        $tickets = array();

        foreach ($stmt->fetchAll() as $ticket) {
            $ticketCreator = User::getUser($db, $ticket['user_id']);
            $ticketAssignee = User::getUser($db, $ticket['agent_id']);
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

    public function getAnswers(PDO $db) : array {
        $stmt = $db->prepare('SELECT id, ticket_id, user_id, comment, date FROM Comments WHERE ticket_id = ?');
        $stmt->execute(array($this->id));

        $answers = array();

        foreach ($stmt->fetchAll() as $answer) {
            $answerCreator = User::getUser($db, $answer['user_id']);

            array_push($answers, new Comment(
                $answer['id'],
                $answer['ticket_id'],
                $answerCreator,
                $answer['comment'],
                new DateTime($answer['date'])
            ));
        }
        return $answers;
    }

    public function attachments(PDO $db) {
        $stmt = $db->prepare("SELECT * FROM Files WHERE ticket_id = ?");
        $stmt->execute([$this->id]);
        return $stmt->fetchAll();
    }
}
?>