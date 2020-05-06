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
require_once('../classes/trainer.php');
require_once('../classes/test.php');
$interface = new interface1();
$trainer = new trainer();
$test = new test();


echo $interface->TrainerSideNav($title='NMITS::Trainer Page');
echo "<h4 class='pageInfoSuccess'>Welcome ".ucfirst($_SESSION['surname'])."</h4>";

$transact="";

if(isset($_POST['tracker']) && isset($_POST['deltest'])){
  $transact = $test->delTest($_POST['module_number'], $_POST['test_number']);
}
elseif (isset($_GET["testid"])){
  $transact = $test->delTestbytid($_GET["testid"]);
}
  
?>

<div>
  <div>
      <h1>Delete Test</h1>
      <?php //This line is essential because the function might return error in strings
          if (gettype($transact) != "array") echo "<p style='color:red'> <strong>$transact </strong><p>";
      ?>
      <form action = "<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method = "post" >
        <p><input class="w3-input w3-border" type="text" placeholder="Module Number" name="module_number" size="10" required autofocus></p>
        <p><input class="w3-input w3-border" type="text" placeholder="Test Number" name="test_number" size="10" required ></p>
        <p><input type="Hidden" id="tracker" name="tracker" value="regxn"/></p>
        <button type="submit" id='deltest' name='deltest'class="w3-btn w3-xlarge w3-dark-grey w3-hover-light-grey" style="font-weight:900;">Delete Test</button>
      </form>
<!--<a href='index.html'> <button class="w3-btn w3-xlarge w3-dark-grey w3-hover-light-grey w3-right"  onclick="document.getElementById('id01').style.display='block'" style="font-weight:900;">Back To Home</button> </a>-->
  </div>
