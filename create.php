<?php
session_start();
//require_once "config.php";


$connect = new PDO('mysql:host=127.0.0.1;dbname=book_shop', 'root', '');
/*
$comment = "";
//print_r($_SESSION);
$count = 0;

$theme = $_SESSION['theme'];
$name = $_SESSION['name'];
if(isset($_POST['comment']) && !empty($_POST['comment'])){

$comment = trim($_POST["comment"]);

$theme = trim($_POST["theme"]);
$name = trim($_POST["name"]);

       $sql = "INSERT INTO comments(theme, username, comment) VALUES (?, ?, ?)";
        if($stmt = mysqli_prepare($link, $sql)){
            mysqli_stmt_bind_param($stmt, "sss", $param_theme, $param_name, $param_comm);
            
            $param_theme = $theme;
            $param_name = $name;
            $param_comm = $comment;

            if(mysqli_stmt_execute($stmt)){
             $sql1 = "UPDATE quests set comcount = (SELECT COUNT(*) as count from comments where theme=?) where theme=?";
        if($stmt1 = mysqli_prepare($link, $sql1)){
            mysqli_stmt_bind_param($stmt1, "ss", $param1_theme, $param2_theme);
            $param1_theme = $theme;
            $param2_theme = $theme;
            if(mysqli_stmt_execute($stmt1)){
            } else{
                echo "Ошибка.";
            }
        mysqli_stmt_close($stmt1);}
                header("location: comment.php");
                exit();
            } else{
                echo "Ошибка.";
            }
        mysqli_stmt_close($stmt);}
        
} */

$error = '';
$book_name = '';
$theme_id = '';

if(empty($_POST["book_name"]))
{
 $error .= '<p class="text-danger">Name is required</p>';
}
else
{
 $book_name = $_POST["book_name"];
}

if(empty($_POST["theme_id"]))
{
 $error .= '<p class="text-danger">Theme is required</p>';
}
else
{
 $theme_id = $_POST["theme_id"];
}


if($error == '')
{


 $query = "
 INSERT INTO books 
 (book_name, book_janre_id) 
 VALUES (:book_name, :theme_id)";

 /* $query2 = "
 UPDATE  comments  SET parent_id=(:parent_id), theme=(:theme), username=(:username), comment=(:comment)";*/
 
 $statement = $connect->prepare($query);
 $statement->execute(
  array(
   ':book_name' => $book_name,
   ':theme_id'    => $theme_id
  )
 );
    $query1="UPDATE Janre set janre_curr_books = (SELECT COUNT(*) as count from books where book_janre_id='$theme_id') where id='$theme_id'";

$statement = $connect->prepare($query1);

$statement->execute();
 
 $error = '<label class="text-success">Book Added</label>';
}

$data = array(
 'error'  => $error
);

echo json_encode($data);





?>
