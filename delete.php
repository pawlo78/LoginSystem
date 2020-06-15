<?php

    include('db_connect.php');

    $id = isset($_GET['id']) ? intval($_GET['id']) : 0;

    if($id >0) {
        //prepare z parametrem id
        $todel = $pdo->prepare('DELETE FROM person WHERE id_person = :id');
        //bindowanie parametru i zmiennej - dodatkowe filtrowanie sqlinjection
        $todel->bindParam(':id', $id);
        $todel->execute();
        //przekierowanie do strony głównej
        header('location: index.php');
    } else {
        header('location: index.php');
    }


?>