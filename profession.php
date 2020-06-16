<?php    

include('session.php');

    //zapytanie do bazy danych
    $tbl = $pdo->query('Select * from professions');
    //link do pliku dodaj ADD
    echo '<BR><a href="add_prof.php">Add profession</a><BR><BR>';

    //wyświetlenie
    echo '<table border="1">';
    echo '<tr>';
        echo '<th>Name</th>';
        echo '<th>Options</th>';
    echo '</tr>';
        
    foreach ($tbl->fetchAll() as $value) {
        echo '<tr>';
            echo '<td>'.$value['nameProf'].'</td>';          
            echo '<td><a href="delete_prof.php?id='.$value['id'].'">Delete</a></td>';     
            echo '<td><a href="add_prof.php?id='.$value['id'].'">Edit</a></td>';         
        echo '</tr>';
    }

    echo '</table>';

?>