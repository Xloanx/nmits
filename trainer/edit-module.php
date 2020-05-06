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
/*
echo <<<_TrainersMainPageHeading
<div>
<h1 class="w3-right">Trainers'Main Page</h1>
</div>
_TrainersMainPageHeading;
*/
?>
<div>
  <h1>Edit Module</h1>
  <form action = "<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method = "post" >
    <p><input class="w3-input w3-border" type="text" placeholder="Module Number" name="module_number" size="10" required autofocus></p>
    <button type="submit" class="w3-btn w3-xlarge w3-dark-grey w3-hover-light-grey" style="font-weight:900;">Search Module</button>
  </form>
<!--<a href='index.html'> <button class="w3-btn w3-xlarge w3-dark-grey w3-hover-light-grey w3-right"  onclick="document.getElementById('id01').style.display='block'" style="font-weight:900;">Back To Home</button> </a>-->
</div>

<!----
This form is expected to pop up (auto-filled) with details after the search form is successful so that editing can take place

<div>
  <h1>Edit Module</h1>
  <form action = "<?php //echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method = "post" >
    <p><input class="w3-input w3-border" type="text" placeholder="Module Number" name="module_number" size="10" required autofocus></p>
    <p><input class="w3-input w3-border" type="text" placeholder="Module Topic" name="module_topic" size="50" required></p>
    <p><textarea name="learning_obj" style="width:100%; height:250px" required>Learning Objective</textarea> </p>
    <p><input class="w3-input w3-border" type="text" placeholder="Module Prerequisite" name="module_prerequisite" size="50" required></p>
    <p><input class="w3-input w3-border" type="text" placeholder="Estimated Hours Required" name="hours" size="50" required></p>
    <select class="w3-input w3-border" name="module_category">
      <option value="select">Select Module Category</option>
      <option value="trainer">Basic</option>
      <option value="trainee">Intermediate</option>
      <option value="trainee">Advanced</option>
    </select><br/>
    <textarea name="module_Content" style="width:100%; height:700px">Enter Content Here.</textarea> </p>
    <button type="submit" class="w3-btn w3-xlarge w3-dark-grey w3-hover-light-grey" style="font-weight:900;">Edit Module</button>
      </form>
    <a href='index.html'> <button class="w3-btn w3-xlarge w3-dark-grey w3-hover-light-grey w3-right"  onclick="document.getElementById('id01').style.display='block'" style="font-weight:900;">Back To Home</button> </a>
    </div>
--->
