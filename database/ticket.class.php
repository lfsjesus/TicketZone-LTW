<?php 
declare (strict_types = 1);
require_once(__DIR__ . '/../database/user.class.php');
require_once(__DIR__ . '/../database/comment.class.php');
require_once(__DIR__ . '/../database/department.class.php');

class Ticket {
    public int $id;
    public string $title;
    public string $description;
    public ?User $ticketCreator;
    public ?User $ticketAssignee;
    public ?Department $department;
    public string $status;
    public ?string $priority;
    public datetime $dateCreated;
    public array $hashtags;

    public function __construct(int $id, string $title, string $description, ?User $ticketCreator, ?User $ticketAssignee, ?Department $department, string $status, ?string $priority, datetime $dateCreated, array $hashtags) {
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
    } 

    static function getTicket(PDO $db, int $id) : ?Ticket {
        $stmt = $db->prepare('SELECT id, user_id, agent_id, department_id, title, description, status, priority, date FROM Tickets WHERE id = ?');
        $stmt->execute(array($id));
        $ticket = $stmt->fetch();

        if ($ticket) {
            $ticketCreator = User::getUser($db, $ticket['user_id']);
            $ticketAssignee = User::getUser($db, $ticket['agent_id']);
            $department = Department::getDepartment($db, $ticket['department_id']);
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
                $hashtags
            );
        } else return null;

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

    public function getHashtags(PDO $db) : array {
        $stmt = $db->prepare('SELECT th.id, th.hashtag FROM TicketHashtags th JOIN TicketTagJunction ttj ON th.id = ttj.hashtag_id WHERE ttj.ticket_id = ?');
        $stmt->execute(array($this->id));
        $hashtags = array();

        foreach ($stmt->fetchAll() as $hashtag) {
            array_push($hashtags, array($hashtag['id'], $hashtag['hashtag']));
        }
        return $hashtags;
    }

    public function attachments(PDO $db) {
        $stmt = $db->prepare("SELECT * FROM Files WHERE ticket_id = ?");
        $stmt->execute([$this->id]);
        return $stmt->fetchAll();
    }

    function save($db) {
        $stmt = $db->prepare('Update Tickets SET title = ?, description = ?, status = ?, priority = ?, department_id = ?, agent_id = ?  WHERE id = ?');
        $stmt->execute(array($this->title,$this->description,$this->status, $this->priority, $this->department->id, $this->ticketAssignee->id, $this->id));
    }
}
