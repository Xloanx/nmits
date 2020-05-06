<?php


//require_once('accessdb.php');

class trainer{

	var $adminid;
	var $adminlevel;
  var $surname;
  var $firstname;
  var $dor;
  var $password;
	var $password_again;
	var $oldpwd;
	var $newpwd;
	var $newpwd_again;
	var $harshed;
  var $email;
	var $phone1;
	var $role;
	var $tempval;
	var $db ;
	var $sql;


	function __construct() {
		require_once('accessdb.php');
		$this->db = new accessdb();
		if(!isset($_SESSION['STATUS'])) $_SESSION['STATUS'] = "";
    }


	function signup($surname,$firstname,$dor,$password,$password_again,$email,$phone1){

		$this->surname  = strtolower($this->db->sanitizeEntry($surname));
		$this->firstname  = strtolower($this->db->sanitizeEntry($firstname));
		$this->dor  = $this->db->sanitizeEntry($dor);
		$this->password  = md5("mYkEy".$this->db->sanitizeEntry($password)."MyDoOr");
		$this->password_again  = md5("mYkEy".$this->db->sanitizeEntry($password_again)."MyDoOr");
		$this->email  = strtolower($this->db->sanitizeEntry($email));
		$this->phone1  = $this->db->sanitizeEntry($phone1);
		$this->role = "trainer";
		if ($this->surname == "" || $this->firstname == "" || $this->dor == ""|| $this->password_again == "" || $this->email == "" ||$this->phone1 == ""){
			$err = "<span class='pageInfoErr'>At least, one required field is not filled! </span>";
			return $err;
			exit;
		}
		else if($this->password != $this->password_again ){
			$err = "<span class='pageInfoErr'>The Passwords do not match </span>";
			return $err;
			exit;
		}
		else if (!((strpos($this->email, ".") > 0) && (strpos($this->email, "@") > 0)) || preg_match("/[^a-zA-Z0-9.@_-]/", $this->email)){
			$err = "<span class='pageInfoErr'>The Email is invalid </span>";
			return $err;
			exit;
		}
		else{
			$sql = "INSERT INTO usertab (userid,surname,firstname,dateofreg,phone,password,role,category,email)".
					"VALUES (NULL,'$this->surname','$this->firstname','$this->dor','$this->phone1','$this->password','$this->role',NULL,'$this->email')";
			$query = $this->db->query_nonselect($sql);
			if ($query == 0){
				return "<span class='pageInfoErr'>no rows were found! ". mysqli_error($this->db->conn).". Please Consult the Administrator</span>";
			}
			else if ($query == -1){
				return  "<span class='pageInfoErr'>There was a challenge experienced while trying to perform the task! ". mysqli_error($this->db->conn).". Please Consult the Administrator</span>";
			}
			else{
					$query = $this->db->query($sql);
					return "<span class='pageInfoSuccess'>Registration Successful! Click <a href='signin.php'>here</a> to sign in</span>" ;
				}
			}
		}


	function signin($email,$password,$role){

		$this->email  	= strtolower($this->db->sanitizeEntry($email));
		$this->harshed  = md5("mYkEy".$this->db->sanitizeEntry($password)."MyDoOr");
		$this->role			= $role;
		if ($this->email == ""|| $this->harshed == "" || $this->role =="select"){
			return "<span class='pageInfoErr'>At least, one required field is not filled! </span>";
			exit;
		}
		else if (!((strpos($this->email, ".") > 0) && (strpos($this->email, "@") > 0)) || preg_match("/[^a-zA-Z0-9.@_-]/", $this->email)){
			return "<span class='pageInfoErr'>The Email is invalid </span>";
			exit;
		}
		else if ($this->role == "trainee"){
			exit;
		}
		else{
			$sql = "SELECT * FROM usertab WHERE email='$this->email' AND role='trainer'";
			$query = $this->db->query($sql);
			$numofrows = $this->db->num_rows($query);
			$row = $this->db->fetch_rows($query);
			if(!$query)
				{
				return "<span class='pageInfoErr'>'Oops! Your request execution failed! ". mysqli_error($this->db->conn).". Please Consult the Administrator</span>";
      }
			else if ($numofrows == 0)
				{
				return "<span class='pageInfoErr'>Invalid Details!!! </span> ";
			}
			else if($this->harshed != $row[6])
				{
				return "<span class='pageInfoErr'>Wrong Combination!!! </span> ";
			}
			else if ($this->harshed == $row[6]){  //IF THE PASSWORD IS CORRECT, LOG THE ENTRY
/*				$sql = "INSERT INTO loginstamptab (loginid,userid,logintime,dateofreg,phone,password,role,category,email)".
						"VALUES (NULL,'$this->surname','$this->firstname','$this->dor','$this->phone1','$this->password','$this->role',NULL,'$this->email')";
				$query = $this->db->query_nonselect($sql);
				if ($query == 0){
					return "<span class='pageInfoErr'>no rows were found! ". mysqli_error($this->db->conn).". Please Consult the Administrator</span>";
					exit;
				}
				else if ($query == -1){
					return  "<span class='pageInfoErr'>There was a challenge experienced while trying to perform the task! ". mysqli_error($this->db->conn).". Please Consult the Administrator</span>";
				}
				else{
						$query = $this->db->query($sql);
						return "<span class='pageInfoSuccess'>Registration Successful! Click <a href='signin.php'>here</a> to sign in</span>" ;
*/					}
				$_SESSION['userid'] 		= $row[0];
				$_SESSION['surname'] 		= $row[1];
				$_SESSION['firstname'] 	= $row[2];
				$_SESSION['dor'] 				= $row[3];
				$_SESSION['phone'] 			= $row[4];
				$_SESSION['role']			= "trainer";
				$_SESSION['email'] 		= $this->email;
				$_SESSION['STATUS'] = TRUE;
				die( header( 'Location: trainer/trainer-main-page.php' ));
			}
		}



function changePwd($pwd1,$pwd2,$pwd3){

		$this->oldpwd  = md5("mYkEy".$this->db->sanitizeEntry($pwd1)."MyDoOr");
		$this->newpwd  = md5("mYkEy".$this->db->sanitizeEntry($pwd2)."MyDoOr");
		$this->newpwd_again  = md5("mYkEy".$this->db->sanitizeEntry($pwd3)."MyDoOr");
		$this->email = $_SESSION['email'];

		if ($this->oldpwd == ""|| $this->newpwd == "" || $this->newpwd_again ==""){
			return "<span class='pageInfoErr'>At least, one required field is not filled! </span>";
			exit;
		}
		else if ($this->oldpwd == $this->newpwd){
			return "<span class='pageInfoErr'>The old password MUST NOT be same as the new password! </span>";
			exit;
		}
		else if ($this->newpwd != $this->newpwd_again){
			return "<span class='pageInfoErr'>The new password must be entered twice! </span>";
			exit;
		}
		else{
			$sql = "SELECT password FROM usertab WHERE email='$this->email'";
			$query = $this->db->query($sql);
			$numofrows = $this->db->num_rows($query);
			$row = $this->db->fetch_rows($query);
			if(!$query)
				{
				return "<span class='pageInfoErr'>'Oops! Your request execution failed! ". mysqli_error($this->db->conn).". Please Consult the Administrator</span>";
      		}
			else if ($numofrows == 0)
				{
				return "<span class='pageInfoErr'>Invalid Details!!! </span> ";
			}
			else if($this->oldpwd != $row[0])
				{
				return "<span class='pageInfoErr'>Your Password is incorrect!!! </span> ";
			}
			else if ($this->oldpwd == $row[0])
				{  //IF THE PASSWORD IS CORRECT,  DO UPDATE
				$this->sql = "UPDATE usertab SET password = '$this->newpwd' WHERE email = '$this->email'";
				$query = $this->db->query($this->sql);
				$non_select = $this->db->query_nonselect($query); // returns > 0 indicates the number of rows affected.
				if(!$query)
					{
					return "<span class='pageInfoErr'>'Oops! Your request execution failed! ". mysqli_error($this->db->conn).". Please Consult the Administrator</span>";
	      		}
				if ($this->db->conn->query($this->sql) === TRUE) 
						{
					    return "Your Password was edited successfully";
				}
				else 
					{
				    return "Error changing password: " . $conn->error;
				}

			}
		}
}




function editOwnDetail($surname, $firstname, $email, $phone1){
    $this->surname        			= strtolower($this->db->sanitizeEntry($surname));
    $this->firstname      			= strtolower($this->db->sanitizeEntry($firstname));
    $this->email			        = strtolower($this->db->sanitizeEntry($email));
    $this->phone1  					= strtolower($this->db->sanitizeEntry($phone1));

    if (	$this->surname == ""|| $this->firstname == "" || $this->phone1 == ""	)
    		{
			return "<span class='pageInfoErr'>At least, one required field is not filled! </span>";
			//exit;
		}				
    //1. Do database update
		$this->sql ="UPDATE usertab SET surname='$this->surname', firstname='$this->firstname', phone='$this->phone1' WHERE email='$this->email'";

		if ($this->db->conn->query($this->sql) === TRUE) 
				{
			    return "<span class='pageInfoSuccess'>Your details were updated successfully</span>";
			} 
		else 
				{
			    return "<span class='pageInfoErr'>Error updating your details: " . $this->db->conn->error."</span>";
			}
 }


}











?>
