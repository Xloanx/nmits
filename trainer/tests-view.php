<?php
require_once('../classes/trainer-session-handler.php');


//call required classes for interface and object creation

require_once('../classes/interface.php');
require_once('../classes/trainer.php');
require_once('../classes/test.php');
require_once('../classes/accessdb.php');
$interface = new interface1();
$trainer = new trainer();
$test = new test();
$db = new accessdb();


echo $interface->TrainerSideNav($title='NMITS::Trainer Page');
echo "<h4 class='pageInfoSuccess'>Welcome ".ucfirst($_SESSION['surname'])."</h4>";

$transact="";
$result="";
 
//this implementation is for deletion, the GUI has a delete button/link that calls this function
if (isset($_GET["testid"]))
    { 
    $transact = $test->delTestbytid($_GET["testid"]);
    if ($transact == TRUE)
        {
          $transact = "Record deleted Successfully";
          //the rest of this section is to strip off the URL params
          if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on')   $url = "https://";   
          else  $url = "http://";   
          // Append the host(domain name, ip) to the URL.   
          $url.= $_SERVER['HTTP_HOST'];   
          // Append the requested resource location to the URL   
          $url.= $_SERVER['REQUEST_URI'];    

          $parsed = parse_url($url);
          $query = $parsed['query'];

          parse_str($query, $params);

          unset($params['testid']);
          $string = http_build_query($params);
          //var_dump($string);
    }
}




//this implementation was removed from nmits/classes/test.php because I had issues trying to loop for the
//mysqli_fetch_rows() to get subsequent rows
if(isset($_POST['tracker']) && isset($_POST['searchbtn']))
  {
    if(isset($_POST['module_number']))
      {
      //$transact = $test->searchTest($_POST['module_number']);
      $module_number   = strtolower($db->sanitizeEntry($_POST['module_number']));
      if ($module_number == ""){
        $transact= "The Module number MUST be filled!";
      }
      else
        {
        $sql = "SELECT moduleno, testno, hours, question, answer1, answer2, answer3, answer4, answer5, canswer,testid  FROM testtab WHERE moduleno = $module_number ORDER BY testno";
        $result = mysqli_query($db->conn, $sql);
        if(!$result)
            {
             $transact='Search Query Failed'.mysqli_error($db->conn);
        }
        else
             {
            //return number of rows
            $numOfReturnedRows = mysqli_num_rows($result);
            if($numOfReturnedRows <= 0)
                  {
                   $transact = 'No Test Record Matched your search';
            }
        }
      }
    }
    else{
        //$transact = $test->searchTestAll();
    }
}

//This line is essential because the function might return error in strings
if (gettype($transact) != "array") echo "<p style='color:red'> <strong> $transact </strong><p>";

?>


<?php 
      ?>

<div>
  <div>
    <form action = "<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method = "post" >
      <p>
    <!--    <input type="radio" name="searchrad" value="mod" checked="checked" class="w3-radio"/> -->
    Show Tests by Module Number:
        <input class="w3-input w3-border" type="text" placeholder="Enter Module Number" name="module_number" size="10" autofocus>
      </p>
      <p>
        <!---<input type="radio" name="searchrad" value="all" class="w3-radio"/> View All -->
      </p>
      <p><input type="Hidden" id="tracker" name="tracker" value="regxn"/></p>
      <button type="submit" name="searchbtn" class="w3-btn w3-medium w3-round-xxlarge w3-dark-grey w3-hover-light-grey" style="font-weight:900;">Search Test</button>
    </form>
  </div>
  <div>
    <h1>Tests' View</h1>
    <?php while ($row = @mysqli_fetch_array($result)) { ?>
    <table style="padding: 20px;  border:5px solid #73AD21; border-radius: 25px; width: 50%">
        <tr style="border-bottom: 1px solid #cbcbcb;">
          <td style="border: none; height: 30px; padding: 2px;"><strong>Module Number:</strong><br/><?php echo $row["moduleno"]?></td>
          <td><strong>Test Number:</strong><br/><?php echo $row["testno"]?></td>
          <td><strong>Time Required (in mins)</strong><br/><?php echo $row["hours"]?></td>
        </tr>
        <tr>
          <td colspan="3"><strong>Question:</strong><br/><?php echo ucfirst($row["question"])?></td>
        </tr>
        <tr>
          <td colspan="3"><strong>Options</strong></td>
        </tr>
        <tr>
          <td colspan="3">A: &nbsp;&nbsp;&nbsp; <?php echo $row["answer1"]?></td>
        </tr>
        <tr>
          <td colspan="3">B: &nbsp;&nbsp;&nbsp;<?php echo $row["answer2"]?></td>
        </tr>
        <tr>
          <td colspan="3">C: &nbsp;&nbsp;&nbsp;<?php echo $row["answer3"]?></td>
        </tr>
        <tr>
          <td colspan="3">D: &nbsp;&nbsp;&nbsp;<?php echo $row["answer4"]?></td>
        </tr>
        <tr>
          <td colspan="3">E: &nbsp;&nbsp;&nbsp;<?php echo $row["answer5"]?></td>
        </tr>
        <tr> 
          <td colspan="3"><strong>Correct Answer: &nbsp;&nbsp;&nbsp;<?php echo strtoupper($row["canswer"])?></strong></td>
        </tr>
          <td colspan="3"> 
            <a href="edit-test.php?testid=<?php echo $row["testid"]  ?>" style="   text-decoration: none;padding: 2px 5px; background: #2E8B57; color: white; border-radius: 3px;" >Edit</a>
            <a href="tests-view.php?testid=<?php echo $row["testid"]?>"  onclick="confirmp()" style="text-decoration: none;padding: 2px 5px; color: white; border-radius: 3px; background: #800000;">Delete</a>
          </td>
        </tr>
  </table><br />
  <?php } ?>
  </div>
 