<?php 
function drawTicket(){ 
    $priorities = array("Low", "High", "Urgent");
?>
    <article class="ticket">
        <p>This is just a test. This is just a test. This is just a test.
             This is just a test. This is just a test. This is just a test. This is just a test.</p>    
        <form method="post" action="process_ticket.php">
            <select name="priority" id="priority">
                <?php foreach($priorities as $priority): ?>
                    <option value="<?php echo $priority; ?>"><?php echo $priority; ?></option>
                <?php endforeach; ?>
            </select>
            <input type="submit" value="Save">
        </form>
    </article>
<?php 
} 
?>