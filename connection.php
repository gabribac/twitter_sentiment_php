<?php
//connect to mysql
   $link = mysqli_connect("host", "username", "password", "db") or die("Error ".mysqli_error($link)); 
   if (mysqli_connect_errno()) {
  		echo mysqli_connect_error();
  		exit();
   }   
  ?>  
