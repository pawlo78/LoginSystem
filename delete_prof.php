<?php

    include('session.php');

    $id = isset($_GET['id']) ? intval($_GET['id']) : 0;

    if($id >0) {
        //prepare z parametrem id
        $todel = $pdo->prepare('DELETE FROM professions WHERE id = :id');
        //bindowanie parametru i zmiennej - dodatkowe filtrowanie sqlinjection
        $todel->bindParam(':id', $id);
        $todel->execute();
        //przekierowanie do strony głównej
        header('location: profession.php');
    } else {
        header('location: profession.php');
    }


?>