<?php
session_start();

$connect = new PDO('mysql:host=127.0.0.1;dbname=book_shop', 'root', '');
$theme_id = $_SESSION['theme_id'];
$search_b_name = "";

$search_b_name = $_COOKIE['search_b_name'];

$query = "SELECT b.id, b.book_name, b.book_janre_id, b.book_copies_sold, b.book_current_copies, j.id, j.janre_name, j.janre_curr_books 
FROM books b, Janre j WHERE b.book_janre_id = '$theme_id' AND j.id = b.book_janre_id AND b.book_name like '".$search_b_name."%' ORDER BY b.book_current_copies DESC";

$statement = $connect->prepare($query);

$statement->execute();

$result = $statement->fetchAll();
$output = '';
foreach($result as $row)
{

 $output .= '
 <div class="panel panel-default">
  <div class="panel-heading">Тема: <i>'.$row["janre_name"].'('.$row["janre_curr_books"].')</i></div>
  <div class="panel-body">'.($row["book_name"]).'.';
   if(!is_null($row["book_current_copies"])) {$output .= 'Кол-во экземпляров: '. $row["book_current_copies"]."; ";}
   	if(!is_null($row["book_copies_sold"])){$output .= 'Экземпляров продано: '. $row["book_copies_sold"]."; ";}
   	 $output .= '</div>
  <div class="panel-footer" align="right">'; 

  if($_SESSION['role']=='admin'){

    $output .='<a href="update.php?id='.$row["0"].'" class="pull-right glyphicon glyphicon-pencil"></a>';
    $output .='<a href="buy_book.php?id='.$row["0"].'" class="btn btn-default" ">Продажа</a>';}
  if($_SESSION['role']=='user'){

    $output .='<a href="buy_request.php?id='.$row["0"].'" class="btn btn-default" ">Продажа</a>';}
    $output .='
    </div>
 </div>
 ';
 
}



echo $output;


?>
