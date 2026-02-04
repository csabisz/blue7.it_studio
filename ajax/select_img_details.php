<?php  
 $connect = mysqli_connect("localhost", "admin_domenia1", "iernut2016", "admin_domenia1");  
 $output = '';  
 $sql = "SELECT * FROM o_results";

 $result = mysqli_query($connect, $sql);  
 
 if(mysqli_num_rows($result)>0)
 {
     while($row=mysqli_fetch_array($result))
     {
        $output .=' 

        <div class="col-md-2 border-right border-dark px-0 py-1">
            <input   class="form-control" type="text" value="sdsdsd">    
        </div>     
        ';
     }
 }
 else{
     echo "<p class='text-ceneter'>asdasdasd</p>";
 }

 $output .='
 </div>
 ';
 echo $output;