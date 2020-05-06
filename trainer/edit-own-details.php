<?php
require_once('../classes/trainer-session-handler.php');

//call required classes for interface and object creation
require_once('../classes/interface.php');
require_once('../classes/trainer.php');
$interface = new interface1();
$trainer = new trainer();
$transact="";

echo $interface->TrainerSideNav($title='NMITS::Trainer Page');
echo "<h4 class='pageInfoSuccess'>Welcome ".ucfirst($_SESSION['surname'])."</h4>";

if(isset($_POST['tracker']) && isset($_POST['editowndet']))
	{
	$transact = $trainer->editOwnDetail($_POST['surname'], $_POST['firstname'], $_SESSION['email'], $_POST['phone1']);
}
?>
 
<div>
  <h1>Edit Own Details</h1>
  <?php echo $transact ;?>
  <form action = "<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method = "post" >
    <p><input class="w3-input w3-border" type="text" placeholder="Surname" name="surname" value="<?php echo $_SESSION['surname'];?>" size="50" required autofocus></p>
    <p><input class="w3-input w3-border" type="text" placeholder="firstname" name="firstname" value="<?php echo $_SESSION['firstname'];?>" size="50" required></p>
    <p><input class="w3-input w3-border" type="email" placeholder="Email Address" name="email" value="<?php echo $_SESSION['email'];?>" size="50" disabled></p>
    <p><input class="w3-input w3-border" type="tel" placeholder="Phone Number (Main)" value="<?php echo $_SESSION['phone'];?>" name="phone1" size="50" ></p>
    <p><input type="Hidden" id="tracker" name="tracker" value="regxn"/></p>
    <button type="submit" id='editowndet' name='editowndet'class="w3-btn w3-round-xxlarge w3-dark-grey w3-hover-light-grey" style="font-weight:900;">Edit Own Detail</button> </a>
      </form>
</div>
