<?php

if (!isset($_SESSION)) {
  session_start();

  if(@$_SESSION['STATUS'] == "")
    {
      header('Refresh: 2; URL = signin.php');
  }
}

//call required classes for interface and object creation

require_once('classes/interface.php');
require_once('classes/message.php');
require_once('classes/trainee.php');
require_once('classes/trainer.php');
$interface  = new interface1();
$message	= new message();
$trainee    =new trainee();
$trainer     =new trainer();
$max_moduleno = @$_SESSION['maxmodule'];

echo $interface->inboxheader($title='NMITS::Inbox Page');

echo<<<content
<div  class="w3-sidebar w3-light-grey w3-bar-block" style="width:20%">
  <p>Subjects</p>
</div>

<div class="w3-container  w3-cell">
  <p>Hello W3.CSS Layout.</p>
</div>


content;




















?>