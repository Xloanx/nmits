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

/////////////////////////////////////START VARIABLE DECLARATION//////////////////////////////////////////////////////////////////
$max_moduleno = @$_SESSION['maxmodule'];            //the maximum module number that this session holder can access
$test_number ="";
$transact="";
$radio_name = ['r1','r2','r3','r4','r5','r6','r7','r8','r9','r10'];
$test_name = ['t1','t2','t3','t4','t5','t6','t7','t8','t9','t10'];
$ansName =['a1','a2','a3','a4','a5','a6','a7','a8','a9','a10'];

////CHECK TO SEE IF THE SEARCH STRING FOR THE CALLING MODULE IS ATTACHED TO URL, IF IT IS INITIALIZE $current_moduleno
if (isset($_GET["curr_mod"])) $current_moduleno = $_GET["curr_mod"];
else echo"<span class='pageInfoErr'>We don't know the module that generated this test page</span>";

///////////////////////////////////////////////CALL HEADER FOR TEST PAGE/////////////////////////////////////////////
echo $interface->testheader($title='NMITS::Trainee Page');

///////////GET THE MAXIMUM NUMBER OF QUESTIONS IN DB FOR THE SPECIFIED MODULE NUMBER
$test->max_number_of_available_questions = $test->getAvailableTestCount($current_moduleno);
//$test->number_of_questions_for_module = $test->getTotalNoOfQuestionsForModule($current_moduleno);
for ($i=1; $i<=$test->max_number_of_available_questions; $i++){
  array_push($test->test_number_array,$i); //creates an array that contains the test numbers: e.g: 1,2,3,4,...,max
}
shuffle($test->test_number_array); //shuffle array so that numerically arranged array randomizes to e.g: 5,3,max,6,max-3,...

$test->period_of_test;
echo "<div id='allTestPageContent'>";
echo"<b>Hello ".ucfirst($_SESSION['surname']).", welcome to NMITS Testing Platform.</b><br/>";

echo<<<regulations
<div id ='alert' class='alert'>
  <span class='closebtn' onclick="disagreeOnRegulation()">&times;</span>
  <strong>Before you commence the test, here are some regulations as regards the test:<br/></strong>
  1. You will be exposed to $test->number_of_questions questions in this module's test.<br/>
  2. The timing is displayed at the top right corner of the test page.<br/>
  3. If you do not submit before time elapses,the test automatically submit itself.<br/>
  4. Click the submit button to submit your test when you are through with your test<br/>
  You MUST agree to these conditions by clicking the continue button to begin the test.<br/>
  Best of luck!!!<br/><br/>
  <button type="submit"  onclick="startTest()" class="w3-btn w3-xlarge w3-dark-grey w3-hover-light-grey" style="font-weight:900;">Continue >>></button> </a>
</div>
regulations; 

//implement when submission is done
if(isset($_POST['tracker']) && isset($_POST['submit_test']))
  {
  $examiner->scoreAndGrade($_POST['r1'],$_POST['r2'],$_POST['r3'],$_POST['r4'],$_POST['r5'],$_POST['r6'],$_POST['r7'],$_POST['r8'],$_POST['r9'],$_POST['r10'],$_POST['t1'],$_POST['t2'],$_POST['t3'],$_POST['t4'],$_POST['t5'],$_POST['t6'],$_POST['t7'],$_POST['t8'],$_POST['t9'],$_POST['t10'],$_POST['a1'],$_POST['a2'],$_POST['a3'],$_POST['a4'],$_POST['a5'],$_POST['a6'],$_POST['a7'],$_POST['a8'],$_POST['a9'],$_POST['a10'],$_POST['curr_module'],$test->number_of_questions,$_SESSION['userid']);
}


echo<<<_content
<div id="testclass" class="testclass">
 <!--<p><h3 class='w3-right'><b>TIME LEFT:  $test->period_of_test</b></h3></p><br/>--->
 <p ><h3 class='w3-right'><b>TIME LEFT: <span id="countdown"></span> </b></h3></p><br/>
 $transact;
_content;
?>

<form action = "<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method = "post">

<?php
for ($i=0; $i<$test->number_of_questions; $i++){
  $test_number = $test->test_number_array[$i];  // we're fetching the test details of the question that has the corresponding number in this array
  $test_details = $test->getTestDetails($current_moduleno, $test_number);
  $displayed_test_number = $i + 1;      //THis value is just displayed on the interface to show question number

  echo<<<_content1
  	  <!--    <div id="testclass" class="testclass">  -->
  	          <p><h3 ><b>QUESTION $displayed_test_number</b></h3></p>
  	          <p><h3 ><b>$test_details[1]</b></h3></p>
  	          <p><label class="container">$test_details[2]<input type="radio" name="$radio_name[$i]" class="w3-left" value="a" required><span class="checkmark"></span></label></p>
  	          <p><label class="container">$test_details[3]<input type="radio" name="$radio_name[$i]" class="w3-left" value="b" required><span class="checkmark"></span></label></p>
  	          <p><label class="container">$test_details[4]<input type="radio" name="$radio_name[$i]" class="w3-left" value="c" required><span class="checkmark"></span></label></p>
  	          <p><label class="container">$test_details[5]<input type="radio" name="$radio_name[$i]" class="w3-left" value="d" required><span class="checkmark"></span></label></p>
  	          <p><label class="container">$test_details[6]<input type="radio" name="$radio_name[$i]" class="w3-left" value="e" required><span class="checkmark"></span></label></p>
              <p><input type="Hidden" id="testnumber" name="$test_name[$i]" value="$test_number"/></p>
              <p><input type="Hidden" id="ans" name="$ansName[$i]" value="$test_details[7]"/></p>
              <p><input type="Hidden" id="curr_module" name="curr_module" value="$current_moduleno"/></p>
              <hr/ width=100%>
_content1;
}
echo<<<_content1
              <p><input type="Hidden" id="tracker" name="tracker" value="regxn"/></p>
              <button type="submit" id='submit_test' name='submit_test' class="w3-btn w3-xlarge w3-dark-grey w3-hover-light-grey" style="font-weight:900;">SUBMIT</button> </a>
            </form>
          </div>
_content1;

?>
