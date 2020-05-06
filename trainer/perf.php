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
  <h4>Trainees'Performance View</h4>
  <div>
    <form action = "<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method = "post" >
      <p><select class="w3-input w3-border" name="search_factor">
        <option value="select">Search By</option>
        <option value="username">Username</option>
        <option value="module_number">Module Number</option>
        <option value="score">Test Score</option>
        <option value="grade">Grade</option>
        <option value="time_spent">Time</option>
      </select>
      <button type="submit" class="w3-btn w3-xlarge w3-dark-grey w3-hover-light-grey" style="font-weight:900;">Search</button> </a>
    </p>
    </form>
<!--  <a href='index.html'> <button class="w3-btn w3-xlarge w3-dark-grey w3-hover-light-grey w3-right"  onclick="document.getElementById('id01').style.display='block'" style="font-weight:900;">Back To Home</button> </a>-->
  </div>
  <div>
    <table style="width:100%" class="w3-table">
      <tr>
        <th style="width:20%" class="w3-bold">Username</th>
        <th style="width:20%">Module</th>
        <th style="width:20%">Test Score</th>
        <th style="width:20%">Grade</th>
        <th style="width:20%">Time Spent</th>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
    </table>
  </div>
</div>
