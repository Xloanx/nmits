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
echo<<<content
<!--  <div id='contentdiv' class='contentdiv'>   -->
  <div id="$modulenum" style="font-family:Bellmt, Arial;font-size:12pt;color:black" class="contentclass">
      <h5><b>MODULE CATEGORY: $module_details[4]</b></h5>             <hr/ width=20%>
      <!--Module No: Topic-->
      <h5><b>MODULE NUMBER $i: $module_details[0]</b></h5>            <hr/ width=20%>
      <h5><b>MODULE PREREQUISITE</b> </h5>
      $module_details[2]                                              <hr/ width=20%>
      <h5><b>MODULE OBJECTIVE</b></h5>
      $module_details[1]                                              <hr/ width=20%>
      <h5><b>NUMBER OF HOURS REQUIRED: $module_details[3]hrs</b></h5>
      <embed src="../module-content/$i.pdf" width="100%" height="1000" />
  <!--    <a href="javascript:window.open('testing.php?mod=$i',null,'left=150,top=20,height=600, width=800,scrollbars=yes,status= Yes, resizable= Yes, scrollbars=Yes, toolbar=no,location=no,menubar=yes')"> -->
      <a href='testing.php?curr_mod=$i' target=_blank>
        <button type="submit" class="w3-btn w3-xlarge w3-dark-grey w3-hover-light-grey" style="font-weight:900;">Take Test</button>
      </a>
      <br/><br/><br/><br/><br/>
  </div>
content;
}
echo "</div>";


/*
$file = 'dummy.pdf';
$filename = 'dummy.pdf';
header('Content-type: application/pdf');
header('Content-Disposition: inline; filename="' . $filename . '"');
header('Content-Transfer-Encoding: binary');
header('Content-Length: ' . filesize($file));
header('Accept-Ranges: bytes');
@readfile($file);

*/


?>
