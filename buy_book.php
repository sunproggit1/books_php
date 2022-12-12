<?php
session_start();
require_once "config.php";
$client_id = $id = $book_name = $amount = "";
$client_id_err = $amount_err = "";
if($_SERVER["REQUEST_METHOD"] == "POST"){

    $input_b_id = (trim($_POST["b_id"]));
    if(empty($b_id)){
    }else {
        $b_id = $input_b_id;
    }
    
    $input_client_id = trim($_POST["client_id"]);
    if(empty($input_client_id)){
        $client_id_err = "Введите id:";
    } else{
        $client_id = $input_client_id;
    }
    
    $input_amount = ($_POST["amount"]);
    if(empty($input_amount)){
        $amount_err = "Введите Количество:";
    } else{
        $amount = $input_amount;
    }


    if(empty($amount_err) && empty($client_id_err)){

/*
$connect = new PDO('mysql:host=127.0.0.1;dbname=book_shop', 'root', '');
$query1 = "INSERT INTO Buy_journal(client_id,book_id,amount) VALUES(:c_id,:b_id,:amount)";
 $statement = $connect->prepare($query1);
 if($statement->execute(
  array(
   ':c_id' => $client_id, 
   ':b_id' => $b_id,
   ':amount' => $amount
  )
 )){

 $query2 = "UPDATE Books set book_copies_sold=book_copies_sold+:amount,
book_current_copies=book_current_copies-:amount where id=:id";

 $statement1 = $connect->prepare($query2);
 $statement1->execute(
  array(
   ':id' => $b_id,
   ':amount'    => $amount
  )
 );

 header('location: index.php');
    exit();}
    */
        
$sql1 = "INSERT INTO Buy_journal values(NULL,?,?,?,CURRENT_TIMESTAMP) ; UPDATE books set book_copies_sold=book_copies_sold+'$amount',
book_current_copies=book_current_copies-'$amount' where id=?";
if($stmt1 = mysqli_prepare($link, $sql1)){
    mysqli_stmt_bind_param($stmt1, "iiii", $param_client_id,$param_b_id,$param_amount,$param_b_id2);
            
            $param_client_id = $client_id;
            $param_b_id = $b_id;
            $param_amount = $amount;
            $param_b_id2 = $b_id;
            
            if(mysqli_stmt_execute($stmt1)){
                /*$sql2 = "UPDATE books set book_copies_sold=book_copies_sold+'$amount',
book_current_copies=book_current_copies-'$amount' where id=?";
if($stmt2 = mysqli_prepare($link, $sql2)){
                    mysqli_stmt_bind_param($stmt2, "i", $param_b_id);

                    $param_b_id = $b_id;
                    if(mysqli_stmt_execute($stmt2)){
                        header('location: comment.php');
                        exit();
                        echo "Success2";
                    } else{
                        echo "Ошибка2.";
                    }
                    
            mysqli_stmt_close($stmt2);
            }*/
            //header('location: comment.php');
            exit();
            }
            else{
                echo "Ошибка. Неверный ввод1";
            }
        
        mysqli_stmt_close($stmt1);
        }


}
}
else if($_SERVER["REQUEST_METHOD"] == "GET"){
    if(isset($_GET['id'])){
    $id = intval($_GET["id"]);

$sql = "SELECT * FROM Books WHERE id=?";
if($stmt = mysqli_prepare($link, $sql)){
    mysqli_stmt_bind_param($stmt, "i", $param_id);
            $param_id = $id;
            if(mysqli_stmt_execute($stmt)){
               $result = mysqli_stmt_get_result($stmt);
                if(mysqli_num_rows($result)==1){
                    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
                    $id = $row["id"];
                    $book_name = $row["book_name"];
                    $book_current_copies = $row["book_current_copies"];
                    $book_copies_sold = $row["book_copies_sold"];
                     
            } else{
                echo "Ошибка.";
            }
        }
        else{
                echo "Ошибка идентификатора.";
            }
        
        mysqli_stmt_close($stmt);
    }


}
}
print_r($_GET);
print_r($_POST);
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



<br><br><br>
Продажа книги: 
<?
echo "<h4>Название: ".$book_name."; ";
                    if(isset($book_current_copies))echo "Количество: ".$book_current_copies."; ";
                    if(isset($book_copies_sold))echo "Уже продано: ".$book_copies_sold."; ";
                    echo "</h4>";

?>
<br>
Запишите псевдоним покупателя, и количество покупаемых экземпляров данной книги:
<form method="POST">
<input type="hidden"  name="b_id" value="<? if($_GET['id']) echo intval($_GET['id']);?>"><hr>
<?

$connect = new PDO('mysql:host=127.0.0.1;dbname=book_shop', 'root', '');
$query = "SELECT * from Clients";

$statement = $connect->prepare($query);

$statement->execute();

$result = $statement->fetchAll();

echo '<select name="client_id" placeholder="Псевдоним">';
foreach($result as $row)
{
   echo '<option value="'.$row['id'].'">'.$row['surname'].' '.$row['name'].'</option>';
}

echo '</select>';
 
?>
<input type="text" placeholder="Количество" name="amount" class="form-control"><hr>
<input type="submit" name="submit" value="Зарегистрировать покупку">
</form>

<br><br><br>
<br><br><br>

  </div>
  <div class="col-lg-3">
    

  </div>
</div>
        
        <? include "footer.php";?>
<?mysqli_close($link);?>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/r123/three.min.js"></script>

        <script src="https://cdnjs.rawgit.com/mrdoob/three.js/master/examples/js/loaders/GLTFLoader.js"></script>
</body>
</html>