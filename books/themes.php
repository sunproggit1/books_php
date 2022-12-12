<?php
session_start();
require_once "config.php";
$theme_id = "";
$janre_name = "";
$nickname = $_SESSION['nickname'];
if(isset($_POST['janre_name']) && !empty($_POST['janre_name'])){
$janre_name = trim($_POST["janre_name"]);
       $sql = "INSERT INTO Janre(janre_name) VALUES (?)";
        if($stmt = mysqli_prepare($link, $sql)){
            mysqli_stmt_bind_param($stmt, "s", $param_janre_name);
            
            $param_janre_name = $janre_name;
            
            if(mysqli_stmt_execute($stmt)){
              unset($_SESSION['janre_name']);
              $_SESSION['janre_name'] = $janre_name;
                header("location: comment.php");
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
  <div class="col-lg-3 alert alert-info">
               Популярные темы
                <?
                include 'side_popular_themes.php';
                ?>
  </div>
  <div class="col-lg-6">
<?
                            
                                $sql1 = "SELECT * FROM janre";
                    if($result1 = mysqli_query($link, $sql1)){
                        if(mysqli_num_rows($result1) > 0){
                            echo "<ul class='nav table'><li >Темы:</li>";
                                    
                                while($row = mysqli_fetch_array($result1)){
                                    
                                        echo "<form action='comment.php' method='post'>
                                       <input type='text' hidden name='theme_id' value='".$row['id']."'>
                                       <input type='text' hidden name='janre_name' value='".$row['janre_name']."'>
                                       <textarea hidden name='janre_curr_books'>".$row['janre_curr_books']."</textarea>
                                       <input type='submit' class='form-control' value='".$row['janre_name']."(".$row['janre_curr_books'].")'>
                                       </form>";

                                }
                                echo "</ul>";

                            // Free result set
                            mysqli_free_result($result1);
                        } 
                    } 

                    ?>


<br><br><br>
<br><br><br>
<br><br><br>

  </div>
  <div class="col-lg-3">
    
    Добавить тему
    <?
    echo '<form action="themes.php" method="post">
                      <input type="text" name="janre_name" class="form-control" placeholder="Ваш вопрос">
                      <input type="submit" name="submit" class="btn btn-primary pull-right">
                    </form>';
  ?>
  </div>
</div>
        
        <? include "footer.php";?>

        <?
 mysqli_close($link);
 ?>
</body>
</html>