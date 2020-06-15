<?php
    
    try {
        $pdo = new PDO('mysql:host=localhost; dbname=db_persons', 'root', '123456');
        //pdo wyrzuca błedy przy zapytaniach jesli wystąpią
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);        
        //zwraca tablice asocjacyjną
        $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        //kodowanie
        $pdo->query('SET NAMES utf8');        
    } catch (PDOException $ex) {
        echo $ex->getMessage();
    }

?>