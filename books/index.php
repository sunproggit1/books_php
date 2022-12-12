<?php
session_start();
require_once "config.php";
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

    <h4>
  <pre id="marqueeline">Сайт для работы библиотеки к вашим услугам.                           </pre>
    </h4> <br><h2>ДОБРО ПОЖАЛОВАТЬ!</h2> 

  </div>
<script type="text/javascript">
 function animate(id) {
  var node = document.getElementById(id).childNodes[0];
  var text = node.data;
  setInterval(function () {
   text = text.substring(1) + text[0];
   node.data = text;
  }, 125); //интервал прокрутки, мс
 }
 window.addEventListener('load', function (e) { animate('marqueeline'); }, false);
</script>
  <div class="col-lg-3">
    

  </div>
</div>
       <? include "footer.php";?>
<? mysqli_close($link);?>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/r123/three.min.js"></script>
        <script src="https://cdnjs.rawgit.com/mrdoob/three.js/master/examples/js/loaders/GLTFLoader.js"></script>
</body>
</html>