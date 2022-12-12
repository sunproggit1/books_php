<?php
session_start();
require_once "config.php";
$name = "";
//print_r($_POST);

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

                            
                                $sql= "SELECT id,nickname,role,profileimg FROM clients order by id desc";
                    if($result = mysqli_query($link, $sql)){
                        if(mysqli_num_rows($result) > 0){
                            echo "<ul class='nav'><li >Клиенты:</li>";
                                    
                                while($row = mysqli_fetch_array($result)){
                                    if($row['nickname']!="Sundet"){
                                      if($row['profileimg']!=NULL){
                                       echo "<li><a class='btn' href='profile.php?id=". $row['id']; echo "' title='View Record' >
                                       <img height='100px' src='profileimg/".$row['profileimg']."'>".$row['nickname'].": <span>".$row['role']."</span> </a></li>"; }
                                       else {
                                        echo "<li><a class='btn' href='profile.php?id=". $row['id']; echo "' title='View Record' >".$row['nickname'].": <span>".$row['role']."</span> </a></li>"; }
                                      
                                    }

                                    
                                }
                                echo "</ul> <hr><hr>";

                            // Free result set
                            mysqli_free_result($result);
                        } 
                    }
                     


                    ?> 



  </div>
  <div class="col-lg-3">
    
  </div>
</div>
        
        <? include "footer.php";?>
        <? mysqli_close($link);?>

</body>
</html>