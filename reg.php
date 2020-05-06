<?php
if (!isset($_SESSION)) {
  session_start();
}

//call required classes for interface and object creation
require_once('classes/interface.php');
require_once('classes/trainee.php');
$interface = new interface1();
$trainee = new trainee();

$transact="";
if ($_SESSION['STATUS'] == TRUE) $info ="<span class='pageInfoSuccess'>Welcome ".ucfirst($_SESSION['surname'])."</span>";
else $info ="<span class='pageInfoErr'>Hello Guest, You are not logged in</span>";

if(isset($_POST['tracker']) && isset($_POST['register'])){
$transact = $trainee->signup($_POST['surname'], $_POST['firstname'], $_POST['dor'], $_POST['password'], $_POST['password_again'], $_POST['email'], $_POST['phone1'], $_POST['category']);
}

echo $interface->header($title='NMITS::Registration');


//echo <<<_addNewTrainee
?>



<!-- Selected Task Page -->
<div >
  <h1>Trainee's Registration Form</h1>
  <?php echo $transact ?>
  <form action = "<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method = "post" >
    <p><input class="w3-input w3-border" type="text" placeholder="Surname" name="surname" size="50" required autofocus></p>
      <p><input class="w3-input w3-border" type="text" placeholder="firstname" name="firstname" size="50" required autofocus></p>
    <p><input class="w3-input w3-border" type="date" placeholder="Date of Regisration" name="dor" size="50" ></p>
    <p><input class="w3-input w3-border" type="email" placeholder="Email Address" name="email" size="50"></p>
    <p><input class="w3-input w3-border" type="password" placeholder="Password" name="password" size="50" required></p>
    <p><input class="w3-input w3-border" type="password" placeholder="Retype Password" name="password_again" size="50" required></p>
    <p><input class="w3-input w3-border" type="tel" placeholder="Phone Number (Main)" name="phone1" size="50" ></p>
    <select class="w3-input w3-border" name="category">
      <option value="select">Select Category</option>
      <option value="beginner">Beginner</option>
      <option value="intermediate">Intermediate</option>
      <option value="advanced">Advanced</option>
    </select>
    <p><input type="Hidden" id="tracker" name="tracker" value="regxn"/></p>
    <button type="submit" id="register" name="register" class="w3-btn w3-xlarge w3-dark-grey w3-hover-light-grey" style="font-weight:900;">Register</button> </a>
      </form>
    <a href='index.html'> <button class="w3-btn w3-xlarge w3-dark-grey w3-hover-light-grey w3-right"  onclick="document.getElementById('id01').style.display='block'" style="font-weight:900;">Back To Home</button> </a>
    </div>
</body>
</html>
    <?php
//_addNewTrainee;

?>
