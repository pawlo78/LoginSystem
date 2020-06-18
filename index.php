<?php    

include('session.php');

    //stronicowanie
    $page = isset($_GET['page']) ? intval($_GET['page'] - 1) : 1;
    $countRecords = $pdo->query('SELECT COUNT(id_person) as cnt FROM person')->fetch()['cnt'];
    $limitPages = 10;
    $from = $page * $limitPages;
    $allPages = ceil($countRecords / $limitPages);

    function t1($val, $min, $max) {
        return ($val >= $min && $val <= $max);
    }

    
    //zapytanie do bazy danych
    $sqlQuery ='Select pe.*, pr.nameProf FROM person pe LEFT JOIN professions pr ON pe.prof_id = pr.id 
                ORDER BY pe.prof_id DESC LIMIT '.$from.','.$limitPages.';'; 
    $tbl = $pdo->query($sqlQuery);
    
    echo 'PAGE: '.$page.'<BR>';
    echo 'COUNT: '.$countRecords.'<BR>';
    echo 'PAGE: '.$limitPages.'<BR>';
    echo 'FROM: '.$from.'<BR>';
    echo 'ALL PAGE: '.$allPages.'<BR>';
    echo 'SQL: '.$sqlQuery.'<BR>';
    
    //link do pliku dodaj ADD
    echo '<BR><a href="add.php">Add user</a><BR><BR>';

    //wyświetlenie
    echo '<table border="1">';
    echo '<tr>';
        echo '<th>Id</th>';
        echo '<th>Name</th>';
        echo '<th>Surname</th>';
        echo '<th>Profession</th>';
        echo '<th>Location</th>';
        echo '<th>Description</th>';
        echo '<th>Options</th>';
    echo '</tr>';
        
    foreach ($tbl->fetchAll() as $value) {
        echo '<tr>';
            echo '<td>'.$value['id_person'].'</td>';
            echo '<td>'.$value['name'].'</td>';
            echo '<td>'.$value['surname'].'</td>';
            echo '<td>'.$value['nameProf'].'</td>';                                               
            echo '<td>'.$value['location'].'</td>';
            echo '<td>'.$value['description'].'</td>';
            echo '<td><a href="delete.php?id='.$value['id_person'].'">Delete</a></td>';     
            echo '<td><a href="add.php?id='.$value['id_person'].'">Edit</a></td>';         
        echo '</tr>';
    }
    echo '</table>';

//wyswietlanie stronicowania
$firstPage = ($page > 4) ? '<a href="index.php?page=1">FIRST</a>' : ''; 
echo $firstPage;
for ($i=1; $i <=$allPages ; $i++) { 
    $bold = ($i == ($page+1)) ? 'style="font-size: 24px"' : '';
    
    if( t1($i, ($page-3), ($page+5))) {
        echo '<a '.$bold.' href="index.php?page='.$i.'">| '.$i.' |</a>';    
    }    
}
$lastPage = ($page < $allPages - 5) ? '<a href="index.php?page='.$allPages.'">LAST</a>' : ''; 
echo $lastPage;
?>
