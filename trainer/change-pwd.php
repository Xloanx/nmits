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
if(isset($_POST['tracker']) && isset($_POST['edit_pwd'])){
$transact = $trainer->changePwd($_POST['old_password'], $_POST['new_password'], $_POST['new_password_again']);
}


?>


<!-- Selected Task Page -->
    <div >
      <h1>Edit Password Form</h1>
      <?php echo "<p class='pageInfoSuccess'> $transact</p>"; ?>
      <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method = "post">
        <p><input class="w3-input w3-border" type="password" placeholder="Old Password" name="old_password" required></p>
        <p><input class="w3-input w3-border" type="password" placeholder="New Password" name="new_password" required></p>
        <p><input class="w3-input w3-border" type="password" placeholder="Retype New Password" name="new_password_again" required></p>
        <p><input type="Hidden" id="tracker" name="tracker" value="regxn"/></p>
        <button type="submit" id="edit_pwd" name="edit_pwd" class="w3-btn w3-dark-grey w3-medium w3-round-xxlarge w3-hover-light-grey" style="font-weight:900;">Edit Password</button> </a>
      </form>
    </div>
