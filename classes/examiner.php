<?php

class examiner1{

	var $module_number;
	var $test_number;
  var $hours;
	var $userid;
	var $current_moduleno;
	var $db ;
  var $choice_answer_array = array();  //create an array for the choices selected
  var $test_number_array = array();   //for the test number of the individual question
  var $answer_array = array();
  var $remark_array = array();        //to house 'p'(for pass) or 'f' (for fail) depending on what the trainee chose
  var $number_passed  = "";
  var $number_failed  ="";
  var $score          ="";
  var $grade = '';
  var $remark = '';

function __construct() {
		require_once('accessdb.php');
		$this->db = new accessdb();
		if(!isset($_SESSION['STATUS'])) $_SESSION['STATUS'] = "";
}


function registerProgress($userid, $current_moduleno, $score, $grade, $remark){
	$this->userid  			= $this->db->sanitizeEntry($userid);
	$this->current_moduleno  		= $this->db->sanitizeEntry($current_moduleno);
	$this->score  					= $this->db->sanitizeEntry($score);
	$this->grade  			= $this->db->sanitizeEntry($grade);
	$this->remark = $this->db->sanitizeEntry($remark); 

	if ($this->userid == "" || $this->current_moduleno == "" || $this->score == ""|| $this->grade == "" || $this->remark == "" ){
		return "<span class='pageInfoErr'>At least, one required information is absent! </span>";
		//exit;
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
					//return array ($this->score,$this->remark );
          return header( 'Location: result.php?uid='.$this->userid.'curr_mod='.$this->current_moduleno );
			}
		}
}
 
function scoreAndGrade($rad1,$rad2,$rad3,$rad4,$rad5,$rad6,$rad7,$rad8,$rad9,$rad10,$test1,$test2,$test3,$test4,$test5,$test6,$test7,$test8,$test9,$test10,$ans1,$ans2,$ans3,$ans4,$ans5,$ans6,$ans7,$ans8,$ans9,$ans10,$curr_module,$num_questions,$userid)
  {
    //if user doesn't select answer, represent his answer with a space so that array not raise objection
    if($rad1 == "" || $rad2 == "" || $rad3 == "" || $rad4 == "" || $rad5 == ""||
       $rad6 == "" || $rad7 == "" || $rad8 == "" || $rad9 == "" || $rad10 == "")
      {
        return "<span class='pageInfoErr'>At least one question was not answered, please answer the question </span>";
        //exit;
      }

    //return all choices
      $this->choice_answer_array[0] = $rad1;
      $this->choice_answer_array[1] = $rad2;
      $this->choice_answer_array[2] = $rad3;
      $this->choice_answer_array[3] = $rad4;
      $this->choice_answer_array[4] = $rad5;
      $this->choice_answer_array[5] = $rad6;
      $this->choice_answer_array[6] = $rad7;
      $this->choice_answer_array[7] = $rad8;
      $this->choice_answer_array[8] = $rad9;
      $this->choice_answer_array[9] = $rad10;

      $this->test_number_array[0] = $test1;
      $this->test_number_array[1] = $test2;
      $this->test_number_array[2] = $test3;
      $this->test_number_array[3] = $test4;
      $this->test_number_array[4] = $test5;
      $this->test_number_array[5] = $test6;
      $this->test_number_array[6] = $test7;
      $this->test_number_array[7] = $test8;
      $this->test_number_array[8] = $test9;
      $this->test_number_array[9] = $test10;

      $this->answer_array[0] = $ans1;
      $this->answer_array[1] = $ans2;
      $this->answer_array[2] = $ans3;
      $this->answer_array[3] = $ans4;
      $this->answer_array[4] = $ans5;
      $this->answer_array[5] = $ans6;
      $this->answer_array[6] = $ans7;
      $this->answer_array[7] = $ans8;
      $this->answer_array[8] = $ans9;
      $this->answer_array[9] = $ans10;

      $this->curr_module = $curr_module;
  ////////////////////////////////////////////////////DO MARKING//////////////////////////////////////////////////////
      for ($i=0; $i<$num_questions; $i++)
      {  //do marking
        if($this->answer_array[$i] == $this->choice_answer_array[$i]) array_push($this->remark_array, 'p'); //if choice equals answer, record 'p'
        else array_push($this->remark_array, 'f');                                              //else record 'f'
      }
  /////////////////////////////////////////////////////DO SCORING/////////////////////////////////////////////////////
      $counts = array_count_values($this->remark_array);
      //only assign a value to $number_passed if $remark_array contains 'p'
      //so that php doesn't raise objection over non existence of p in array if no question was passed
      if (in_array("p",$this->remark_array)){
        $this->number_passed  = $counts['p'];
      }
      else $this->number_passed  = 0;
      //only assign a value to $number_failed if $remark_array contains 'f'
      //so that php doesn't raise objection over non existence of f in array if no question was failed
      if (in_array("f",$this->remark_array)){
        $this->number_failed  = $counts['f'];
      }
      $this->score          = ($this->number_passed/$num_questions)*100;

      ///////////////////////////////////////////////////////DO GRADING////////////////////////////////////////////////////////
      if ($this->score < 70){
        $this->grade = 'F';
        $this->remark = 'failed';
        }
      else if ($this->score>=70 && $this->score<=100){
        $this->grade = 'A';
        $this->remark = 'passed';
      }
      $this->registerProgress($userid, $curr_module, $this->score, $this->grade, $this->remark);
      //die( header( 'Location: result.php?uid='.$userid.'&curr_mod='.$curr_module ));
    }


    function fetchResult($userid, $current_moduleno){
    		$this->userid 	= $this->db->sanitizeEntry($userid);
    		$this->current_moduleno  	= $this->db->sanitizeEntry($current_moduleno);
    		$sql = "SELECT score, grade, remark FROM progresstab WHERE userid='$this->userid' AND moduleid = '$this->current_moduleno' ORDER BY progressid DESC LIMIT 1";
    		$query = $this->db->query($sql);
    		$numofrows = $this->db->num_rows($query);
    		$row = $this->db->fetch_rows($query);
    		if(!$query)
    			{
    			return "<span class='pageInfoErr'>'Oops! Your Progress Table request execution failed! ". mysqli_error($this->db->conn).". Please Consult the Administrator</span>";
    		}
    		else if ($numofrows == 0)
    			{
    			return "<span class='pageInfoErr'>Invalid Details from this user and module number!!! </span> ";
    		}
    		else {
    				$this->score	 = $row[0];
    			  $this->grade	 = $row[1];
    			  $this->remark  = $row[2];
    			return array ($this->score,$this->grade,$this->remark);
    		}
    	}


}
?>
