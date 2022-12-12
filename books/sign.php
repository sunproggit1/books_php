<?php
session_start();
require_once "config.php";

$nickname = $surname = $name = $pass = $email = "";
$nickname_err = $surname_err = $name_err = $pass_err = $email_err = "";
if($_SERVER["REQUEST_METHOD"] == "POST"){
    $input_nickname = trim($_POST["nickname"]);
    if(empty($input_nickname)){
        $nickname_err = "Введите Псевдоним:";
    } else{
        $nickname = $input_nickname;
    }
    $input_surname = trim($_POST["surname"]);
    if(empty($input_surname)){
        $surname_err = "Введите Фамилию:";
    } else{
        $surname = $input_surname;
    }
    $input_name = trim($_POST["name"]);
    if(empty($input_name)){
        $name_err = "Введите Имя:";
    } else{
        $name = $input_name;
    }
    $input_pass = trim($_POST["pass"]);
    if(empty($input_pass)){
        $pass_err = "Введите Пароль:";
    } else{
        $pass = sha1($input_pass);
    }
    $input_email = trim($_POST["email"]);
    if(empty($input_email)){
        $email_err = "Введите Электронную Почту:";
    } else{
        $email = $input_email;
    }
    $role = 'user';
    
    if(empty($name_err) && empty($email_err) && empty($pass_err) && empty($nickname_err) && empty($surname_err)){
$sql1 = "INSERT INTO Clients(nickname,passwd,surname,name,email,role) values(?,(SELECT sha1(?)),?,?,?,'user')";
if($stmt1 = mysqli_prepare($link, $sql1)){
    mysqli_stmt_bind_param($stmt1, "sssss", $param_nickname, $param_pass, $param_surname, $param_name, $param_email);
            $param_nickname = $nickname;
            $param_surname = $surname;
            $param_name = $name;
            $param_pass = $input_pass;
            $param_email = $email;
            if(mysqli_stmt_execute($stmt1)){
             
              session_unset();
                            
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

 header('location: index.php');
                exit();

            } else{
                echo "Ошибка.";
            }
        
        mysqli_stmt_close($stmt1);
        }
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
  <p></p>

<br><br><br>
 <form action="sign.php" method="POST">
<input type="text" placeholder="Псевдоним" name="nickname" class="form-control"><hr>
<input type="text" placeholder="Фамилия" name="surname" class="form-control"><hr>
<input type="text" placeholder="Имя" name="name" class="form-control"><hr>
<input type="password" placeholder="Пароль"name="pass" class="form-control"><hr>
<input type="text" placeholder="Почта" name="email" class="form-control"><hr>
<input type="submit" value="Зарегистрироваться">
</form>


<br><br><br>
</div>
        
        <? include "footer.php";?>
<? mysqli_close($link);?>

</body>
</html>