<?php 
declare (strict_types = 1);
require_once(__DIR__ . '/../database/user.class.php');

class Ticket {
    public int $id;
    public string $title;
    public string $description;
    public User $ticketCreator;
    public User $ticketAssignee;
    public string $status;
    public string $priority;
    public datetime $dateCreated;
    public array $hashtags;
    public bool $isFaq;

    public function __construct(int $id, string $title, string $description, User $ticketCreator, User $ticketAssignee, string $status, string $priority, datetime $dateCreated, array $hashtags, bool $isFaq) {
        $this->id = $id;
        $this->title = $title;
        $this->description = $description;
        $this->ticketCreator = $ticketCreator;
        $this->ticketAssignee = $ticketAssignee;
        $this->status = $status;
        $this->priority = $priority;
        $this->dateCreated = $dateCreated;
        $this->hashtags = $hashtags;
        $this->isFaq = $isFaq;
    } 
}
?>