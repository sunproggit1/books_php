<?php
session_start();
require_once "config.php";
$janre_name = $nickname = $janre_curr_books = "";
//print_r($_SESSION);

if(isset($_GET['janre_name'])){ 
$janre_name = $_GET['janre_name'];
unset($_SESSION['janre_name']);
$_SESSION['janre_name'] = $_GET['janre_name'];

unset($_SESSION['janre_curr_books']);
$_SESSION['janre_curr_books'] = $_GET['janre_curr_books'];

unset($_SESSION['theme_id']);
$_SESSION['theme_id'] = $_GET['theme_id'];
}

$janre_name = $_SESSION['janre_name'];
$nickname = $_SESSION['nickname'];
$janre_curr_books = $_SESSION['janre_curr_books'];

print_r($_SESSION);


if (isset($_POST["submit1"]))
 {
    #retrieve file title
    $title = $_POST["filetitle"];
     
    #file name with a random number so that similar dont get replaced
    $pname = rand(1000,10000)."_".$_FILES["file"]["name"];
 
    #temporary file name to store file
    $tname = $_FILES["file"]["tmp_name"];
    #upload directory path
$uploads_dir = 'themeimg';
    #TO move the uploaded file to specific location
    move_uploaded_file($tname, './'.$uploads_dir.'/'.$pname);

    $sql = "SELECT * FROM themeimages where janre_name = '".$_SESSION["janre_name"]."'";
if($stmt =  mysqli_prepare($link, $sql)){
  if(mysqli_stmt_execute($stmt)){
    $result = mysqli_stmt_get_result($stmt);
  if(mysqli_num_rows($result) > 0){

    $sql1 = "UPDATE themeimages SET title = '$title',themeimg ='$pname' where janre_name = '".$janre_name."'";
    $sql2 = "UPDATE Janre SET themeimg='$pname' where janre_name='".$janre_name."'";
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
    $sql3 = "INSERT into themeimages(janre_name,title,themeimg) VALUES('".$_SESSION["janre_name"]."','$title','$pname')";
    $sql4 = "UPDATE Janre SET themeimg='$pname' where janre_name='".$_SESSION["janre_name"]."'";
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
  header("location:themes.php");
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
  <div class="col-lg-3 col-md-offset alert alert-info">
    
    <?
    include 'side_popular_themes.php';
    ?>
  </div>
  <div class="col-lg-6">
      <blockquote><q>Тема: <? echo $janre_name;?></q>
        <?
          $sql1 = "SELECT * FROM themeimages where janre_name = '".$janre_name."'";
          if($result1 = mysqli_query($link, $sql1)){
            if(mysqli_num_rows($result1) > 0) {
              while($row = mysqli_fetch_array($result1, MYSQLI_ASSOC)){
              
              //<button type='button' id='profilebtn' onclick='openForm()'>Добавить фотографию</button>
              echo "
              <div class='panel panel-default'>
              <img width='250px' class='thumbnail' style='margin: 7px 0 7px 7px;' src='themeimg/".$row['themeimg']."'>
              </div>";
            }
          }
        mysqli_free_result($result1);
      } 
    ?>
    </blockquote>
    <br>
    <div >
                    <?
   if($_SESSION['role'] =='admin') echo '
   <form method="POST" id="book_form" enctype="multipart/form-data">
    <div class="form-group">
     <input type="text" name="book_name" id="book_name" placeholder="Ввести имя Книги"/>  
     <input type="text" hidden name="theme_id" id="theme_id" value="'.$_SESSION['theme_id'].'">
    </div>
    <div class="form-group">
     <input type="submit" name="submit" id="submit" class="btn btn-info" value="Добавить книгу" />
    </div>
   </form>';

?>
</div><div>
   <span id="book_message"></span>
   <br />
  <form  method="POST" id="search" enctype="multipart/form-data" >
  <div>Search for book name:</div>
  <input type="text" name="bname_search" id="bname_search">
  <input type="submit" name="submitsearch" class="btn btn-info" id="submitsearch" value="Поиск">
</form>
   <div id="display_book"></div>
  </div>
  
<br><br><br>


<script>

$(document).ready(function(){
 
 $('#book_form').on('submit', function(event){
  event.preventDefault();
  var form_data = $(this).serialize();
  $.ajax({
   url:"create.php",
   method:"POST",
   data:form_data,
   dataType:"JSON",
   success:function(data)
   {
    if(data.error != '')
    {
     $('#book_form')[0].reset();
     $('#book_message').html(data.error);
     
     load_comment();
    }
   }
  })
 });

  $('#search').on('bname_search', function (event){
  event.preventDefault();
  var form_data = $(this).serialize();
  $.ajax({
   url:"fetch_comment.php",
   method:"POST",
   data:form_data,
   dataType:"JSON",
   success:function(data)
   {
    $('#display_book').html("");
    $('#display_book').html(data);
   }
  })
 });
load_comment();
 function load_comment()
 {

  $.ajax({
   url:"fetch_comment.php",
   method:"POST",
   success:function(data)
   {
    $('#display_book').html("");
    $('#display_book').html(data);
   }
  })
 }
let timer = setInterval(load_comment,10000);
});
</script>

  </div>
  <div class="col-lg-3 col-md-offset">
   Добавить фотографию
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
                    document.getElementById('profileform').style.display = "block";
                  }

              function closeForm() {
                    document.getElementById('profileform').style.display = "none";
                  }
            
            </script>
           
        <?
 $sql1 = "SELECT * FROM themeimages where janre_name = '".$janre_name."'";
    if($result1 = mysqli_query($link, $sql1)){
      if(mysqli_num_rows($result1) > 0) {
        while($row = mysqli_fetch_array($result1, MYSQLI_ASSOC)){
          if($janre_name == $_SESSION['janre_name']){
            echo "<button type='button' id='profilebtn' onclick='openForm()'>Добавить фотографию</button>";
          }
          //<button type='button' id='profilebtn' onclick='openForm()'>Добавить фотографию</button>
          echo "
            <div class='panel panel-default'>
            <img width='50px' class='thumbnail' style='margin: 7px 0 7px 7px;' src='themeimg/".$row['themeimg']."'>
            </div>";
          }
        }
        elseif(mysqli_num_rows($result1) < 1 && $janre_name == $_SESSION['janre_name']){
          echo '<button type="button" id="profilebtn" onclick="openForm()">Добавить фотографию</button>';
        }
      mysqli_free_result($result1);
    } 
?>


<br><br>
  </div>
</div>
        
        <? include "footer.php";?>
        <? mysqli_close($link); ?>
</body>
</html>