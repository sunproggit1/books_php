 <footer class="col-lg-12 navbar-inverse fixed-bottom">
           <div class="sim-slider">
<p style="color:#FFFFFF; text-align: center; margin: 20px 20px 0 0;">Фото тем для книг: </p><br>
     <ul class="sim-slider-list">
         <li><img height='250px' width='350px' src="img/beautyimg4.jpg" alt="screen"></li>  
         <? 
         $sql= "SELECT id,janre_name,themeimg FROM janre order by id desc";
                    if($result = mysqli_query($link, $sql)){
                        if(mysqli_num_rows($result) > 0){
                                    $counter=0;
                                while($row = mysqli_fetch_array($result)){
                                   
                                    
                                      $counter++;
                                      if($row['themeimg']!=NULL){
                                       echo "<li class='sim-slider-element'>
                                       <img height='250px' width='350px' src='themeimg/".$row['themeimg']."' alt='".$counter."'>

                                       </li>"; }
                                       else { }
                                      
                                }
                                echo "</ul>";

                            // Free result set
                            mysqli_free_result($result);
                        } 
                    }
         ?>
     </ul>
     <div class="sim-slider-arrow-left"></div>
     <div class="sim-slider-arrow-right"></div>
     <div class="sim-slider-dots"></div>
 </div>

<script type="text/javascript">new Sim();</script>
               <hr>
                <p class="pull-left" style="color: white;">АУЭС © 2020</p>
                <p class="pull-right" style="color: white;">Наши контакты: +77473812507</p>
               
        
        </footer>