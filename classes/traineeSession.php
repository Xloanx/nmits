<?php

class adminSession{
	var $adminid;
	var $adminlevel;
    var $lname;
    var $fname;
    var $mname;
    var $eaddr;
    var $pwd;
	var $pwd2;
	var $harshed;
    var $phone;
	var $phone2;
	var $raddr;
	var $author;
	var $db ;

	function __construct() {

		if (isset($_SESSION['adminlevel'])){
			$this->adminid =$_SESSION['adminid'];
			$this->adminlevel=$_SESSION['adminlevel'];
			$this->lname = $_SESSION['lname'];
			$this->fname=$_SESSION['fname'];
			$this->phone1=$_SESSION['phone1'];
			$this->phone1=$_SESSION['email'];
			$LOGGEDIN_STATUS	= TRUE;
		}
		else $LOGGEDIN_STATUS = FALSE;

		if (!$LOGGEDIN_STATUS){
			require_once 'loginfalse.php';
			exit;
		}

	}


	function destroySession(){
		$_SESSION=array();
		if (session_id() != "" || isset($_COOKIE[session_name()]))
		setcookie(session_name(), '', time()-2592000, '/');
		session_destroy();
	}


}

?>
