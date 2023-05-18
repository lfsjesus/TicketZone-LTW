<?php

    function getStatus($db){
        $stmt = $db->prepare('SELECT * FROM Statuses');
        $stmt->execute();
        return $stmt->fetchAll();
    }

    function getFAQ($db){
        $stmt = $db->prepare('SELECT * FROM FAQ');
        $stmt->execute();
        return $stmt->fetchAll();
    }

    function getHashtags($db){
        $stmt = $db->prepare('SELECT * FROM TicketHashtags');
        $stmt->execute();
        return $stmt->fetchAll();
    }

?>