<?php
session_start();
require_once "config.php";
$nickname = $email = $role = "";

$id = $comcount = 0;
if(isset($_GET["id"]) && !empty(trim($_GET["id"]))){
 
    $input_id = trim(intval($_GET["id"]));
    
        $id = $input_id;
    
 $sql = "SELECT * from clients where id=?";
        if($stmt = mysqli_prepare($link, $sql)){
            mysqli_stmt_bind_param($stmt, "i", $param_id);
            $param_id = intval($id);
        if(mysqli_stmt_execute($stmt)){
          $result = mysqli_stmt_get_result($stmt);
         if(mysqli_num_rows($result) > 0){
                    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
                    $nickname =  $row["nickname"];
                    $email = $row["email"];
                    $role = $row["role"];
              }
            else{
                echo "Неверный идентификатор.";
            }
        }
        else {
          echo "Что то пошло не так.";
        }
      
mysqli_stmt_close($stmt);
}
}
elseif(isset($_SESSION["nickname"]) && empty(trim($_GET["id"])))
{

                    $nickname =  $_SESSION["nickname"];
                    $email = $_SESSION["email"];
                    $role = $_SESSION["role"];

}


if (isset($_POST["submit1"]))
 {
    #retrieve file title
    $title = $_POST["filetitle"];
     
    #file name with a random number so that similar dont get replaced
    $pname = rand(1000,10000)."_".$_FILES["file"]["name"];
 
    #temporary file name to store file
    $tname = $_FILES["file"]["tmp_name"];
    #upload directory path
$uploads_dir = 'profileimg';
    #TO move the uploaded file to specific location
    move_uploaded_file($tname, './'.$uploads_dir.'/'.$pname);

    $sql = "SELECT * FROM profileimages where username = '".$_SESSION["nickname"]."'";
if($stmt =  mysqli_prepare($link, $sql)){
  if(mysqli_stmt_execute($stmt)){
    $result = mysqli_stmt_get_result($stmt);
  if(mysqli_num_rows($result) > 0){

    $sql1 = "UPDATE profileimages SET title = '$title',profileimg ='$pname' where username = '".$nickname."'";
    $sql2 = "UPDATE Clients SET profileimg='$pname' where nickname='".$nickname."'";
     if($stmt1 =  mysqli_prepare($link, $sql1)){
  if(mysqli_query($link,$sql1)){
    if($stmt2 =  mysqli_prepare($link, $sql2)){
      if(mysqli_query($link,$sql2)){
       unset($_FILES);
     }
     mysqli_stmt_close($stmt2);
     }    
    }
mysqli_stmt_close($stmt1);
}
}
else {
    $sql3 = "INSERT into profileimages(username,profileimg,title) VALUES('".$_SESSION["nickname"]."','$pname','$title')";
    $sql4 = "UPDATE Clients SET profileimg='$pname' where nickname='".$_SESSION["nickname"]."'";
 //UPDATE users SET avatarimg='1' 
         if($stmt1 =  mysqli_prepare($link, $sql3)){
  if(mysqli_query($link,$sql3)){
    if($stmt2 =  mysqli_prepare($link, $sql4)){
      if(mysqli_query($link,$sql4)){
       unset($_FILES);
     }
     mysqli_stmt_close($stmt2);
     }    
    }
mysqli_stmt_close($stmt1);
}
    else{
        echo "Error";
    }
  }
  header("location:profile.php");
    exit();
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
   <table class="table">
     <tr>
       <td colspan="3">
         <p>
    
    <?if($nickname == $_SESSION['nickname'])echo "Мой профиль"; else echo "Профиль:";?>

     

    <div class="alert alert-info">
      <?
      echo "Имя: <em style='color:#26ac1b;'>".$nickname."</em>\n";
      echo "Статус: <em style='color:#26ac1b;'>".$role."</em><br>\n";
   
 $sql = "SELECT c.nickname,c.email,c.role,b.amount,b.book_id, B1.book_name, b.date from 
 clients c, Buy_journal b, Books B1 where b.book_id = B1.id and c.id = b.client_id AND c.nickname=?";
        if($stmt1 = mysqli_prepare($link, $sql)){
            mysqli_stmt_bind_param($stmt1, "s", $param_name);
            $param_name = $nickname;
        if(mysqli_stmt_execute($stmt1)){
          $result = mysqli_stmt_get_result($stmt1);
         if(mysqli_num_rows($result) > 0){
          echo "<div class='panel  panel-heading' >Книги:</div>";
                    while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
                    echo "<div class='panel panel-footer'>".$row['book_name']."(Количество: ".$row['amount']."); Покупали в: ".$row['date']."</div>";
                                     }
              }
            else{
                echo "Ничего нет";
            }
        }
        else {
          echo "Что то пошло не так.";
        }
      
mysqli_stmt_close($stmt1);
}

      
      ?>

</div>
   </p>
       </td><td>
         <form action = "" id="profileform" style="display:none;
  background-color: #cee7f4;"class="form-popup" class="panel panel-default" method="post" enctype="multipart/form-data">
                                        <label>Title</label>
                                        <input type="text" name="filetitle">
                                        <label>File Upload</label>
                                        <input type="File" name="file">
                                        <button type="button" id="profilebtn" onclick='closeForm()'>Закрыть</button>
                                        <input type="submit" name="submit1">
                                              </form>
             <script type="text/javascript">
              function openForm() {
                    document.getElementById('profileform').style.display = "table";
                  }

              function closeForm() {
                    document.getElementById('profileform').style.display = "none";
                  }
            
            </script>
           
        <?
 $sql1 = "SELECT * FROM profileimages where username = '".$nickname."'";
                    if($result1 = mysqli_query($link, $sql1)){
                      if(mysqli_num_rows($result1) > 0) {
                          while($row = mysqli_fetch_array($result1, MYSQLI_ASSOC)){
                                    if($nickname == $_SESSION['nickname']){
                                      echo "<button type='button' id='profilebtn' onclick='openForm()'>Добавить фотографию</button>";
                                    }
                                    //<button type='button' id='profilebtn' onclick='openForm()'>Добавить фотографию</button>
                                         echo "
                                         <div class='panel panel-default'>
                                       <div>".$row['title']."</div>
                                       <img width='250px' class='thumbnail' style='margin: 7px 0 7px 7px;' src='profileimg/".$row['profileimg']."'>
                                       </div>";
                                       
                                     
                                   }
                                 }
                                 elseif(mysqli_num_rows($result1) < 1 && $nickname == $_SESSION['nickname']){
                                  echo '<button type="button" id="profilebtn" onclick="openForm()">Добавить фотографию</button>';
                                 }
                                

                            // Free result set
                            mysqli_free_result($result1);
                         
                    } 
?>


       </td>
        
        
     </tr>
     
   </table>
   

<br><br><br>
<br><br><br>
<br><br><br>
</div>
        
        <? include "footer.php";?>
<? mysqli_close($link); ?>

</body>
</html>

