<?php

if (!isset($_SESSION)) {
  session_start();

  if(@$_SESSION['STATUS'] == "")
    {
      header('Refresh: 2; URL = ../signin.php');
  }
}

//call required classes for interface and object creation

require_once('../classes/interface.php');
require_once('../classes/trainee.php');
require_once('../classes/module.php');
require_once('../classes/test.php');
require_once('../classes/examiner.php');
$interface  = new interface1();
$trainee    =new trainee();
$module     =new module();
$test       =new test();
$examiner = new examiner();

///////////////////////////////////////////////CALL HEADER FOR TEST PAGE///////////////////////////////////////////////////////////
echo $interface->testheader($title='NMITS::Trainee Page');


echo<<<regulations
<div id ='alert' class='alert'>
  <span class='closebtn' onclick="disagreeOnRegulation()">&times;</span>
  <strong>Sorry, your test page has expired!!! Close this page and Re-login to take the test again<br/></strong>

?>
