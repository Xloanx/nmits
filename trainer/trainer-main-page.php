<?php
require_once('../classes/trainer-session-handler.php');

//call required classes for interface and object creation

require_once('../classes/interface.php');
$interface = new interface1();

echo $interface->TrainerSideNav($title='NMITS::Trainer Page');

$info = "<h4 class='pageInfoSuccess'>Welcome ".ucfirst($_SESSION['surname'])."</h4>";

echo $info;


//print_r($_SESSION);

?>
