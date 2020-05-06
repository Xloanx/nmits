<?php

/*
if (!isset($_SESSION)) {
  session_start();
}
*/

//call required classes for interface and object creation

require_once('../classes/interface.php');
$interface = new interface1();

echo $interface->TrainerSideNav($title='NMITS::Trainer Page');

?>
<div>
  <h1>Delete Module</h1>
  <form action = "<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method = "post" >
    <p><input class="w3-input w3-border" type="text" placeholder="Module Number" name="module_number" size="10" required autofocus></p>
    <button type="submit" class="w3-btn w3-xlarge w3-dark-grey w3-hover-light-grey" style="font-weight:900;">Delete Module</button>
  </form>
<!--<a href='index.html'> <button class="w3-btn w3-xlarge w3-dark-grey w3-hover-light-grey w3-right"  onclick="document.getElementById('id01').style.display='block'" style="font-weight:900;">Back To Home</button> </a>-->
</div>
