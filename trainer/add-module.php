<?php
require_once('../classes/trainer-session-handler.php');



//call required classes for interface and object creation
require_once('../classes/interface.php');
require_once('../classes/trainer.php');
require_once('../classes/module.php');
$interface = new interface1();
$trainer = new trainer();
$module = new module();

echo $interface->TrainerSideNav($title='NMITS::Trainer Page');
echo "<h4 class='pageInfoSuccess'>Welcome ".ucfirst($_SESSION['surname'])."</h4>";

$transact="";
if(isset($_POST['tracker']) && isset($_POST['add_module'])){
$transact = $module->addModule($_POST['module_number'], $_POST['module_topic'], $_POST['learning_obj'], $_POST['module_prerequisite'], $_POST['hours'], $_POST['module_category'], $_POST['module_content'], $_FILES);
}
?>

<div>
  <h1>Add Module</h1>
  <?php echo $transact ?>
  <form action = "<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method = "post" enctype="multipart/form-data" >
    <p><input class="w3-input w3-border" type="text" placeholder="Module Number" name="module_number" size="10" required autofocus></p>
    <p><input class="w3-input w3-border" type="text" placeholder="Module Topic" name="module_topic" size="50" required></p>
    <p>Learning Objective <br/> <textarea name="learning_obj" style="width:100%; height:100px" required></textarea> </p>
    <p><input class="w3-input w3-border" type="text" placeholder="Module Prerequisite" name="module_prerequisite" size="50" required></p>
    <p><input class="w3-input w3-border" type="text" placeholder="Estimated Hours Required" name="hours" size="50" required></p>
    <p><select class="w3-input w3-border" name="module_category">
      <option value="select">Select Module Category</option>
      <option value="basic">Basic</option>
      <option value="intermediate">Intermediate</option>
      <option value="advanced">Advanced</option>
    </select></p>
    <p>Enter Module Content:<br/>
      <textarea name="module_content" style="width:100%; height:700px"></textarea> 
    </p>
    <p>AND<br/>
      Select additional resource file to upload (File MUST be PDF format and NOT MORE than 1MB):<br/>
    <input type="file" name="module_content_file" id="module_content_file"></p>
    <p><input type="Hidden" id="tracker" class="w3-round-xxlarge" name="tracker" value="regxn"/></p>
    <button type="submit" name="add_module" class="w3-btn w3-medium w3-round-xxlarge w3-dark-grey w3-hover-light-grey" style="font-weight:900;">Add Module</button>
  </form>
<div>

