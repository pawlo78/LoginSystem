<?php    

include('session.php');

    echo '<B>List of candidates:</B><BR>';
    //zapytanie do bazy danych
    $tbl = $pdo->query('Select * from person');
    //link do pliku dodaj ADD
    echo '<BR><a href="add.php">Add user</a><BR><BR>';

    //wyświetlenie
    echo '<table border="1">';
    echo '<tr>';
        echo '<th>Name</th>';
        echo '<th>Surname</th>';
        echo '<th>Profession</th>';
        echo '<th>Location</th>';
        echo '<th>Description</th>';
        echo '<th>Options</th>';
    echo '</tr>';
        
    foreach ($tbl->fetchAll() as $value) {
        echo '<tr>';
            echo '<td>'.$value['name'].'</td>';
            echo '<td>'.$value['surname'].'</td>';
            $tblProf = $pdo->query('Select * from professions WHERE id = "'.$value['prof_id'].'"');
            foreach ($tblProf as $valueProf) {
                echo '<td>'.$valueProf['nameProf'].'</td>';                        
            }           
            echo '<td>'.$value['location'].'</td>';
            echo '<td>'.$value['description'].'</td>';
            echo '<td><a href="delete.php?id='.$value['id_person'].'">Delete</a></td>';     
            echo '<td><a href="add.php?id='.$value['id_person'].'">Edit</a></td>';         
        echo '</tr>';
    }

    echo '</table>';

?>