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
$examiner = new examiner1();



/////////////////////////////////////START VARIABLE DECLARATION//////////////////////////////////////////////////////////////////
$max_moduleno = @$_SESSION['maxmodule'];            //the maximum module number that this session holder can access
$test_number ="";
$transact="";
$radio_name = ['r1','r2','r3','r4','r5','r6','r7','r8','r9','r10'];
$test_name = ['t1','t2','t3','t4','t5','t6','t7','t8','t9','t10'];
$ansName =['a1','a2','a3','a4','a5','a6','a7','a8','a9','a10'];
$all_tests_details = array();
$all_tests_ans = array();
$selected = array();
$score = array();


$current_moduleno = $_SESSION['currentmodule'];

///////////////////////////////////////////////CALL HEADER FOR TEST PAGE///////////////////////////////////////////////////////////
echo $interface->testheader($title='NMITS::Trainee Page');

//////////GET THE MAXIMUM NUMBER OF QUESTIONS IN DB FOR THE SPECIFIED MODULE NUMBER
$test->max_number_of_available_questions = $test->getAvailableTestCount($current_moduleno);
for ($i=1; $i<=$test->max_number_of_available_questions; $i++){
  array_push($test->test_number_array,$i); //creates an array that contains the test numbers: e.g: 1,2,3,4,...,max
}
shuffle($test->test_number_array); //shuffle array so that numerically arranged array randomizes to e.g: 5,3,max,6,max-3,...

$test->period_of_test;
echo "<div id='allTestPageContent'>";
echo"<b>Hello ".ucfirst($_SESSION['surname']).", welcome to NMITS Testing Platform.</b><br/>";

//implement when submission is done
if(isset($_POST['submittest']))
    {/*
      for ($i=0; $i<$test->number_of_questions; $i++){
      echo 'Test Number: '; echo $_POST['t1']; echo '*** Answer:'; echo $_POST['a1']; echo '*** Selected:'; echo $_POST['r1']; echo '<br />';
      echo 'Test Number: '; echo $_POST['t2']; echo '*** Answer:'; echo $_POST['a2']; echo '*** Selected:'; echo $_POST['r2']; echo '<br />';
      echo 'Test Number: '; echo $_POST['t3']; echo '*** Answer:'; echo $_POST['a3']; echo '*** Selected:'; echo $_POST['r3']; echo '<br />';
      echo 'Test Number: '; echo $_POST['t4']; echo '*** Answer:'; echo $_POST['a4']; echo '*** Selected:'; echo $_POST['r4']; echo '<br />';
      echo 'Test Number: '; echo $_POST['t5']; echo '*** Answer:'; echo $_POST['a5']; echo '*** Selected:'; echo $_POST['r5']; echo '<br />';
      echo 'Test Number: '; echo $_POST['t6']; echo '*** Answer:'; echo $_POST['a6']; echo '*** Selected:'; echo $_POST['r6']; echo '<br />';
      echo 'Test Number: '; echo $_POST['t7']; echo '*** Answer:'; echo $_POST['a7']; echo '*** Selected:'; echo $_POST['r7']; echo '<br />';
      echo 'Test Number: '; echo $_POST['t8']; echo '*** Answer:'; echo $_POST['a8']; echo '*** Selected:'; echo $_POST['r8']; echo '<br />';
      echo 'Test Number: '; echo $_POST['t9']; echo '*** Answer:'; echo $_POST['a9']; echo '*** Selected:'; echo $_POST['r9']; echo '<br />';
      echo 'Test Number: '; echo $_POST['t10']; echo '*** Answer:'; echo $_POST['a10']; echo '*** Selected:'; echo $_POST['r10']; echo '<br />';*/
  $examiner->scoreAndGrade($_POST['r1'],$_POST['r2'],$_POST['r3'],$_POST['r4'],$_POST['r5'],$_POST['r6'],$_POST['r7'],$_POST['r8'],$_POST['r9'],$_POST['r10'],$_POST['t1'], $_POST['t2'],$_POST['t3'],$_POST['t4'],$_POST['t5'],$_POST['t6'],$_POST['t7'],$_POST['t8'],$_POST['t9'],$_POST['t10'],$_POST['a1'],$_POST['a2'],$_POST['a3'],$_POST['a4'],$_POST['a5'],$_POST['a6'],$_POST['a7'],$_POST['a8'],$_POST['a9'],$_POST['a10'],$_POST['curr_module'],$test->number_of_questions,$_SESSION['userid']);
}

?>

<!---echo<<<_content-->
<div id="testclas" class="testclas">
 <!--<p><h3 class='w3-right'><b>TIME LEFT:  $test->period_of_test</b></h3></p><br/>--->
 <p ><h3 class='w3-right w3-medium'><b>TIME LEFT: <span id="countdown"></span> </b></h3></p><br/>
 <?php echo $transact; ?>
<!---content;
?>  --->


<?php
echo "<form action ="; echo htmlspecialchars($_SERVER['PHP_SELF']); echo" method = 'post'>";

for ($i=0; $i<$test->number_of_questions; $i++){
  $test_number = $test->test_number_array[$i];  // we're fetching the test details of the question that has the corresponding number in this array
  $test_details = $test->getTestDetails($current_moduleno, $test_number);
  $displayed_test_number = $i + 1;      //THis value is just displayed on the interface to show question number


echo      "<table style='border:2px solid #73AD21; border-radius: 5px; width: 55%'>";
echo      "<tr>";  
echo      "<td>";          
echo      "<strong>QUESTION "; echo $displayed_test_number ; echo"</strong>";            
echo      "</td>";  
echo      "</tr>";
echo      "<tr>";
echo      "<td style='font-size:20px'>";
echo      ucfirst($test_details[1]);
echo      "</td>";
echo      "</tr>";
echo      "<tr>";  
echo      "<td>";  
echo      "<label class='container'>"; echo $test_details[2]; echo "<input type='radio' name='"; echo $radio_name[$i]; echo"' class='w3-left' value='a' ><span class='checkmark'></span></label>";     
echo      "</td>";
echo      "</tr>";
echo      "<tr>";  
echo      "<td>";  
echo      "<label class='container'>"; echo $test_details[3]; echo "<input type='radio' name='"; echo $radio_name[$i]; echo"' class='w3-left' value='b' ><span class='checkmark'></span></label>";     
echo      "</td>";
echo      "</tr>";
echo      "<tr>";  
echo      "<td>";  
echo      "<label class='container'>"; echo $test_details[4]; echo "<input type='radio' name='"; echo $radio_name[$i]; echo"' class='w3-left' value='c' ><span class='checkmark'></span></label>";     
echo      "</td>";
echo      "</tr>";
echo      "<tr>";  
echo      "<td>";  
echo      "<label class='container'>"; echo $test_details[5]; echo "<input type='radio' name='"; echo $radio_name[$i]; echo"' class='w3-left' value='d' ><span class='checkmark'></span></label>";     
echo      "</td>";
echo      "</tr>";
echo      "<tr>";  
echo      "<td>";  
echo      "<label class='container'>"; echo $test_details[6]; echo "<input type='radio' name='"; echo $radio_name[$i]; echo"' class='w3-left' value='e' ><span class='checkmark'></span></label>";     
echo      "</td>";
echo      "</tr>";
echo "<p><input type='Hidden' id='testnumber' name='"; echo $test_name[$i]; echo "' value='"; echo $test_number; echo "'/></p>";
echo "<p><input type='Hidden' id='ans' name='"; echo $ansName[$i]; echo"' value='"; echo $test_details[7]; echo"'/></p>";              
echo"<p><input type='Hidden' id='curr_module' name='curr_module' value='"; echo $current_moduleno; echo"'/></p>";              
echo      "</table>";
}

echo      "<button type='submit' id='submittest' name='submittest' class='w3-btn ww3-large w3-round-xxlarge w3-dark-grey w3-hover-light-grey w3-left' style='font-weight:900;'>SUBMIT</button>";

echo      "</form>";
echo      "</div>";

?>



