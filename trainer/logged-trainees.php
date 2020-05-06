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

<div >
  <h4>Logged Trainees View</h4>
  <div>
    <form action = "<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method = "post" >
      <p><select class="w3-input w3-border" name="search_factor">
        <option value="select">Search By</option>
        <option value="surname">Surname</option>
        <option value="firstname">Firstname</option>
        <option value="dor">Date of Reg</option>
        <option value="username">Username</option>
        <option value="email">Email</option>
        <option value="phone">Phone</option>
        <option value="category">Category</option>
      </select></p>
      <button type="submit" class="w3-btn w3-xlarge w3-dark-grey w3-hover-light-grey" style="font-weight:900;">Search</button> </a>
    </form>
<!--  <a href='index.html'> <button class="w3-btn w3-xlarge w3-dark-grey w3-hover-light-grey w3-right"  onclick="document.getElementById('id01').style.display='block'" style="font-weight:900;">Back To Home</button> </a>-->
  </div>
  <div>
    <table style="width:100%">
      <tr>
        <th style="width:20%" class="w3-bold">Surname</th>
        <th style="width:20%">Firstname</th>
        <th style="width:10%">Date of Registration</th>
        <th style="width:15%">Username</th>
        <th style="width:20%">Email</th>
        <th style="width:10%">Phone</th>
        <th style="width:5%">Category</th>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
    </table>
  </div>
</div>
