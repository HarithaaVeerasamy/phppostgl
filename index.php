<?php 
   $host        = "host = 127.0.0.1";
   $port        = "port = 5432";
   $dbname      = "dbname = test";
   $credentials = "user = postgres password=harry@123";

   $db = pg_connect( "$host $port $dbname $credentials"  );
   if(!$db) {
      echo "Error : Unable to open database\n";
   } else {
       print_r($_POST);
       $name = $_POST['name'];
       //$age  = $_POST['age'];
       $email= $_POST['email'];
       $id   = $_POST['id'];
       if($id){
            $sql = "UPDATE login SET username = '$name',password = '$email' where id='$id'";
       }else{
       $sql = "INSERT INTO login (username,password)
               VALUES ( '$name','$email')";
       }
       $ret = pg_query($db, $sql);
        if(!$ret) {
           echo pg_last_error($db);
        } else {
           header('Location: form.php'); 
        }
        pg_close($db);
      
               

       
   }
   
?>
