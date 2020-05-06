<?php

class module{

	var $module_id;
	var $module_number;
  	var $module_topic;
  	var $learning_obj;
  	var $module_prerequisite;
  	var $hours;
  	var $module_category;
  	var $module_content;
	var $module_fileTempname;
  	var $module_filename;
	var $module_filetype;
	var $tempval;
	var $db ;
  	var $module_content_target_dir;
  	var $module_txt_file;
  	var $module_pdf_file;


function __construct() {
		require_once('accessdb.php');
		$this->db = new accessdb();
		if(!isset($_SESSION['STATUS'])) $_SESSION['STATUS'] = "";
}

function addModule($moduleno, $moduletopic, $obj, $prereq, $hours, $category, $content){
    $this->module_number        			= strtolower($this->db->sanitizeEntry($moduleno));
    $this->module_topic      				= $this->db->sanitizeEntry($moduletopic);
    $this->learning_obj         			= $this->db->sanitizeEntry($obj);
    $this->module_prerequisite  			= $this->db->sanitizeEntry($prereq);
    $this->hours                			= strtolower($this->db->sanitizeEntry($hours));
    $this->module_category      			= $category;
    $this->module_content       			= $content;
	$this->module_content_target_dir  		= "../module-content/";
	$this->module_filename 					= $_FILES["module_content_file"]["name"];		//store the file's name
	$this->module_filetype 					= $_FILES["module_content_file"]['type'];
	$this->module_fileTempname 				= $_FILES['module_content_file']['tmp_name'];

    if ($this->module_number == ""|| $this->module_topic == ""|| $this->learning_obj ==""||$this->module_prerequisite == ""|| $this->hours == ""|| $this->module_category =="select")
    	{
			return "<span class='pageInfoErr'>At least, one required field is not filled! </span>";
			//exit;
		}				//content is empty 
    else if ($this->module_content == ""){
      return "<span class='pageInfoErr'>The Content is missing! </span>";
      //exit;
    }								//content is NOT empty 
    else if ($this->module_content != "" )
    	{
		$sql = "START TRANSACTION";				//BEGIN TRANSACT
		$query = $this->db->query($sql);
		if (!$query){
			return "<span class='pageInfoErr'>Transaction can't be secured at this time</span>".mysqli_error($this->db->conn);
			//exit;
		}
		else{
			//1. Do database insertion
			$sql = 	"INSERT INTO moduletab (moduleid, moduleno, moduletopic, objective, prerequisite, hours, category)".
							"VALUES (NULL,'$this->module_number','$this->module_topic','$this->learning_obj',".
							"'$this->module_prerequisite','$this->hours','$this->module_category')";
			$query = $this->db->query_nonselect($sql);
			if ($query == 0){
				return "<span class='pageInfoErr'>no row(s) were effected! ". mysqli_error($this->db->conn).". Please Consult the Administrator</span>";
				//exit;
			}
			else if ($query == -1){
				return  "<span class='pageInfoErr'>There was a challenge experienced while trying to perform the task! ". mysqli_error($this->db->conn).". Please Consult the Administrator</span>";
				//exit;
			}
			else{		////After successful input At db, do file write
				$theFile = $this->module_content_target_dir.$this->module_number.".txt";
				if (!file_put_contents($theFile,$this->module_content)){
					$sql = "ROLLBACK";
					$query = $this->db->query($sql);
					return "<span class='pageInfoErr'>The Content cannot be created nor written to! </span>";
				} 
				//After successful file write, prepare for upload of resource file
				if (is_uploaded_file($this->module_fileTempname))
					{  //test for file type
					if ($this->module_filetype == 'application/pdf') $extension = 'pdf';
					else{
						return "<span class='pageInfoErr'>Sorry, only PDF files are allowed</span>";
					}//if file type conforms to pdf, do upload
					$newName = $this->module_number.".".$extension; 
					move_uploaded_file($this->module_fileTempname, $this->module_content_target_dir.$newName);
					$sql = "COMMIT";
					$query = $this->db->query($sql);
					return "<span class='pageInfoSuccess'>New Module added successfully</span>" ;
				}
			}	
		}
    }
}


function getModuleDetails($moduleno){
		$this->module_number  	= $this->db->sanitizeEntry($moduleno);
		$sql = "SELECT moduletopic, objective, prerequisite, hours, category FROM moduletab WHERE moduleno='$this->module_number'";
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
			$this->module_topic 				= $row[0];
			$this->learning_obj 				= $row[1];
			$this->module_prerequisite 	= $row[2];
			$this->hours 								= $row[3];
			$this->module_category 			= $row[4];
			return array ($this->module_topic,$this->learning_obj,$this->module_prerequisite,$this->hours,$this->module_category);
		}
	}


function searchForModule($module_number){
    $this->module_number   = strtolower($this->db->sanitizeEntry($module_number));

    if ($this->module_number == ""){
			return "The Module number MUST be filled!";
			//exit;
		}
    //1. Do database selection
		$this->sql = "SELECT moduleid, moduleno, moduletopic, objective, prerequisite, hours, category FROM moduletab WHERE moduleno = $this->module_number";

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
		             $this->state = 'No Module Record Matched your search';
		             return $this->state;
		             exit;
		      }
		      else{
		      		$fetched = mysqli_fetch_array($this->result);
		      		//Do file content read
		      		$fc = "../module-content/".$this->module_number.".txt";
		      		$file = @file_get_contents($fc);
		      		if(!$file) $file= "File cannot be read";
		      		$fetched[] = $file;
		      		return $fetched;
		      }
		}
}



function searchForModulebyId($module_id){
    $this->module_id   = strtolower($this->db->sanitizeEntry($module_id));

    if ($this->module_id == ""){
			return "The Module number MUST be filled!";
			//exit;
		}
    //1. Do database selection
		$this->sql = "SELECT moduleid, moduleno, moduletopic, objective, prerequisite, hours, category FROM moduletab WHERE moduleid = $this->module_id";

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
		             $this->state = 'No Module Record Matched your search';
		             return $this->state;
		             exit;
		      }
		      else{
		      		return mysqli_fetch_array($this->result);
		      }
		}
}

function delModule($moduleid){
    $this->module_id   = strtolower($this->db->sanitizeEntry($moduleid));
    if ($this->module_id == ""){
			return "The module id couldn't be retrieved!";
			exit;
		}
	else{//. Do database select to fetch moduleno which will be needed to delete the appropriate content file
		$this->sql = "SELECT moduleno FROM moduletab WHERE moduleid = $this->module_id";
		$this->result = mysqli_query($this->db->conn, $this->sql);
	    if(!$this->result)
	        {
	         $this->state='Query Error'.mysqli_error($this->db->conn);
	         return $this->state;
	    }
	    else
	         {
		      //return number of rows
		      $this->numOfReturnedRows = mysqli_num_rows($this->result);
		      if($this->numOfReturnedRows <= 0)
		            {
		             $this->state = 'Can\'t fetch module number for the supplied module id';
		             return $this->state;
		      }
		      else{
		      		$mod_no = mysqli_fetch_array($this->result);
			 		//1. Do database deletion
					$this->sql = "DELETE FROM moduletab WHERE moduleid = $this->module_id";
					$this->result = mysqli_query($this->db->conn, $this->sql);
				    if(!$this->result)
				        {
				         return 'Error deleting record: '.mysqli_error($this->db->conn);
				    }
					else{ //After module content on Database has been deleted, also delete the module content as well 
						$this->module_txt_file = "../module-content/".$mod_no[0].".txt";
						$this->module_pdf_file = "../module-content/".$mod_no[0].".pdf";
						@unlink($this->module_txt_file); //No need to test for success of the file deletion because even
						@unlink($this->module_pdf_file); //if it fails, the file will be overwritten when the module
														//is subsequently added  
					     return $this->result;   //It returns the result (TRUE) to the caller which is further used 
					     						//to test the condition of the caller in the interface code
					}

			  }
		}
	}
 }



  


function editModule($moduleid, $module_number, $module_topic, $learning_obj, $module_prerequisite, $hours, $module_cat, $module_content)
	{
    $this->module_id        			= strtolower($this->db->sanitizeEntry($moduleid));
    $this->module_number      			= strtolower($this->db->sanitizeEntry($module_number));
    $this->module_topic				    = strtolower($this->db->sanitizeEntry($module_topic));
    $this->learning_obj  				= strtolower($this->db->sanitizeEntry($learning_obj));
    $this->module_prerequisite          = strtolower($this->db->sanitizeEntry($module_prerequisite));
	$this->hours                		= strtolower($this->db->sanitizeEntry($hours));
	$this->module_category              = strtolower($this->db->sanitizeEntry($module_cat));
	$this->module_content               = strtolower($this->db->sanitizeEntry($module_content));
	$this->module_content_target_dir  	= "../module-content/"; 
	$this->module_filename 				= $_FILES["module_cont_file"]["name"];
	$this->module_filetype 				= $_FILES["module_cont_file"]['type'];
	$this->module_fileTempname 			= $_FILES['module_cont_file']['tmp_name'];
	if ($this->module_number == ""|| $this->module_topic == "" || $this->learning_obj ==""||$this->module_prerequisite == ""|| $this->hours == "" || $this->module_category =="select")
		{
		return "<span class='pageInfoErr'>At least, one required field is not filled! </span>";
	}	//content is empty 
	else if ($this->module_content == "")
		{
      	return "<span class='pageInfoErr'>The Content is missing! </span>";
    }		//content is not empty 
	else if ($this->module_content != "")
		{
		$sql = "START TRANSACTION";				//BEGIN TRANSACT
		$query = $this->db->query($sql);
		if (!$query){
			return "<span class='pageInfoErr'>Transaction can't be secured at this time</span>".mysqli_error($this->db->conn);
		}
		else{//1. Do database update
			$sql = "UPDATE moduletab SET moduleno=$this->module_number, moduletopic='$this->module_topic', objective='$this->learning_obj', prerequisite='$this->module_prerequisite', hours='$this->hours', category='$this->module_category' WHERE moduleid=$this->module_id";

			if (!$this->db->conn->query($sql)) 
				{
				$this->state = "<span class='pageInfoErr'>Error updating record: " . $this->db->conn->error."</span>";
				return $this->state;
			} 
			else{		////After successful input At db, do file write
				$theFile = $this->module_content_target_dir.$this->module_number.".txt";
				if (!file_put_contents($theFile,$this->module_content)){
					$sql = "ROLLBACK";
					$query = $this->db->query($sql);
					return "<span class='pageInfoErr'>The Content cannot be edited! </span>";
				} 
				//After successful file write, prepare for upload of resource file
				if (is_uploaded_file($this->module_fileTempname))
					{  //test for file type
					if ($this->module_filetype == 'application/pdf') $extension = 'pdf';
					else{
						return "<span class='pageInfoErr'>Sorry, only PDF files are allowed</span>";
					}//if file type conforms to pdf, do upload
					$newName = $this->module_number.".".$extension; 
					move_uploaded_file($this->module_fileTempname, $this->module_content_target_dir.$newName);
					$sql = "COMMIT";
					$query = $this->db->query($sql);
					return "<span class='pageInfoSuccess'>The Module was edited successfully</span>" ;
				}
			}	
		}				
  	}
}














}

?>