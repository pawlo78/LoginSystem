<?php

    include('session.php');

    $id = isset($_GET['id']) ? intval($_GET['id']) : 0;

    if($id >0) {

        $delFoto = $pdo->prepare('SELECT foto FROM person WHERE id_person = :id');
        //bindowanie parametru i zmiennej - dodatkowe filtrowanie sqlinjection
        $delFoto->bindParam(':id', $id);
        $delFoto->execute();
        $foto = $delFoto->fetch()['foto'];

        if($foto) {
            unlink(__DIR__ .'/img/' . $foto);
            unlink(__DIR__ .'/img/' . str_replace('foto_', 'org_', $foto));
        }

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