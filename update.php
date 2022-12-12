<?php
session_start();
require_once "config.php";
$id = $book_name = $book_current_copies =  "";

$theme_id = $_SESSION['theme_id'];
$nickname = $_SESSION['nickname'];
if(isset($_GET['id'])){
    $id = trim(intval($_GET['id']));
    $sql = "SELECT * from books where id=?";
     if($stmt = mysqli_prepare($link, $sql)){
            mysqli_stmt_bind_param($stmt, "i", $param_id);
            
            $param_id = $id;
            
            if(mysqli_stmt_execute($stmt)){
                $result = mysqli_stmt_get_result($stmt);
    
                if(mysqli_num_rows($result) == 1){
                    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);                    
                    $book_name = $row["book_name"];
                    $book_current_copies = $row["book_current_copies"];
                    $book_cost = $row["book_cost"];
                    $_SESSION['book_name'] = $row['book_name'];
                } 
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        mysqli_stmt_close($stmt);
        }
}
elseif(isset($_POST['book_name'])){
$book_name = trim($_POST['book_name']);
$id = trim($_POST['id']);


       $sql = "UPDATE books SET book_name = ?  where id=?";
        if($stmt = mysqli_prepare($link, $sql)){
            mysqli_stmt_bind_param($stmt, "si", $param_book_name, $param_id);

            $param_book_name = $book_name;
            $param_id = $id;

            if(mysqli_stmt_execute($stmt)){
             
             header('location: comment.php');
             exit();
            } else{
                echo "Ошибка.";
            }
        mysqli_stmt_close($stmt);}
        
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


 <form class="table" action="update.php" method="post">
    <blockquote><?echo $book_name;?></blockquote>
                      <input type="text" name="id" hidden value="<? echo $id;?>">
                      <textarea name="book_name" class="form-control"><? echo $_SESSION['book_name'];?></textarea>
                      Стоимость:<br>
                      <input type="text" name="id" placeholder="Стоимость" value="<? echo $book_cost;?>"><br>
                      Количество экземпляров:<br>
                      <input type="text" name="id" placeholder="Количество экземпляров" value="<? echo $book_current_copies;?>"><br>
                      <input type="submit" name="submit" value="submit" class="btn btn-primary pull-right">
                    </form>

</div>
        <? include "footer.php";?>
<? mysqli_close($link);?>
</body>
</html>