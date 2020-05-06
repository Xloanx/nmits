<?php
if (!isset($_SESSION)) {
  session_start();
}


//call required classes for interface and object creation

require_once('classes/interface.php');
require_once('classes/trainer.php');
require_once('classes/trainee.php');
$interface = new interface1();
$trainer = new trainer();
$trainee = new trainee();


$transact="";
//if ($_SESSION['STATUS'] == TRUE) $info ="<span class='pageInfoSuccess'>Welcome ".ucfirst($_SESSION['lname'])."</span>";
//else $info ="<span class='pageInfoErr'>Hello Guest, You are not logged in</span>";

if(isset($_POST['tracker']) && isset($_POST['signin'])){
  if($_POST['role'] == 'trainee'){
    $transact = $trainee->signin($_POST['email'], $_POST['password'], $_POST['role']);
  }
  else{
      $transact = $trainer->signin($_POST['email'], $_POST['password'], $_POST['role']);
  }
}


echo $interface->header($title='NMITS::Sign-In');
?>


<div >
  <h1>Sign In</h1>
  <?php echo $transact; ?>
  <form action = "<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method = "post">
    <p><input class="w3-input w3-border" type="text" placeholder="Email" name="email" size="50" required autofocus></p>
    <p><input class="w3-input w3-border" type="password" placeholder="Password" name="password" size="50" required></p>
    <select class="w3-input w3-border" name="role">
      <option value="select">Select Role</option>
      <option value="trainer">Trainer</option>
      <option value="trainee">Trainee</option>
    </select>
    <p><input type="Hidden" id="tracker" name="tracker" value="regxn"/></p>
    <button type="submit" id="signin" name="signin" class="w3-btn w3-large w3-round-xxlarge w3-dark-grey w3-hover-light-grey" style="font-weight:900;" name="login">Sign In</button> </a>
      </form>
    <a href='index.html'> <button class="w3-btn w3-large w3-round-xxlarge w3-dark-grey w3-hover-light-grey w3-right"  onclick="document.getElementById('id01').style.display='block'" style="font-weight:900;">Back To Home</button> </a>
    </div>
