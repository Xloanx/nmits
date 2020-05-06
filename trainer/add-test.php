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

if(isset($_POST['tracker']) && isset($_POST['addtest'])){
$transact = $test->addTest($_POST['module_number'], $_POST['test_number'], $_POST['hours'], $_POST['question'], $_POST['option_1'], $_POST['option_2'], $_POST['option_3'], $_POST['option_4'], $_POST['option_5'], $_POST['correct_option']);
}

?>

<div>
  <h1>Add Test</h1>
  <?php echo $transact ?>
  <form action = "<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method = "post" >
    <p><input class="w3-input w3-border" type="text" placeholder="Module Number" name="module_number" size="10" required autofocus></p>
    <p><input class="w3-input w3-border" type="text" placeholder="Test Number" name="test_number" size="50" required></p>
    <p><input class="w3-input w3-border" type="text" placeholder="Estimated Time Required (in mins)" name="hours" size="50" required></p>
    <p>Enter Question Here:
      <textarea name="question" style="width:100%; height:200px" required></textarea> </p>
    <p><input class="w3-input w3-border" type="text" placeholder="Answer Option 1" name="option_1" size="50" required></p>
    <p><input class="w3-input w3-border" type="text" placeholder="Answer Option 2" name="option_2" size="50" required></p>
    <p><input class="w3-input w3-border" type="text" placeholder="Answer Option 3" name="option_3" size="50" required></p>
    <p><input class="w3-input w3-border" type="text" placeholder="Answer Option 4" name="option_4" size="50" required></p>
    <p><input class="w3-input w3-border" type="text" placeholder="Answer Option 5" name="option_5" size="50" required></p>
    <p><select class="w3-input w3-border" name="correct_option">
          <option value="select">Select the Correct Answer</option>
          <option value="a">Option 1</option>
          <option value="b">Option 2</option>
          <option value="c">Option 3</option>
          <option value="d">Option 4</option>
          <option value="e">Option 5</option>
        </select></p>
    <p><input type="Hidden" id="tracker" name="tracker" value="regxn"/></p>
    <button type="submit" id='addtest' name='addtest' class="w3-btn w3-round-xxlarge w3-dark-grey w3-hover-light-grey" style="font-weight:900;">Add Test</button> </a>
      </form>
<!--    <a href='index.html'> <button class="w3-btn w3-xlarge w3-dark-grey w3-hover-light-grey w3-right"  onclick="document.getElementById('id01').style.display='block'" style="font-weight:900;">Back To Home</button> </a>-->
    </div>
