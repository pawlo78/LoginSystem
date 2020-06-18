<?php

    include('session.php');
    
    if (isset($_POST['name'])) {

        $id = isset($_POST['id']) ? intval($_POST['id']) : 0;
        if($id >0) {
            $toadd = $pdo->prepare('UPDATE `person` SET `name`= :name, `surname`=:surname, `prof_id`=:prof_id, `location`=:location, `description`=:description WHERE id_person = :id');
            $toadd->bindParam(':id', $id);
        }else {      
            $toadd = $pdo->prepare('INSERT INTO `person`(`name`, `surname`, `prof_id`, `location`, `description`) VALUES ( :name, :surname, :prof_id, :location, :description)');
                     
        }

        //bindowanie parametru i zmiennej - dodatkowe filtrowanie sqlinjection
        $toadd->bindParam(':name', $_POST['name']);
        $toadd->bindParam(':surname', $_POST['surname']);
        $toadd->bindParam(':prof_id', $_POST['prof_id']);
        $toadd->bindParam(':location', $_POST['location']);
        $toadd->bindParam(':description', $_POST['description']);       
        $toadd->execute();       

        header('location: index.php');
    }  
    
    $idGet = isset($_GET['id']) ? intval($_GET['id']) : 0;
    if($idGet >0) {
        $tomod = $pdo->prepare('SELECT * FROM person WHERE id_person = :id');
        //bindowanie parametru i zmiennej - dodatkowe filtrowanie sqlinjection
        $tomod->bindParam(':id', $idGet);
        $tomod->execute();
        $result = $tomod->fetch();        
    }

    $toprof = $pdo->prepare('SELECT * FROM professions ORDER BY nameProf ASC');
    //bindowanie parametru i zmiennej - dodatkowe filtrowanie sqlinjection   
    $toprof->execute();
    $profession = $toprof->fetchAll();  



?>


<form action="add.php" method="post"><BR><BR>

    <?php
        if($idGet > 0) {
            echo '<input type="hidden" name="id" value="'.$idGet.'">';           
        }
    ?>   

    Name: <input type="text" name="name"<?php if(isset($result['name'])) {echo 'value="'.$result['name'].'"';} ?>><BR><BR>
    Surname: <input type="text" name="surname"<?php if(isset($result['surname'])) {echo 'value="'.$result['surname'].'"';} ?>><BR><BR>
    Profession: <select name="prof_id">
        <?php
            foreach ($profession as $value) {
                $selected = ($value['id'] == $result['prof_id']) ? 'selected = "selected"' : '';
                echo '<option '.$selected.' value="'.$value['id'].'">'.$value['nameProf'].'</option>';
            }
        ?>
    </select><BR><BR>
    Location: <input type="text" name="location"<?php if(isset($result['location'])) {echo 'value="'.$result['location'].'"';} ?>><BR><BR>
    Description: <textarea name="description"><?php if(isset($result['description'])) {echo $result['description'];} ?></textarea><BR><BR>
    <input type="submit" value="Save">
</form>