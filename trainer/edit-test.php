<?php

require_once('../classes/trainer-session-handler.php');


//call required classes for interface and object creation

require_once('../classes/interface.php');
require_once('../classes/trainer.php');
require_once('../classes/test.php');
$interface = new interface1();
$trainer = new trainer();
$test = new test();

echo $interface->TrainerSideNav($title='NMITS::Trainer Page');
echo "<h4 class='pageInfoSuccess'>Welcome ".ucfirst($_SESSION['surname'])."</h4>";

$transact="";

if (isset($_GET["testid"])){
  $transact = $test->searchTestForEditbytid($_GET["testid"]);
} //the form that generates this elseif section has been commented out, it's just retained for further //consideration
elseif(isset($_POST['tracker']) && isset($_POST['sedittest'])){ 
  $transact = $test->searchTestForEdit($_POST['module_number'], $_POST['test_number']);
}


if(isset($_POST['tracker']) && isset($_POST['edittest'])){
$transact = $test->editTest($_POST['module_number'], $_POST['test_number'], $_POST['hours'], $_POST['question'], $_POST['option_1'], $_POST['option_2'], $_POST['option_3'], $_POST['option_4'], $_POST['option_5'], $_POST['correct_option']);
}

 
?>

<div>
  <div>
      <h1>Edit Test</h1>
      <?php //This line is essential because the function might return error in strings
          if (gettype($transact) != "array") echo "<p style='color:red'> <strong>$transact </strong><p>";
      ?>
<!---- This form was commented out because I feel it's better to inititate edit via the view page so that the trainer sees what he or she is deleting before executing the function rather than supplying the the module number and test number exclusively. This is just to minimize errors of mistakenly supplying the wrong module and/or test number(s)  

    <form action = "<?php //echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method = "post" >
        <p><input class="w3-input w3-border" type="text" placeholder="Module Number" name="module_number" size="10" required autofocus></p>
        <p><input class="w3-input w3-border" type="text" placeholder="Test Number" name="test_number" size="10" required ></p>
        <p><input type="Hidden" id="tracker" name="tracker" value="regxn"/></p>
        <button type="submit" id='sedittest' name='sedittest'class="w3-btn w3-xlarge w3-dark-grey w3-hover-light-grey" style="font-weight:900;">Search Test for Edit</button>
      </form>
---->
  </div>

<!----
This form is expected to pop up (auto-filled) with details after the search form is successful so that editing can take place
--->
<div> <!---This line is essential to insert values into the variables which is in turn used to re-edit the data to avoid errors of uninitialized index of arrays-->
  <?php  list ($time_req, $question, $opt1, $opt2, $opt3, $opt4, $opt5, $test_no, $module_no) = $transact;   ?>

  <form action = "<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method = "post" >
    <p><label>Module Number</label>
      <input class="w3-input w3-border" type="text" placeholder="Module Number" value="<?php echo $module_no; ?>" name="module_number" size="10" required >
    </p>
    <p><label>Test Number</label>
      <input class="w3-input w3-border" type="text" placeholder="Test Number" value="<?php echo $test_no; ?>" name="test_number" size="50" required></p>
    <p><label>Estimated Time Required (in Mins:)</label>
      <input class="w3-input w3-border" type="text" placeholder="Estimated Minute Required"  value="<?php echo $time_req; ?>" name="hours" size="50" required></p>
    <p><label>Question</label>
      <textarea name="question" style="width:100%; height:250px" required><?php echo $question; ?></textarea>  </p>
    <p><label>Answer Option 1</label>
      <input class="w3-input w3-border" type="text" placeholder="Answer Option 1" value="<?php echo $opt1; ?>"   name="option_1" size="50" required></p>
    <p><label>Answer Option 2</label>
      <input class="w3-input w3-border" type="text" placeholder="Answer Option 2" value="<?php echo $opt2; ?>"   name="option_2" size="50" required></p>
    <p><label>Answer Option 3</label>
      <input class="w3-input w3-border" type="text" placeholder="Answer Option 3" value="<?php echo $opt3; ?>"   name="option_3" size="50" required></p>
    <p><label>Answer Option 4</label>
      <input class="w3-input w3-border" type="text" placeholder="Answer Option 4" value="<?php echo $opt4; ?>"   name="option_4" size="50" required></p>
    <p><label>Answer Option 5</label>
      <input class="w3-input w3-border" type="text" placeholder="Answer Option 5" value="<?php echo $opt5; ?>" name="option_5" size="50" required></p>
    <p><label>Select the Correct Option</label>
      <select class="w3-input w3-border" name="correct_option">
          <option value="select">Select the Correct Answer</option>
          <option value="a">Option 1</option>
          <option value="b">Option 2</option>
          <option value="c">Option 3</option>
          <option value="d">Option 4</option>
          <option value="e">Option 5</option>
        </select></p>
      <p><input type="Hidden" id="tracker" name="tracker" value="regxn"/></p>
    <button type="submit" id='edittest' name='edittest' class="w3-btn w3-dark-grey w3-medium w3-round-xxlarge w3-hover-light-grey" style="font-weight:900;">Edit Test</button> </a>
  </form> 
  </div>
</div>
 