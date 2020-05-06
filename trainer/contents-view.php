<?php

require_once('../classes/trainer-session-handler.php');


//call required classes for interface and object creation

require_once('../classes/interface.php');
require_once('../classes/module.php');
//require_once('../classes/test.php');
//require_once('../classes/accessdb.php');
$interface = new interface1();
$mod = new module();
//$trainer = new trainer();
//$db = new accessdb();


echo $interface->TrainerSideNav($title='NMITS::Trainer Page');
echo "<h4 class='pageInfoSuccess'>Welcome ".ucfirst($_SESSION['surname'])."</h4>";

$transact="";
$modid = "";
$modno = "";
$modtopic = "";
$modobj = "";
$modprereq = "";
$modhrs = "";
$modcateg = "";
$modcontent = "";

//Search db to get module details for display into appropriate form element
if(isset($_POST['tracker']) && isset($_POST['modulesearch']))
  { 
  $transact   = $mod->searchForModule($_POST['module_number']);
  if (gettype($transact) == "array")
    {
    $modid      = $transact["moduleid"];
    $modno      = $transact["moduleno"];
    $modtopic   = $transact["moduletopic"];
    $modobj     = $transact["objective"];
    $modprereq  = $transact["prerequisite"];
    $modhrs     = $transact["hours"];
    $modcateg   = $transact["category"];
    $modcontent = $transact[7];  //the content here isn't from database but the content of a file
  }
  else{ //This section is essential because the function might return error in strings
        echo "<p style='color:red'> <strong> $transact </strong><p>";
        $transact="";
        $modid = "";
        $modno = "";
        $modtopic = "";
        $modobj = "";
        $modprereq = "";
        $modhrs = "";
        $modcateg = "";
        $modcontent ="";
  }
}



//Called by the Edit Button to edit the Module Content
if(isset($_POST['edit_mod']))
  { 
  $transact =$mod->editModule($_POST['moduleid'],$_POST['module_number'], $_POST['module_topic'], $_POST['learning_obj'], $_POST['module_prerequisite'], $_POST['hours'], $_POST['module_cat'], $_POST['module_content'], $_FILES);
}


//this implementation is for deletion, the GUI has a delete button/link that calls this function
if (isset($_POST["del_mod"]))
    { 
    $transact1 = $mod->delModule($_POST["moduleid"]);
    if ($transact1 == TRUE)
        {
          $transact1 = "Module deleted Successfully";
          echo "<p style='color:green'> <strong> $transact1 </strong><p>";
    }
    else 
      {
        $transact1 = "Module could not be deleted";
        echo "<p style='color:red'> <strong> $transact1 </strong><p>";
    }
}


if (gettype($transact) != "array") echo "<p style='color:red'> <strong> $transact </strong><p>";


?>


<div>
  <div>
    <form action = "<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method = "post" >
      <p>Enter Module Number:
        <input class="w3-input w3-border" type="text" placeholder="Search a Specific Module Number" name="module_number" size="10" required autofocus>
      </p>
      <p><input type="Hidden" id="tracker" name="tracker" value="regxn"/></p>
      <button type="submit" id="modulesearch" name="modulesearch" class="w3-btn w3-round-xxlarge w3-dark-grey w3-hover-light-grey" style="font-weight:900;">Search Module</button>
    </form>
  </div>

  <div>
    <h1>View Module Details</h1>
    <form action = "<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method = "post" >
      <p>
        <input type="Hidden" id="moduleid" name="moduleid" value="<?php echo $modid; ?>"/>
      </p>
      <p> Module Number:
        <input class="w3-input w3-border" type="text" placeholder="Module Number" name="module_number" value="<?php echo $modno; ?>" size="10" required autofocus>
      </p>
      <p> Module Topic
        <input class="w3-input w3-border" type="text" placeholder="Module Topic" name="module_topic" value="<?php echo $modtopic; ?>" size="50" required>
      </p>
      <p><b>Learning Objective(s):</b>
        <textarea name="learning_obj" style="width:100%; height:250px" required> <?php echo $modobj ?> </textarea>
      </p>
      <p> Module Prerequisite
        <input class="w3-input w3-border" type="text" placeholder="Module Prerequisite" name="module_prerequisite" value="<?php echo $modprereq; ?>" size="50" required>
      </p>
      <p> Estimated Study Time (in hrs)
        <input class="w3-input w3-border" type="text" placeholder="Estimated Hours Required" name="hours" value="<?php echo $modhrs ?>" size="50"  required>
      </p>
      <p> Module Category
        <input class="w3-input w3-border" type="text" placeholder="Module Category" name="module_cat" value="<?php echo $modcateg; ?>" size="50" required>
      </p>
      <p><b>Module Content:</b> 
        <textarea name="module_content" style="width:100%; height:700px" ><?php echo $modcontent; ?></textarea> 
      </p>
      <p>Select additional resource file to upload (File MUST be PDF format and NOT MORE than 1MB):<br/>
        <input type="file" name="module_cont_file" id="module_cont_file">
      </p>

      <div>
    <!---    <button type="submit" id="edit_mod" name="edit_mod" class="w3-btn w3-medium w3-dark-grey w3-hover-yellow w3-right w3-round-xxlarge" style="font-weight:900; margin:20px">
          EDIT THIS MODULE
        </button> -->
        <button type="submit" id="del_mod" name="del_mod" class="w3-btn w3-medium w3-dark-grey w3-hover-red w3-right w3-red w3-round-xxlarge" style="font-weight:900; margin:20px">
          DELETE THIS MODULE
        </button>
  <!----      <button type="submit" id="next_mod" name="next_mod" class="w3-btn w3-medium w3-dark-grey w3-hover-green w3-right w3-medium w3-round-xxlarge" style="font-weight:900; margin:20px">
          FETCH NEXT MODULE
        </button>
      <button class="w3-btn w3-xlarge w3-dark-grey w3-hover-green w3-right"  onclick="document.getElementById('id01').style.display='block'" style="font-weight:900; margin:20px">NEXT</button>--->
    </div>
    </form>
  </div>
</div>
