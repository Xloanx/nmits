<?php


//require_once('accessdb.php');

class trainee{

	var $userid;
  var $surname;
  var $firstname;
  var $dor;
	var $phone1;
  var $password;
	var $password_again;
	var $role;
	var $category;
  var $email;
	var $harshed;
	var $db ;


	function __construct() {
		require_once('accessdb.php');
		$this->db = new accessdb();
		if(!isset($_SESSION['STATUS'])) $_SESSION['STATUS'] = "";
    }


	function signup($surname,$firstname,$dor,$password,$password_again,$email,$phone1,$category){

		$this->surname  			= strtolower($this->db->sanitizeEntry($surname));
		$this->firstname  		= strtolower($this->db->sanitizeEntry($firstname));
		$this->dor  					= $this->db->sanitizeEntry($dor);
		$this->password  			= md5("mYkEy".$this->db->sanitizeEntry($password)."MyDoOr");
		$this->password_again = md5("mYkEy".$this->db->sanitizeEntry($password_again)."MyDoOr");
		$this->email  				= strtolower($this->db->sanitizeEntry($email));
		$this->phone1  				= $this->db->sanitizeEntry($phone1);
		$this->role 					= "trainee";
		$this->category				= $category;
		if ($this->surname == "" || $this->firstname == "" || $this->dor == ""|| $this->password == "" || $this->password_again == "" || $this->email == "" ||$this->phone1 == ""||$this->category == "select"){
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
					"VALUES (NULL,'$this->surname','$this->firstname','$this->dor','$this->phone1','$this->password','$this->role','$this->category','$this->email')";
			$query = $this->db->query_nonselect($sql);
			if ($query == 0){
				return "<span class='pageInfoErr'>no rows were found! ". mysqli_error($this->db->conn).". Please Consult the Administrator</span>";
			}
			else if ($query == -1){
				return  "<span class='pageInfoErr'>There was a challenge experienced while trying to perform the task! ". mysqli_error($this->db->conn).". Please Consult the Administrator</span>";
			}
			else{
					$query = $this->db->query($sql);
					$nonerr = "<span class='pageInfoSuccess'>Registration Successful! Click <a href='signin.php'>here</a> to sign in</span>" ;
					return $nonerr;
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
		else{  //confirm if the user exists with the supplied credential
			$sql = "SELECT * FROM usertab WHERE email='$this->email' AND role='trainee'";
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
			else if ($this->harshed == $row[6]){ //if the user thus exist with supplied accurate information, fetch session details
				$_SESSION['userid'] 		= $this->userid = $row[0];
				$_SESSION['surname'] 		= $row[1];
				$_SESSION['firstname'] 	= $row[2];
				$_SESSION['dor'] 				= $row[3];
				$_SESSION['phone'] 			= $row[4];
				$_SESSION['role']			= "trainee";
				$_SESSION['email'] 		= $this->email;
				$_SESSION['category'] 			= $row[8];
				$_SESSION['STATUS'] = TRUE;
				//check the progresstab to confirm his last passed module for correct module presentation
				$sql = "SELECT moduleid, remark FROM progresstab WHERE userid='$this->userid' ORDER BY moduleid DESC LIMIT 1";
				$query = $this->db->query($sql);
				$numofrows = $this->db->num_rows($query);
				$row = $this->db->fetch_rows($query);
				if(!$query)  //for one reason or the other, query failed
					{
					return "<span class='pageInfoErr'>'Oops! We couldn't connect to progress table! ". mysqli_error($this->db->conn).". Please Consult the Administrator</span>";
	      }
				else if ($numofrows == 0){  //no record found on progresstab so start from module 1
					$max_moduleno = 1;
				}
				else if ($numofrows == 1){     //if a record is returned, process it
					$last_moduleno = $row[0];
					$last_remark	= $row[1];
					if ($last_remark == "passed") $max_moduleno = $last_moduleno+1;   //if the trainee passed the last module's test let him access the next
					else if ($last_remark == "failed") $max_moduleno = $last_moduleno;  //if he fails he needs to re-attempt the failed module until it's passed
				}
				$_SESSION['maxmodule'] = $max_moduleno;
		/*		if ($current_moduleno)	$_SESSION['module'] = $current_moduleno;   //this tells the module which the trainee can access up to
				else $_SESSION['module'] = 1;					//if for any reason $current_moduleno has no value take user to module 1*/
				die( header( 'Location: trainee/trainee-main-page.php' ));
			}
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
				$sql = "UPDATE usertab SET password = '$this->newpwd' WHERE email = '$this->email'";
				$query = $this->db->query($sql);
				//$numofrows = $this->db->num_rows($query);   //returns number of rows
			//	$row = $this->db->fetch_rows($query);				//returns array of strings
				$non_select = $this->db->query_nonselect($query); // returns > 0 indicates the number of rows affected.
																														// 0 indicates that no records were affected.
																																//-1 indicates that the query returned an error
				if(!$query)
					{
					return "<span class='pageInfoErr'>'Oops! Your request execution failed! ". mysqli_error($this->db->conn).". Please Consult the Administrator</span>";
	      }
				else if ($non_select == 0)
					{
					return "<span class='pageInfoErr'>Invalid Update!!! </span> ";
				}
				else if($non_select > 0)
					{
					return "<span class='pageInfoSuccess'>Your Password was edited successfully!!! </span> ";
				}
			}
		}


	function subFuncForViews($sql, $returnedField){
		$query = $this->db->query($sql);
			$numOfRows = $this->db->num_rows($query);
			if(!$query) return "<span class='pageInfoErr'>Query cannot be executed!!". mysqli_error($this->db->conn).". Please Consult the Administrator</span>";
			else{
				if ($numOfRows == 0)
					{
					return "<span class='pageInfoErr'>No Data to display!!! </span> ";
				}
				else{
					$colNumber = $returnedField; //NUMBER OF RETURNED FIELDS. BEWARE OF ANY CHANGE!!!!
					echo "</tr>";
					for ($j = 1 ; $j <= $numOfRows ; ++$j)
						{
						$individualRow = $this->db->fetch_rows($query);
						if($j%2==0)echo "<tr height='20' bgcolor='#f0f0f0'>";
						else echo "<tr height='20'> ";
						for ($k = 0 ; $k < $colNumber ; ++$k)
							{
							echo"<td id='fetcheddata' align='left' class='tabledatas'>$individualRow[$k]</td>";
						}
						echo "</tr>";
					}
					echo "<table>";
				}
			}


	}

	function viewOrders($searchValue, $searchField){
		if($searchValue == "" && $searchField == 'all'){
			$sql = "SELECT orderid AS 'Order ID' ,Custid AS 'Customer ID',payingcard AS 'Paying Card',cuisineid AS 'Cuisine ID',orderQty AS 'Order Quantity',orderprice AS 'Order Price',timeoforder AS 'Time of Order',intended_delivertime AS 'Intended Time of Delivery',orderstatus AS 'Order Status',deliverytype AS 'Delivery Type',deliverystatus AS 'Delivery Status' FROM ordering_tbl";
			$this->subFuncForViews($sql, 11);
		}
		else if($searchValue =="" && $searchField != 'all'){
			return "<span class='pageInfoErr'>Invalid Search Parameters!!! </span> ";
		}
		else if ($searchValue !="" && $searchField != 'all'){
			//return "<span class='pageInfoErr'> You Entered ".$searchField."&".$searchValue."</span> ";
			$sql = "SELECT orderid AS 'Order ID' ,Custid AS 'Customer ID',payingcard AS 'Paying Card',cuisineid AS 'Cuisine ID',orderQty AS 'Order Quantity',orderprice AS 'Order Price',timeoforder AS 'Time of Order',intended_delivertime AS 'Intended Time of Delivery',orderstatus AS 'Order Status',deliverytype AS 'Delivery Type',deliverystatus AS 'Delivery Status' FROM ordering_tbl WHERE $searchField ='$searchValue'";
			$this->subFuncForViews($sql, 11);
		}
	}


	function viewCusts($searchValue, $searchField){
		if ($searchValue == "" && $searchField == 'all'){
			$sql = "SELECT custid AS 'Customer ID' ,lname AS 'Last Name',fname AS 'First Name',mname AS 'Middle Name',email AS 'Email Address',phone1 AS 'Phone',addr AS 'Residential Address' FROM cust_tbl ";
			$this->subFuncForViews($sql, 7);
		}
		else if($searchValue =="" && $searchField != 'all'){
			return "<span class='pageInfoErr'>Invalid Search Parameters!!! </span> ";
		}
		else if ($searchValue !="" && $searchField != 'all'){
			//return "<span class='pageInfoErr'> You Entered ".$searchField."&".$searchValue."</span> ";
			$sql = "SELECT custid AS 'Customer ID' ,lname AS 'Last Name',fname AS 'First Name',mname AS 'Middle Name',email AS 'Email Address',phone1 AS 'Phone',addr AS 'Residential Address' FROM cust_tbl WHERE $searchField ='$searchValue'";
			$this->subFuncForViews($sql, 7);
		}
	}


	function viewCuisines($searchValue, $searchField){
		if ($searchValue == "" && $searchField == 'all'){
			$sql = "SELECT cuisineid AS 'Cuisine ID' ,cuisinetype AS 'Cuisine Type',cuisinename AS 'Cuisine Name',cuisinedescrip AS 'Cuisine Description',cuisineprice AS 'Cuisine Price' FROM cuisine_tbl ";
			$this->subFuncForViews($sql, 5);
		}
		else if($searchValue =="" && $searchField != 'all'){
			return "<span class='pageInfoErr'>Invalid Search Parameters!!! </span> ";
		}
		else if ($searchValue !="" && $searchField != 'all'){
			//return "<span class='pageInfoErr'> You Entered ".$searchField."&".$searchValue."</span> ";
			$sql = "SELECT cuisineid AS 'Cuisine ID' ,cuisinetype AS 'Cuisine Type',cuisinename AS 'Cuisine Name',cuisinedescrip AS 'Cuisine Description',cuisineprice AS 'Cuisine Price' FROM cuisine_tbl WHERE $searchField ='$searchValue'";
			$this->subFuncForViews($sql, 5);
		}
	}


	function viewCards($searchValue, $searchField){
		if ($searchValue == "" && $searchField == 'all'){
			$sql = "SELECT cardid AS 'Card ID' ,custid AS 'Customer ID',ctype AS 'Card Type',cnum AS 'Card Number',cname AS 'Name on Card',cvv AS 'CVV',expiry AS 'Card Expiry Date' FROM card_tbl ";
			$this->subFuncForViews($sql, 7);
		}
		else if($searchValue =="" && $searchField != 'all'){
			return "<span class='pageInfoErr'>Invalid Search Parameters!!! </span> ";
		}
		else if ($searchValue !="" && $searchField != 'all'){
			//return "<span class='pageInfoErr'> You Entered ".$searchField."&".$searchValue."</span> ";
			$sql = "SELECT cardid AS 'Card ID' ,custid AS 'Customer ID',ctype AS 'Card Type',cnum AS 'Card Number',cname AS 'Name on Card',cvv AS 'CVV',expiry AS 'Card Expiry Date' FROM card_tbl WHERE $searchField ='$searchValue'";
			$this->subFuncForViews($sql, 7);
		}
	}

	function updateOrderTable($ordertablefield, $ordertablefield_value, $orderid){
		if ($ordertablefield =='select_field' || $ordertablefield_value =='select_value' || $orderid == 'select_order_id'){
			return "<span class='pageInfoErr'>At least, one required field is not selected! </span>";
		}
		else{
			$sql = "UPDATE ordering_tbl SET $ordertablefield = '$ordertablefield_value' WHERE orderid = $orderid ";
			$query = $this->db->query_nonselect($sql);
			if ($query == 0) return "<span class='pageInfoErr'>No rows were found! ". mysql_error().". Please Consult the Administrator</span>";
			else if ($query == -1) return "<span class='pageInfoErr'>There was a challenge experienced while trying to perform the task0! ". mysql_error().". Please Consult the Administrator</span>";
			else return "<span class='pageInfoSuccess'>The Selected Order has been updated Successfully.</span>" ;
		}

	}


	function load_OrderID_Select(){
		$sql = "SELECT orderid FROM ordering_tbl";
		$query = $this->db->query($sql);
		$numOfRows = $this->db->num_rows($query);
		if(!$query) return "<span class='pageInfoErr'>Query cannot be executed!!". mysql_error().". Please Consult the Administrator</span>";
		else{
			if ($numOfRows == 0)
				{
				return "<span class='pageInfoErr'>No Data to display!!! </span> ";
			}
			else{
				for ($j = 1 ; $j <= $numOfRows ; ++$j)
					{
					$individualRow = $this->db->fetch_rows($query);
					echo"<option value=".$individualRow[0].">".$individualRow[0]."</option>";
				}
			}
		}
	}

/*

	$queryVehTbl = "SELECT vehid, custid, plateno FROM vehicles_tbl ORDER BY vehid";
                        $vehTblResult = mysql_query($queryVehTbl);
                        if(!$vehTblResult)
                                {
                                 $state="<span class='state0'>Oops! Can\'t query for vehicles</span>".mysql_error();
                        }
                        else
                            {
			    //return number of rows
			    $numOfReturnedRows = mysql_num_rows($vehTblResult);
			    if($numOfReturnedRows == 0)
				    {
				      $state="<span class='state0'>The Vehicles' Table seems not populated</span>".mysql_error();
				    }
			    for ($j = 1 ; $j <= $numOfReturnedRows ; ++$j)
				{
				$individualRow = mysql_fetch_row($vehTblResult);
				echo"<option value=".$individualRow[0].">".$individualRow[1].": ".$individualRow[2]."</option>";
*/
	function makeTransaction() {}




}











?>
