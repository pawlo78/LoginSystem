<?php

    include('session.php');
    
    if (isset($_POST['nameProf'])) {

        $id = isset($_POST['id']) ? intval($_POST['id']) : 0;
        if($id >0) {
            $toadd = $pdo->prepare('UPDATE `professions` SET `nameProf`= :nameProf WHERE id = :id');
            $toadd->bindParam(':id', $id);
        }else {
            $toadd = $pdo->prepare('INSERT INTO `professions`(`nameProf`) VALUES ( :nameProf)');
        }

        //bindowanie parametru i zmiennej - dodatkowe filtrowanie sqlinjection
        $toadd->bindParam(':nameProf', $_POST['nameProf']);
        $toadd->execute();

        header('location: profession.php');
    }  
    
    $idGet = isset($_GET['id']) ? intval($_GET['id']) : 0;
    if($idGet >0) {
        $tomod = $pdo->prepare('SELECT * FROM professions WHERE id = :id');
        //bindowanie parametru i zmiennej - dodatkowe filtrowanie sqlinjection
        $tomod->bindParam(':id', $idGet);
        $tomod->execute();
        $result = $tomod->fetch();        
    }


?>


<form action="add_prof.php" method="post"><BR><BR>

    <?php
        if($idGet > 0) {
            echo '<input type="hidden" name="id" value="'.$idGet.'">';           
        }
    ?>   

    Profession: <input type="text" name="nameProf"<?php if(isset($result['nameProf'])) {echo 'value="'.$result['nameProf'].'"';} ?>><BR><BR>
    <input type="submit" value="Save">
</form>