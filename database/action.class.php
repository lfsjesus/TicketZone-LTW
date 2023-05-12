<?php
declare(strict_types=1);

class Action
{
    public int $id;
    public int $ticketId;
    public int $userId;
    public string $action;
    public DateTime $date;

    public function __construct(int $id, int $ticketId, int $userId, string $action, DateTime $date)
    {
        $this->id = $id;
        $this->ticketId = $ticketId;
        $this->userId = $userId;
        $this->action = $action;
        $this->date = $date;
    }

    static function getActionsByUserId(PDO $db, int $userId): array
    {
        $stmt = $db->prepare('SELECT * FROM Actions WHERE user_id = ? ORDER BY date DESC');
        $stmt->execute([$userId]);
    
        $actions = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $action = new Action(
                (int)$row['id'],
                (int)$row['ticket_id'],
                (int)$row['user_id'],
                $row['action'],
                new DateTime($row['date'])
            );
            $actions[] = $action;
        }
    
        return $actions;
    } 
}