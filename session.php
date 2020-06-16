<?php

include('db_connect.php');

session_start();

if(isset($_POST['login'])) {

    //zapis danych logowania do zmiennych
    $login = $_POST['login'];
    $pass = md5($_POST['pass']);
  
    $tomod = $pdo->prepare('SELECT * FROM users WHERE login = :login AND pass = :pass');
    //bindowanie parametru i zmiennej - dodatkowe filtrowanie sqlinjection
    //PDO::rzutowanie na typ zmiennej
    $tomod->bindParam(':login', $login, PDO::PARAM_STR);
    $tomod->bindParam(':pass', $pass, PDO::PARAM_STR);
    $tomod->execute();
    $result = $tomod->fetch();
    
    if($result && isSet($result['id'])) {
        $_SESSION['logged'] = true;
        $_SESSION['userLogin'] = $result['login'];
        header('location:index.php');
    }
}


if(!isset($_SESSION['logged']) || $_SESSION['logged'] == false) {

?>

<!-- formularz logowania -->
<form action="session.php" method="post"><BR><BR>
Login:<BR> <input type="text" name="login"><BR><BR>
Pass: <input type="password" name="pass"><BR><BR>
<input type="submit" value="Login">
</form>

<?php

        die;
    }

?>


