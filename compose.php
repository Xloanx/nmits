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
$message  = new message();
$trainee    =new trainee();
$trainer     =new trainer();
$max_moduleno = @$_SESSION['maxmodule'];

echo $interface->composeheader($title='NMITS::Compose');


echo<<<content
<header class="w3-container  w3-light-grey"  >
<h3>Compose</h3>
</header>
<form>
<p>Subject 
	<input class="w3-input w3-border" type="text" placeholder="Message Subject" name="subject" size="50" required autofocus></p><hr/>
<p>Message</p>
    <textarea name="message" style="width:95%; height:250px" class="w3-center " required></textarea> <hr/>
<button type="submit" class="w3-btn w3-xlarge w3-dark-grey w3-hover-light-grey w3-circle w3-right" style="font-weight:600">Send</button>
        </form>

content;





















?>