<?php
require_once('../classes/trainer-session-handler.php');


//call required classes for interface and object creation
require_once('../classes/interface.php');
require_once('../classes/trainer.php');
$interface = new interface1();
$trainer = new trainer();

echo $interface->TrainerSideNav($title='NMITS::Trainer Page');
echo "<h4 class='pageInfoSuccess'>Welcome ".ucfirst($_SESSION['surname'])."</h4>";

$transact="";

if(isset($_POST['tracker']) && isset($_POST['register'])){
$transact = $trainer->signup($_POST['surname'], $_POST['firstname'], $_POST['dor'], $_POST['password'], $_POST['password_again'], $_POST['email'], $_POST['phone1']);
}

?>

<!-- Selected Task Page -->
<div >
  <h1>Trainers'Registration Form</h1>

      <?php echo $transact ?>
  <form action = "<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method = "post" >
    <p><input class="w3-input w3-border" type="text" placeholder="Surname" name="surname" size="50" required autofocus></p>
      <p><input class="w3-input w3-border" type="text" placeholder="firstname" name="firstname" size="50" required autofocus></p>
    <p><input class="w3-input w3-border" type="date" placeholder="Date of Regisration" name="dor" size="50" ></p>
  <!--  <p><input class="w3-input w3-border" type="text" placeholder="Username" name="username" size="50" required></p>  -->
    <p><input class="w3-input w3-border" type="password" placeholder="Password" name="password" size="50" required></p>
    <p><input class="w3-input w3-border" type="password" placeholder="Retype Password" name="password_again" size="50" required></p>
    <p><input class="w3-input w3-border" type="email" placeholder="Email Address" name="email" size="50"></p>
    <p><input class="w3-input w3-border" type="tel" placeholder="Phone Number (Main)" name="phone1" size="50" ></p>
    <p><input type="Hidden" id="tracker" name="tracker" value="regxn"/></p>
    <button type="submit" id="register" name="register" class="w3-btn w3-round-xxlarge w3-dark-grey w3-hover-light-grey" style="font-weight:900;">Register</button> </a>
      </form>
    <a href='index.html'> <button class="w3-btn w3-round-xxlarge w3-dark-grey w3-hover-light-grey w3-right"  onclick="document.getElementById('id01').style.display='block'" style="font-weight:900;">Back To Home</button> </a>
    </div>
