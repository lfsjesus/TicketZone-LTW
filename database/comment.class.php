<?php 
declare (strict_types = 1);
require_once(__DIR__ . '/../database/user.class.php');

class Comment {
    public int $id;
    public int $ticket_id;
    public User $user;
    public string $comment;
    public datetime $date;

    public function __construct(int $id, int $ticket_id, User $user, string $comment, datetime $date) {
        $this->id = $id;
        $this->ticket_id = $ticket_id;
        $this->user = $user;
        $this->comment = $comment;
        $this->date = $date;
    } 

    public function attachments(PDO $db) {
        $stmt = $db->prepare("SELECT * FROM Files WHERE comment_id = ?");
        $stmt->execute([$this->id]);
        return $stmt->fetchAll();
    }
}
?>