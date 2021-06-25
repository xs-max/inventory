<?php

ob_start();
  session_start();
unset($_SESSION['admin_is_logged']); 

session_destroy(); 

header("Location: ../login.php");//use for the redirection to some page  


?>