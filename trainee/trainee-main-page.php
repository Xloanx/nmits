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
$interface  = new interface1();
$trainee    =new trainee();
$module     =new module();
$max_moduleno = @$_SESSION['maxmodule'];

echo $interface->TraineeSideNav($title='NMITS::Trainee Page', $max_moduleno );
echo "<h4 class='pageInfoSuccess'>Welcome ".ucfirst($_SESSION['surname'])."</h4>";
echo "<div id='contentdiv' class='contentdiv'>";

for ($i=1; $i<=$max_moduleno; $i++){
  $_SESSION['currentmodule'] = $i;
  $module_details = $module->getModuleDetails($i);
  $modulenum = "module".$i;
  //$l = "'".$i."'";
  $content = "<p style='width:100%; font-family:constantia'><embed src='../module-content/".$i.".txt'";
  $content = "../module-content/".$i.".txt";
  $fc = file_get_contents($content);
  $res =  "<a href='../module-content/".$i.".pdf' target=_blank>";



echo  "<div id='"; echo $modulenum; echo"' style='font-family:constantia;font-size:15pt;color:black' class='contentclass'>";

echo    "<table style='border:2px solid #73AD21; border-radius: 10px; width: 100%'>";
echo          "<tr style='border-bottom: 1px solid #cbcbcb;'>";
echo            "<td style='border: none; height: 30px; padding: 2px;'><strong>Module Category:</strong><br/>"; echo ucfirst($module_details[4]); echo "</td>";
echo            "<td><strong>Module Number:</strong><br/>"; echo $i; echo"</td>";
echo            "<td><strong>Module Prerequisite</strong><br/>"; echo $module_details[2]; echo"</td>";
echo            "<td><strong>Estimated Time Required (in hrs)</strong><br/>";  echo $module_details[3]; echo"</td>";
echo          "</tr>";
echo          "<tr>";
echo            "<td colspan='4'><strong>Module Topic:</strong>";  echo $module_details[0]; echo "</td>";
echo          "</tr>";
echo          "<tr>";
echo            "<td colspan='4'><strong>Module Objective(s):</strong><br/>";  echo nl2br($module_details[1]); echo "</td>";
echo          "</tr>";
echo          "<tr>";
echo            "<td colspan='4'><strong>Additional Resource: </strong>";  echo $res; echo "click here </a></td>";
echo          "</tr>";
echo     "</table>";
//echo    "<table style='border:2px solid #73AD21; border-radius: 10px; width: 100%'><tr><td>";
echo     "<div style='float:left; width:100%;'>"; //the div for content + interactive window
echo        "<div style='width:100%; font-family:constantia'";  //the div for content
//echo            $content; echo "style='width:100%; font-family:constantia '/></p>";
echo         "<p style='text-align:justify; text-justify: inter-word;'>"; echo nl2br($fc); echo "</p>";
echo        "</div>"; //the closing div for content
//    <!--    <a href="javascript:window.open('testing.php?mod=$i',null,'left=150,top=20,height=600, width=800,scrollbars=yes,status= Yes, resizable= Yes, scrollbars=Yes, toolbar=no,location=no,menubar=yes')"> -->
echo        "<div style='width:100%;'>";  //the div for interactive window
echo        "</div>";//the closing div for interactive window
//echo          "<a href=testing.php?curr_mod="; echo $i; echo " target=_blank>";
echo          "<button type='submit' onclick='showRegulation()' class='w3-btn w3-large w3-round-xxlarge w3-dark-grey w3-hover-light-grey' style='font-weight:900;'>View Test Rules</button>";




echo     "<div id ='alertclass' style='padding: 20px;background-color: #f44336; font-family:constantia;color: white;font-size:12pt;display:none'class='alertclass'>";
//echo     "<div id ='alertclass' class='alertclass'>";
echo     "<span class='closebtn' onclick='disagreeOnRegulation()'>&times;</span>";
echo     "<strong>Before you commence the test, here are some regulations as regards the test:<br/></strong>";
echo     "1. You will be exposed to "; /*echo $test->number_of_questions;*/ echo " questions in this module's test.<br/>";
echo     "2. The timing is displayed at the top right corner of the test page.<br/>";
echo     "3. If you do not submit before time elapses,you will have to restart the test all over again.<br/>";
echo     "4. Click the submit button to submit your test when you are through with your test<br/>";
echo     "You MUST agree to these conditions by clicking the CONTINUE TO TEST button below to begin the test.<br/>";
echo     "Best of luck!!!<br/><br/>";
echo     "<button type='submit'  onclick='disagreeOnRegulation()' class='w3-btn w3-large w3-round-xxlarge w3-dark-grey w3-hover-light-grey' style='font-weight:900;'> Back to Study</button> </a>";
echo     "<a href='testing.php' target=_blank><button type='submit'  onclick='startTest()' class='w3-btn w3-large w3-round-xxlarge w3-dark-grey w3-hover-light-grey w3-right' style='font-weight:900;'>Continue to Test >>></button> </a>";
echo     "</div>";



echo        "</div>";  //closing tag for modulenum
echo     "<br/><br/><br/><br/><br/>";
echo     "</div>";  //closing div tag for contentdiv

 } ?>





<!--Start of Tawk.to Script-->
<script type="text/javascript">
var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
(function(){
var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
s1.async=true;
s1.src='https://embed.tawk.to/5dd9601ed96992700fc8e7bb/default';
s1.charset='UTF-8';
s1.setAttribute('crossorigin','*');
s0.parentNode.insertBefore(s1,s0);
})();
</script>
<!--End of Tawk.to Script-->
</body></html>