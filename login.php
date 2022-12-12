<?php
session_start();
require_once "config.php";
session_unset();
$nickname = $pass = "";
$nickname_err = $pass_err = "";
if($_SERVER["REQUEST_METHOD"] == "POST"){
    $input_nickname = trim($_POST["nickname"]);
    if(empty($input_nickname)){
        $nickname_err = "Введите Псевдоним:";
    } else{
        $nickname = $input_nickname;
    }
    $input_pass = trim($_POST["pass"]);
    if(empty($input_pass)){
        $pass_err = "Пароль:";
    } else{
        $pass = sha1($input_pass);
    }    
    
    
        $sql = "SELECT * from clients where nickname=? and passwd=(SELECT sha1(?))";
        if($stmt = mysqli_prepare($link, $sql)){
            mysqli_stmt_bind_param($stmt, "ss", $param_nickname, $param_pass);
            $param_nickname = $nickname;
            $param_pass = $input_pass;
        if(mysqli_stmt_execute($stmt)){
          $result = mysqli_stmt_get_result($stmt);
         if(mysqli_num_rows($result) == 1){
                    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
                    $nickname = $row["nickname"];
                    $pass = $row["pass"];
                    $surname = $row["surname"];
                    $name = $row["name"];
                    $email = $row["email"];
                    $role = $row["role"];
                    session_unset();
                    $_SESSION['user_id']=$row["id"];
                    $_SESSION['nickname']=$nickname;
                    $_SESSION['surname']=$surname;
                    $_SESSION['name']=$name;
                    $_SESSION['email']=$email;
                    $_SESSION['role']=$role;
            header('location: index.php');
                exit();
              }
            else{
                echo "Неверное имя или пароль.";
            }
        }
        else {
          echo "Что то пошло не так.";
        }
      
mysqli_stmt_close($stmt);
}

}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name = "viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/sim-slider.js"></script>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/bootstrap-theme.min.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/slyder.css">
    <title>Библиотека</title>
    
</head>
<body>
                <? include 'header.php';?>
    

<div class="content col-lg-12">

<br><br><br>
 <form action="login.php" method="post">
<input type="text" name="nickname" placeholder="Псевдоним"><hr>
<input type="password" name="pass" placeholder="Пароль"><hr>
<input type="submit" value="Войти">
</form>

<br><br><br>
<br><br><br>
</div>
        
        <? include "footer.php";?>
<? mysqli_close($link);?>

</body>
</html>