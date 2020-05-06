<?php
 
class test{ 

	var $module_number;
	var $test_number;
	var $db_test_id;
  var $hours;
	var $userid;
	var $current_moduleno;
	var $score;
	var $grade;
	var $remark;
  var $question;
  var $option_1;
	var $option_2;
  var $option_3;
	var $option_4;
	var $option_5;
	var $correct_option;
	var $test_count;
	var $number_of_questions= 10;												//number of questions trainees will be exposed to per module test
	var $period_of_test = 50*60;
	var $max_number_of_available_questions = "";            //the maximum number of available questions in the DB for each module
	var $test_number_array = array();    ////create the array that will contain the random test numbers
	var $sql;
	var $query;
	var $result;
	var $state;
	var $numOfReturnedRows;
	var $db ;



function __construct() {
		require_once('accessdb.php');
		$this->db = new accessdb();
		if(!isset($_SESSION['STATUS'])) $_SESSION['STATUS'] = "";
}

function addTest($module_number, $test_number, $hours, $question, $option_1, $option_2, $option_3, $option_4, $option_5, $correct_option){
    $this->module_number        		= strtolower($this->db->sanitizeEntry($module_number));
    $this->test_number      			= strtolower($this->db->sanitizeEntry($test_number));
    $this->hours				        = strtolower($this->db->sanitizeEntry($hours));
    $this->question  					= $question;
    $this->option_1                		= strtolower($this->db->sanitizeEntry($option_1));
	$this->option_2                		= strtolower($this->db->sanitizeEntry($option_2));
	$this->option_3                		= strtolower($this->db->sanitizeEntry($option_3));
	$this->option_4                		= strtolower($this->db->sanitizeEntry($option_4));
	$this->option_5                		= strtolower($this->db->sanitizeEntry($option_5));
    $this->correct_option      			= $correct_option;

    if (	$this->module_number == ""	|| $this->test_number == "" || $this->hours ==""
				||$this->question == ""	|| $this->option_1 == "" 	|| $this->option_2 == ""
				||$this->option_3 == ""	|| $this->option_4 == ""	|| $this->option_5 == ""
				||$this->correct_option =="select")
    		{
			return "<span class='pageInfoErr'>At least, one required field is not filled! </span>";
			exit;
		}				//content is empty AND NO uploaded file
    //1. Do database insertion
		$this->sql = 	"INSERT INTO testtab (testid, moduleno, testno, hours, question, answer1, answer2, answer3, answer4, answer5, canswer)".
						"VALUES (NULL,'$this->module_number','$this->test_number','$this->hours','$this->question'".
						",'$this->option_1','$this->option_2','$this->option_3','$this->option_4','$this->option_5','$this->correct_option')";
		$this->query = $this->db->query_nonselect($this->sql);
		if ($this->query == 0){
			return "<span class='pageInfoErr'>no row(s) were effected! ". mysqli_error($this->db->conn).". Please Consult the Administrator</span>";
			exit;
		}
		else if ($this->query == -1){
			return  "<span class='pageInfoErr'>There was a challenge experienced while trying to perform the task! ". mysqli_error($this->db->conn).". Please Consult the Administrator</span>";
			exit;
		}
		else{
				$this->query = $this->db->query($this->sql);
				return "<span class='pageInfoSuccess'>Test added successfully! </span>" ;
		}
 }


function searchTestForEdit($module_number, $test_number){
    $this->module_number   = strtolower($this->db->sanitizeEntry($module_number));
    $this->test_number     = strtolower($this->db->sanitizeEntry($test_number));


    if (	$this->module_number == ""|| $this->test_number == ""){
			return "<span class='pageInfoErr'>At least, one required field is not filled! </span>";
			exit;
		}
    //1. Do database selection
		$this->sql = 	"SELECT hours, question, answer1, answer2, answer3, answer4, answer5, testno, moduleno FROM testtab WHERE moduleno = $this->module_number AND testno = $this->test_number";

		$this->result = mysqli_query($this->db->conn, $this->sql);
	    if(!$this->result)
	        {
	         $this->state='Search Query Failed'.mysqli_error($this->db->conn);
	         return $this->state;
	    }
	    else
	         {
		      //return number of rows
		      $this->numOfReturnedRows = mysqli_num_rows($this->result);
		      if($this->numOfReturnedRows <= 0)
		            {
		             $this->state = 'No Test Record Matched your search';
		             return $this->state;
		      }
		      else{
		      	 	return mysqli_fetch_row($this->result);
		      }
	    }
	    //mysql_close($this->db);
 }

function searchTestForEditbytid($testid){
    $this->db_test_id   = strtolower($this->db->sanitizeEntry($testid));
    if ($this->db_test_id == ""){
			return "The test id couldn't be retrieved!";
			exit;
		}
    //1. Do database selection
		$this->sql = 	"SELECT hours, question, answer1, answer2, answer3, answer4, answer5, testno, moduleno FROM testtab WHERE testid = $this->db_test_id";

		$this->result = mysqli_query($this->db->conn, $this->sql);
	    if(!$this->result)
	        {
	         $this->state='Search Query Failed'.mysqli_error($this->db->conn);
	         return $this->state;
	    }
	    else
	         {
		      //return number of rows
		      $this->numOfReturnedRows = mysqli_num_rows($this->result);
		      if($this->numOfReturnedRows <= 0)
		            {
		             $this->state = 'No Test Record Matched your search';
		             return $this->state;
		      }
		      else{
		      	 	return mysqli_fetch_row($this->result);
		      }
	    }
	    //mysql_close($this->db);
 }

function editTest($module_number, $test_number, $hours, $question, $option_1, $option_2, $option_3, $option_4, $option_5, $correct_option){
    $this->module_number        		= strtolower($this->db->sanitizeEntry($module_number));
    $this->test_number      			= strtolower($this->db->sanitizeEntry($test_number));
    $this->hours				        = strtolower($this->db->sanitizeEntry($hours));
    $this->question  					= strtolower($this->db->sanitizeEntry($question));
    $this->option_1                		= strtolower($this->db->sanitizeEntry($option_1));
	$this->option_2                		= strtolower($this->db->sanitizeEntry($option_2));
	$this->option_3                		= strtolower($this->db->sanitizeEntry($option_3));
	$this->option_4                		= strtolower($this->db->sanitizeEntry($option_4));
	$this->option_5                		= strtolower($this->db->sanitizeEntry($option_5));
    $this->correct_option      			= $correct_option;

    if (	$this->module_number == ""	|| $this->test_number == "" || $this->hours ==""
				||$this->question == ""	|| $this->option_1 == "" 	|| $this->option_2 == ""
				||$this->option_3 == ""	|| $this->option_4 == ""	|| $this->option_5 == ""
				||$this->correct_option =="select")
    		{
			return "<span class='pageInfoErr'>At least, one required field is not filled! </span>";
			//exit;
		}				
    //1. Do database update
		$this->sql ="UPDATE testtab SET hours=$this->hours, question='$this->question',answer1='$this->option_1', answer2='$this->option_2', answer3='$this->option_3',answer4='$this->option_4', answer5='$this->option_5', canswer='$this->correct_option' WHERE moduleno=$this->module_number AND testno=$this->test_number";

		if ($this->db->conn->query($this->sql) === TRUE) 
				{
			    $this->state = "<span class='pageInfoSuccess'>Test Record updated successfully</span>";
			    return $this->state;
			} 
		else 
				{
			    $this->state = "<span class='pageInfoErr'>Error updating record: " . $this->db->conn->error."</span>";
			    return $this->state;
			}
 }


function delTest($module_number, $test_number){
    $this->module_number   = strtolower($this->db->sanitizeEntry($module_number));
    $this->test_number     = strtolower($this->db->sanitizeEntry($test_number));


    if (	$this->module_number == ""|| $this->test_number == ""){
			return "<span class='pageInfoErr'>At least, one required field is not filled! </span>";
			exit;
		}
    //1. Do database deletion
		$this->sql = 	"DELETE FROM testtab WHERE moduleno = $this->module_number AND testno = $this->test_number";

		$this->result = mysqli_query($this->db->conn, $this->sql);
	    if(!$this->result)
	        {
	         return 'Error deleting record: '.mysqli_error($this->db->conn);
	    }
		else{
		     return "Record deleted successfully";
		}
}

function delTestbytid($testid){
    $this->db_test_id   = strtolower($this->db->sanitizeEntry($testid));
    if ($this->db_test_id == ""){
			return "The test id couldn't be retrieved!";
			exit;
		} 
    //1. Do database deletion
		$this->sql = "DELETE FROM testtab WHERE testid = $this->db_test_id";

		$this->result = mysqli_query($this->db->conn, $this->sql);
	    if(!$this->result)
	        {
	         return 'Error deleting record: '.mysqli_error($this->db->conn);
	    }
		else{
		     return $this->result;
		}
 }





function getAvailableTestCount($moduleno){  //this function gets the count of the available number of questions in the test table
																	//the importance of this function is that it helps the caller have an idea of the upper Limit
																	//for random generation. testing.php calls this function
				$this->module_number  	= $this->db->sanitizeEntry($moduleno);
				$sql = "SELECT COUNT(*) FROM testtab WHERE moduleno='$this->module_number'";
				$query = $this->db->query($sql);
				$numofrows = $this->db->num_rows($query);
				$row = $this->db->fetch_rows($query);
				if(!$query)
					{
					return "<span class='pageInfoErr'>'Oops! Your request execution failed! ". mysqli_error($this->db->conn).". Please Consult the Administrator</span>";
				}
				else if ($numofrows == 0)
					{
					return "<span class='pageInfoErr'>Invalid Details from this module number!!! </span> ";
				}
				else {
					$this->test_count 				= $row[0];
					return $this->test_count;
				}
}

function getTestDetails($moduleno, $test_number){
		$this->module_number  	= $this->db->sanitizeEntry($moduleno);
		$this->test_number  	= $this->db->sanitizeEntry($test_number);
		$sql = "SELECT hours, question, answer1, answer2, answer3, answer4, answer5, canswer,testno FROM testtab WHERE moduleno='$this->module_number' AND testno = '$this->test_number'";
		$query = $this->db->query($sql);
		$numofrows = $this->db->num_rows($query);
		$row = $this->db->fetch_rows($query);
		if(!$query)
			{
			return "<span class='pageInfoErr'>'Oops! Your Test Table request execution failed! ". mysqli_error($this->db->conn).". Please Consult the Administrator</span>";
		}
		else if ($numofrows == 0)
			{
			return "<span class='pageInfoErr'>Invalid Details from this module and test number!!! </span> ";
		}
		else {
				$this->hours	= $row[0];
			  $this->question	= $row[1];
			  $this->option_1	= $row[2];
				$this->option_2	= $row[3];
			  $this->option_3	= $row[4];
				$this->option_4	= $row[5];
				$this->option_5	= $row[6];
				$this->correct_option	= $row[7];
			return array ($this->hours,$this->question,$this->option_1,$this->option_2,$this->option_3,$this->option_4,$this->option_5,$this->correct_option);
		}
	}
/*
function testDisplay($test_number, $testnum, $test_details, $displayed_test_number)
	{
echo<<<_content1
	  <!---<div id="test" class="test"> --->
	      <div id="$testnum" class="testclass">
	          <p><h3 class='w3-right'><b>TIME LEFT:  $test_details[0]*60</b></h3></p><br/>
	          <p><h3 ><b>QUESTION $displayed_test_number</b></h3></p>
	          <p><h3 ><b>$test_details[1]</b></h3></p>
_content1;
?>
	       <form action = "testing.php" method = "post">
<?php
echo<<<_content2
	          <p><label class="container">$test_details[2]<input type="radio" name="$test_details[1]" class="w3-left" value="a"><span class="checkmark"></span></label></p>
	          <p><label class="container">$test_details[3]<input type="radio" name="$test_details[1]" class="w3-left" value="b"><span class="checkmark"></span></label></p>
	          <p><label class="container">$test_details[4]<input type="radio" name="$test_details[1]" class="w3-left" value="c"><span class="checkmark"></span></label></p>
	          <p><label class="container">$test_details[5]<input type="radio" name="$test_details[1]" class="w3-left" value="d"><span class="checkmark"></span></label></p>
	          <p><label class="container">$test_details[6]<input type="radio" name="$test_details[1]" class="w3-left" value="e"><span class="checkmark"></span></label></p>
	          <p><input type="Hidden" id="test_num" name="test_num" value="$test_number"/></p>
						<button type='submit' id='nextbutton' name='nextbutton' class='w3-btn w3-large w3-dark-grey w3-hover-light-grey' style='font-weight:900;' >Next >>></button>
	        </form>
	    </div>
_content2;
}
*/
function registerProgress($userid, $current_moduleno, $score, $grade, $remark){
	$this->userid  			= $this->db->sanitizeEntry($userid);
	$this->current_moduleno  		= $this->db->sanitizeEntry($current_moduleno);
	$this->score  					= $this->db->sanitizeEntry($score);
	$this->grade  			= $this->db->sanitizeEntry($grade);
	$this->remark = $this->db->sanitizeEntry($remark);

	if ($this->userid == "" || $this->current_moduleno == "" || $this->score == ""|| $this->grade == "" || $this->remark == "" ){
		return "<span class='pageInfoErr'>At least, one required information is absent! </span>";
		exit;
	}
	else{
		$sql = "INSERT INTO progresstab (progressid,userid,moduleid,score,grade,remark,timing)".
				"VALUES (NULL,'$this->userid','$this->current_moduleno','$this->score','$this->grade','$this->remark',now())";
		$query = $this->db->query_nonselect($sql);
		if ($query == 0){
			return "<span class='pageInfoErr'>No record was effected! ". mysqli_error($this->db->conn)."</span>";
		}
		else if ($query == -1){
			return  "<span class='pageInfoErr'>There was a challenge experienced while trying register progress! ". mysqli_error($this->db->conn).". Please Consult the Administrator</span>";
		}
		else{
				$query = $this->db->query($sql);
				//return "<span class='pageInfoSuccess'>Your Test Score is :"."$this->score"."  You have ".$this->remark." this module. Your performance have been registered.</span>" ;
					return array ($this->score,$this->remark );
			}
		}
}





	function searchTest($module_number){
    $this->module_number   = strtolower($this->db->sanitizeEntry($module_number));

    if ($this->module_number == ""){
			return "The Module number MUST be filled!";
			//exit;
		}
    //1. Do database selection
		$this->sql = "SELECT moduleno, testno, hours, question, answer1, answer2, answer3, answer4, answer5, canswer,testid  FROM testtab WHERE moduleno = $this->module_number";

		$this->result = mysqli_query($this->db->conn, $this->sql);
	    if(!$this->result)
	        {
	         $this->state='Search Query Failed'.mysqli_error($this->db->conn);
	         return $this->state;
	    }
	    else
	         {
		      //return number of rows
		      $this->numOfReturnedRows = mysqli_num_rows($this->result);
		      if($this->numOfReturnedRows <= 0)
		            {
		             $this->state = 'No Test Record Matched your search';
		             return $this->state;
		             exit;
		      }
		      else{
		      		for ($j = 0 ; $j < $this->numOfReturnedRows ; ++$j)
						{
			      		return mysqli_fetch_row($this->result);
		      		}
		      		
		      }
	    }
	    //mysql_close($this->db);
 }

 	
}
?>
