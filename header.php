
<!-- <a class="btn" href="themes.php">Темы</a> -->

    <nav class="col-lg-12 navbar navbar-inverse">
  <div class="container-fluid">
    <div class="navbar">
      <a class="navbar-brand" href="#">Сайт для Библиотеки</a>
    </div>



<ul class="nav navbar-nav">
      <li><a class="btn" href="index.php"><img style="border-radius: 50%;" src="img/main.jpg" height="40px" weight="40px">Главная</a></li>
      <li><a class="btn" href="themes.php"><img src="img/themes.jpg" height="40px" weight="40px">Темы</a></li>
      <li><a class="btn" href="inform.php"><img src="img/info.jpg" height="40px" weight="40px">Информация</a></li>
      
      <?if($_SESSION['nickname']) {

 $sql1 = "SELECT * FROM profileimages where username = '".$_SESSION['nickname']."'";
                    if($result1 = mysqli_query($link, $sql1)){
                      if(mysqli_num_rows($result1) > 0) {
                          while($row = mysqli_fetch_array($result1, MYSQLI_ASSOC)){
                                    if($_SESSION['nickname']){
                                    }
                                         echo "<li><a class='btn' href='profile.php'><img height='40px' src='profileimg/".$row['profileimg']."'> Профиль<sup>(".$_SESSION['nickname'].")</sup></a></li>";    
                                       }
                                 }
                                 else {
                                  echo "<li><a class='btn' href='profile.php'> Профиль<sup>(".$_SESSION['nickname'].")</sup></a></li>";
                                 }
                            mysqli_free_result($result1);
                    } 
        }
        ?>
      <? if($_SESSION['role']=="admin"){echo "

      <li><a class='btn' href='admin.php'>Клиенты</a></li>";}?>
      <? if(!$_SESSION['nickname']){
        echo "
      <li><a class='btn' href='login.php'> <i class='glyphicon glyphicon-log-in'> Войти</i></a></li>
      <li><a class='btn' href='sign.php'><i class='glyphicon glyphicon-sign-up'> Регистрация</i></a></li>";}?>
      <? if($_SESSION['nickname']){
        echo "
      <li><a class='btn' href='login.php'><i class='glyphicon glyphicon-log-out'> Выйти</i></a></li>";}?>
    </ul>
<i class='glyphicon glyphicon-sign-in'>Регистрация</i>

  </div>
</nav>