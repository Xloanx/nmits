<?php
   session_start();
    // remove all session variables
   session_unset();
   // destroy the session
   session_destroy();
   ///echo 'You have logged out. Click <a href"signin.php" style="text-decoration:none">here</a> to sign in.';
   header('Refresh: 2; URL = signin.php');
?>
