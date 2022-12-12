<?
 $sql1 = "SELECT * FROM janre ORDER BY janre_curr_books DESC LIMIT 10";
                    if($result1 = mysqli_query($link, $sql1)){
                        if(mysqli_num_rows($result1) > 0){
                            echo "<ul class='nav'><li >Темы:</li>";
                                    
                                while($row = mysqli_fetch_array($result1)){

                                        
                                    
                                        echo "<form action='comment.php' method='post'>
                                       <input type='text' hidden name='theme_id' value='".$row['id']."'>
                                       <input type='text' hidden name='janre_name' value='".$row['janre_name']."'>
                                       <textarea hidden name='janre_curr_books'>".$row['janre_curr_books']."</textarea>
                                       <input columns=30 type='submit' class='form-control' value='".$row['janre_name']; 
                                       if($row['janre_curr_books']!=NULL){echo "(".$row['janre_curr_books'].")";}
                                       echo "'>
                                       </form>";

                                    
                                }
                                echo "</ul>";

                            // Free result set
                            mysqli_free_result($result1);
                        } 
                    }
    ?>