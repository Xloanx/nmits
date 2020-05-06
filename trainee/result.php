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
$test       =new test();
$examiner = new examiner1();
 
/////////////////////////////////////START VARIABLE DECLARATION//////////////////////////////////////////////////////////////////
$banner ="";
$next_action="";
$userid = "";
$current_moduleno ="";
////CHECK TO SEE IF THE SEARCH STRING FOR THE CALLING MODULE IS ATTACHED TO URL, IF IT IS INITIALIZE $current_moduleno and userid
if (isset($_SESSION['userid']) && isset($_SESSION['currentmodule'])){
  //$userid = $_GET["uid"];
  //$current_moduleno = $_GET["curr_mod"];
  $current_moduleno =  $_SESSION['currentmodule'];
  $userid = $_SESSION['userid'];
}
else die("We don't know the module that generated this test page");

///////////////////////////////////////////////CALL HEADER FOR TEST PAGE///////////////////////////////////////////////////////////
echo $interface->testheader($title='NMITS::Trainee Page');

///////////GET RESULT FOR DISPLAY /////////////////////////////
$resultDetails = $examiner->fetchResult($userid, $current_moduleno);
if ($resultDetails[2] == 'failed')
    {
      $banner ="<span style='color:red'>Sorry</span> ";
      $next_action= "Please close this page and study this module again before re-taking this test.";
      $rem = "<span style='color:red'>&#128078 You ".ucfirst($resultDetails[2])."!</span> ";
}
else if ($resultDetails[2] == 'passed')
    {
      $banner = "<span style='color:green'>Congratulations</span> ";
      $next_action= "Please close this page, log out from your current session and re-login to access the next module.";
      $rem = "<span style='color:green'>&#128077 You ".ucfirst($resultDetails[2])."!</span> ";
    }


/*echo "<div class='resultPageContent'>";
echo "<p>";
echo"<b>".$banner." ".ucfirst($_SESSION['surname']).",<br/> Your Test Evaluation is as Follows: <br/>";
echo "Score for Module".$current_moduleno." is: ".$resultDetails[0]."%<br />";
echo "Grade: ".$resultDetails[1]."<br />";
echo "Remark: ".$rem."<br />";
echo $next_action;
echo "</p>";
echo "</div>";
*/

echo "<div style='align-self: center; border: 1px solid blue ; border-radius: 0.5em; border-color: ;
    width:40%; height:300px; margin-left:20%; margin-top:4%; align-content: center;'>";
echo    "<div style='background-color: #f2f0f0; border-top-right-radius: 0.5em; border-top-left-radius: 0.5em; width:99.6%; height:30px; margin-left:0.2%; margin-right:0.2%; '>";
echo "<p style='font-family: constantia; font-size: 19px;'>"; 
  echo ucfirst($_SESSION['surname']); echo ", Your Test Evaluation for Module "; echo $current_moduleno; echo" is as Follows: </p>";
      
echo    "</div>";    

echo    "<div style='align-self: left; width:100%; height:200px; '>";     
echo "<p style='font-family: constantia; font-size: 15px;'> Score: "; echo $resultDetails[0]."%<br />";
echo "Remark: ".$rem."  </p>";
echo    "</div>";

echo    "<div style='background-color: #f2f0f0; border-bottom-right-radius: 0.5em; border-bottom-left-radius: 0.5em;  height:20px; width:99.6%; margin-left:0.2%; margin-right:0.2%; margin-bottom: 1px;'>";
echo "<p style='font-family: constantia; font-size: 13px;'>"; echo $next_action; echo "</p>";
echo    "</div>";

echo "</div>";






?>
