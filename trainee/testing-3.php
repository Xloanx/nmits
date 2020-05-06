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

//implement when submission is done
if(isset($_POST['submittest'])){
  for ($i=0; $i<$test->number_of_questions; $i++){
  echo($_POST['allans'][$i]);
  echo" <br />";
}
/*  for ($m=0; $m<$test->number_of_questions; $m++){
     array_push($selected, $_POST[$all_tests_details[$m][8]]);
  }
  print_r($selected);
  echo" <br />";
  print_r($all_tests_ans);
*/
/*
  //if the value selected equals the value that owns this key  
    if($_POST[$all_tests_details[m][8]] == val($all_tests_ans[$all_tests_details[$m][8]])){
      array_push($score, 'p');
    }
    else{
      array_push($score, 'f');
    }
  $transact = $examiner->scoreAndGrade($_POST[$all_tests_details[0][8]],$_POST[$all_tests_details[1][8]],$_POST['r3'],$_POST['r4'],$_POST['r5'],
                            $_POST['r6'],$_POST['r7'],$_POST['r8'],$_POST['r9'],$_POST['r10'],
                            $_POST['t1'],$_POST['t2'],$_POST['t3'],$_POST['t4'],$_POST['t5'],
                            $_POST['t6'],$_POST['t7'],$_POST['t8'],$_POST['t9'],$_POST['t10'],
                            $_POST['a1'],$_POST['a2'],$_POST['a3'],$_POST['a4'],$_POST['a5'],
                            $_POST['a6'],$_POST['a7'],$_POST['a8'],$_POST['a9'],$_POST['a10'],
                            $_POST['curr_modul'],$test->number_of_questions,$_SESSION['userid']);
}*/

}


///////////////////////////////////////////////CALL HEADER FOR TEST PAGE///////////////////////////////////////////////////////////
echo $interface->testheader($title='NMITS::Trainee Page');
echo $current_moduleno;
echo "<br />";
///////////GET THE MAXIMUM NUMBER OF QUESTIONS IN DB FOR THE SPECIFIED MODULE NUMBER
$test->max_number_of_available_questions = $test->getAvailableTestCount($current_moduleno);
echo $test->max_number_of_available_questions;
echo "<br />";
for ($i=1; $i<=$test->max_number_of_available_questions; $i++){
  array_push($test->test_number_array,$i); //creates an array that contains the test numbers: e.g: 1,2,3,4,...,max
}
shuffle($test->test_number_array); //shuffle array so that numerically arranged array randomizes to e.g: 5,3,max,6,max-3,...
print_r($test->test_number_array);
$test->period_of_test;
echo "<div id='allTestPageContent'>";
echo"<b>Hello ".ucfirst($_SESSION['surname']).", welcome to NMITS Testing Platform.</b><br/>";


?>

<!---echo<<<_content-->
<div id="testclas" class="testclas">
 <!--<p><h3 class='w3-right'><b>TIME LEFT:  $test->period_of_test</b></h3></p><br/>--->
 <p ><h3 class='w3-right w3-medium'><b>TIME LEFT: <span id="countdown"></span> </b></h3></p><br/>
 <?php echo $transact; ?>
<!---content;
?>  --->


<?php
for ($i=0; $i<$test->number_of_questions; $i++){
  $test_number = $test->test_number_array[$i];  // we're fetching the test details of the question that has the corresponding number in this array
  $test_details = $test->getTestDetails($current_moduleno, $test_number);
  array_push($test_details, $test_number);  //so that each test detail can have its respective test number
  //print_r($test_details);
  //echo "<br />";
  // $all_tests_details = hours, question, answer1, answer2, answer3, answer4, answer5, canswer, testno
  for($j=0; $j<=8; $j++){   //because there are just 8 values in the $test_details array
    $all_tests_details[$i][$j] = $test_details[$j] ;  //a multidimensional array for all questions' details
  }
} 
//$displayed_test_number = $i + 1;      //this value is just displayed on the interface to show question number

print_r($all_tests_details);

echo "<br />";
$all_tests_count = count($all_tests_details);
echo "<br />";
$test_details_count = count($test_details);

echo "<form action ="; echo htmlspecialchars($_SERVER['PHP_SELF']); echo" method = 'post'>";

for ($l=0; $l<$test->number_of_questions; $l++){
print_r($all_tests_details[$l][8]);
echo ":";
print_r($all_tests_details[$l][7]);
echo "***";
$all_tests_ans[$all_tests_details[$l][8]] = $all_tests_details[$l][7];
//displayQuestion($l, $all_tests_details, $current_moduleno);
echo      "<table style='border:2px solid #73AD21; border-radius: 5px; width: 55%'>";
echo      "<tr>";  
echo      "<td>";          
echo      "<strong>QUESTION "; echo $l+1 ; echo"</strong>";            
echo      "</td>";  
echo      "</tr>";
echo      "<tr>";
echo      "<td style='font-size:20px'>";
echo      ucfirst($all_tests_details[$l][1]);
echo      "</td>";
echo      "</tr>";
echo      "<tr>";  
echo      "<td>";  
echo      "<label class='container'>"; echo $all_tests_details[$l][2]; echo "<input type='radio' name='"; echo $all_tests_details[$l][8]; echo"' class='w3-left' value='a' ><span class='checkmark'></span></label>";     
echo      "</td>";
echo      "</tr>";
echo      "<tr>";  
echo      "<td>";  
echo      "<label class='container'>"; echo $all_tests_details[$l][3]; echo "<input type='radio' name='"; echo $all_tests_details[$l][8]; echo"' class='w3-left' value='b' ><span class='checkmark'></span></label>";     
echo      "</td>";
echo      "</tr>";
echo      "<tr>";  
echo      "<td>";  
echo      "<label class='container'>"; echo $all_tests_details[$l][4]; echo "<input type='radio' name='"; echo $all_tests_details[$l][8]; echo"' class='w3-left' value='c' ><span class='checkmark'></span></label>";     
echo      "</td>";
echo      "</tr>";
echo      "<tr>";  
echo      "<td>";  
echo      "<label class='container'>"; echo $all_tests_details[$l][5]; echo "<input type='radio' name='"; echo $all_tests_details[$l][8]; echo"' class='w3-left' value='d' ><span class='checkmark'></span></label>";     
echo      "</td>";
echo      "</tr>";
echo      "<tr>";  
echo      "<td>";  
echo      "<label class='container'>"; echo $all_tests_details[$l][6]; echo "<input type='radio' name='"; echo $all_tests_details[$l][8]; echo"' class='w3-left' value='e' ><span class='checkmark'></span></label>";     
echo      "</td>";
echo      "</tr>";
echo      "</table>";
}
echo "<input type='hidden' name='allans' class='w3-left' value='"; echo $all_tests_ans; echo"' >";
echo      "<button type='submit' id='submittest' name='submittest' class='w3-btn ww3-large w3-round-xxlarge w3-dark-grey w3-hover-light-grey w3-left' style='font-weight:900;'>SUBMIT</button>";

echo      "</form>";
echo      "</div>";

print_r($all_tests_ans);





//displayQuestion($i, $all_tests_details, $current_moduleno);

//implement when submission is done
if(isset($_POST['nextq'])){
  ++$i;
  if($i > $test->number_of_questions){
    //enable submit button and disable next button
  }
  else{}
  //displayQuestion($i, $all_tests_details, $current_moduleno);
  
}




?>



