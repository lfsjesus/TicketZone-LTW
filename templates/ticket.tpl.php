<?php 
require_once(__DIR__ . '/../database/ticket.class.php');

function drawTicket(Ticket $ticket){ 
?>
    <tr>
        <td><input type="checkbox" name="ticket[]"></td>
        <td><?php echo $ticket->ticketCreator->name(); ?></td>
        <td><?php echo $ticket->title; ?></td>
        <td><?php echo $ticket->ticketAssignee->name(); ?></td>
        <td><?php echo $ticket->status; ?></td>
        <td><?php echo $ticket->priority; ?></td>
        <td><?php echo $ticket->dateCreated->format('d/m/Y H:i'); ?></td>
    </tr>
    <tr>
        <td></td>
        <td><?php echo $ticket->ticketCreator->email; ?></td>
        <td><?php echo substr($ticket->description, 0, 50) . '...'; ?></td>
    </tr>
<?php 
} 
?>
