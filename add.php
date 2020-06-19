<?php

    include('session.php');
    
    if (isset($_POST['name'])) {

        $id = isset($_POST['id']) ? intval($_POST['id']) : 0;

        $filanme = 0;

        if(isset($_FILES['foto']['error']) && $_FILES['foto']['error'] == 0) {
            require('vendor/autoload.php');

            $uid = uniqid();
            $ext = pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION);


            $fileName = 'foto_' . $uid . '.' . $ext;
            $fileNameOrg = 'org_' . $uid . '.' . $ext;
            $imagine = new Imagine\Gd\Imagine();
            $size    = new Imagine\Image\Box(200, 200);
            $mode    = Imagine\Image\ImageInterface::THUMBNAIL_INSET;
            //$mode    = Imagine\Image\ImageInterface::THUMBNAIL_OUTBOUND;
            $imagine->open($_FILES['foto']['tmp_name'])
                ->thumbnail($size, $mode)
                ->save(__DIR__ . '/img/' . $fileName);
            ;

            move_uploaded_file($_FILES['foto']['tmp_name'], __DIR__ . '/img/' . $fileNameOrg);
            
        }

        if($id >0) {

            if ($fileName) {
                $toadd = $pdo->prepare('UPDATE `person` SET `name`= :name, `surname`=:surname, `prof_id`=:prof_id, `location`=:location, `description`=:description, `foto`=:foto WHERE id_person = :id');
                $toadd->bindParam(':foto', $fileName);
                
                $sthFoto = $pdo->prepare('SELECT foto FROM person WHERE id_person = :id');
                //bindowanie parametru i zmiennej - dodatkowe filtrowanie sqlinjection
                $sthFoto->bindParam(':id', $id);
                $sthFoto->execute();
                $foto = $sthFoto->fetch()['foto'];
                
                if($foto) {
                    unlink(__DIR__ .'/img/' . $foto);
                    unlink(__DIR__ .'/img/' . str_replace('foto_', 'org_', $foto));
                }

            } else {
                $toadd = $pdo->prepare('UPDATE `person` SET `name`= :name, `surname`=:surname, `prof_id`=:prof_id, `location`=:location, `description`=:description WHERE id_person = :id');                
            }
            $toadd->bindParam(':id', $id);
           
        }else {      
            $toadd = $pdo->prepare('INSERT INTO `person`(`name`, `surname`, `prof_id`, `location`, `description`, foto) VALUES ( :name, :surname, :prof_id, :location, :description, :foto)');
            if($fileName) {
                $toadd->bindParam(':foto', $fileName);           
            }         
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


<form action="add.php" method="post" enctype=multipart/form-data><BR><BR>

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
    Foto: <input type="file" name="foto"><BR><BR>
    <?php
        if (isSet($result['foto']) && $result['foto']) {
            echo '<img src="img/' . $result['foto'] .'">';
        }
    ?><BR><BR>
    Description: <textarea name="description"><?php if(isset($result['description'])) {echo $result['description'];} ?></textarea><BR><BR>
    <input type="submit" value="Save">
</form>