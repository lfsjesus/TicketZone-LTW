<?php 
require_once(__DIR__ . '/../database/ticket.class.php');

function drawTicket(Ticket $ticket){ 
    ?> 
        <tr>
            <td><input type="checkbox" name="ticket[]"></td>
            <td class = "table-title"><?php echo $ticket->ticketCreator->name(); ?></td>
            <td class = "table-title"><?php echo $ticket->title; ?></td>
            <td rowspan ="2" class = "table-title"><?php echo ($ticket->ticketAssignee ? $ticket->ticketAssignee->name() : ''); ?></td>
            <td rowspan ="2" class = "table-title"><?php echo $ticket->status; ?></td>
            <td rowspan="2" class="table-title"><div class="<?php echo 'priority-' . strtolower($ticket->priority ?? ''); ?>"><?php echo $ticket->priority ?? '';?></td>   
            <td rowspan= "2" class = "table-title"><?php echo $ticket->dateCreated->format('d/m/Y H:i')?></td>
        </tr>
        <tr>
            <td></td>
            <td><?php echo $ticket->ticketCreator->email; ?></td>
            <td><?php echo substr($ticket->description, 0, 50) . '...'; ?></td>
        </tr>
    
    <?php 
    } 
    ?>
    