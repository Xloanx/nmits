<?php


if (!isset($_SESSION)) {
  session_start();
  if(@$_SESSION['STATUS'] == "" || @$_SESSION['role'] !='trainer' )  //if you are not signed in OR you are not a trainer then this page refreshes to signup
    {
      header('Refresh: 0; URL = ../signin.php');
  }
}






?>