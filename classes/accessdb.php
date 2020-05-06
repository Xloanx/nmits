<?php

class accessdb{

	var $error_msg;		// holds error messages
    var $host;			// Your MySQL host, may need to add port number as well
    var $user;			// The user name you will be using to connect. Should not be root
    var $pass;			// The password for $user
    var $db;			// The database you are connecting to
    var $conn;			// database link
    var $port;

	function __construct(){

  //hosting details
 /*       
        $this->host = 'localhost';
        $this->user = 'kgisuydd_nmits';
        $this->pass = 'Nm!tsus68';
        $this->db = 'kgisuydd_nmitsdb';
     */   
		$this->host = 'localhost';
		$this->user = 'nmits';
		$this->pass = 'Nm!tsus68';
		$this->db = 'nmitsdb';
        

		$this->conn = mysqli_connect($this->host, $this->user, $this->pass);
        if (!$this->conn) {
            $this->error_msg = mysqli_error($this->conn);
            return false;
		}
		if (!mysqli_select_db($this->conn, $this->db)) {
            $this->error_msg = mysqli_error($this->conn);
            return false;
        }
        return true;

	}
	/*
	function dbaccess(){

		$this->host = 'localhost';
		$this->user = '';
		$this->pass = '';
		$this->db = 'cafedb';

	}


	function connect(){

		$this->conn = mysql_connect($this->host, $this->user, $this->pass);
        if (!$this->conn) {
            $this->error_msg = mysql_error();
            return false;
		}
		if (!mysql_select_db($this->db)) {
            $this->error_msg = mysql_error();
            return false;
        }
        return true;
	}
	*/

	function disconnect() {
        mysqli_close($this->conn);
    }

    function quote_smart($value) {
    // Stripslashes
        if (get_magic_quotes_gpc()) {
            $value = stripslashes($value);
        }
        // Quote if not a number or a numeric string
        if (!is_numeric($value)) {
            $value = "'" . mysqli_real_escape_string($this->conn,$value) . "'";
        }
        return $value;
    }

	function tableExists($name)
		{
		$result = query("SHOW TABLES LIKE '$name'");
		return mysqli_num_rows($this->conn,$result);
	}

	function createTable($name, $query, $engine)
		{
		if (tableExists($name))
			{
			return "<span class='pageInfoErr'>Table '$name' already exists</span>" ;
		}
		else
			{
			query("CREATE TABLE $name($query)$engine");
			return "<span class='pageInfoSuccess'>Table '$name' created<br /></span>" ;
		}
	}

	function sanitizeEntry($var){
		$var = strip_tags($var);
		$var = htmlentities($var);
		if (get_magic_quotes_gpc()) $var = stripslashes($var);
		return mysqli_real_escape_string($this->conn,$var);

	}

/*
$search=mysqli_query($connection, "select name from table_name where id='7'");
$name=mysqli_result($search, 0, "id");

*/
    function query($sql) {
        $return = 0;
        $results = mysqli_query($this->conn,$sql) ;
        if (!$results) {
            return $return;
        }
        return $results;
    }

    function query_nonselect($sql) {
        $results = $this->query($sql) ;
        $value = mysqli_affected_rows($this->conn);
        return $value;
    }

    function num_rows($query) {
        return mysqli_num_rows($query);
    }

	function fetch_rows($query) {
		return mysqli_fetch_row($query);
	}

    function get_array($query) {
        return mysqli_fetch_array($query);
    }

    function insert_id() {
        $sql = "SELECT LAST_INSERT_ID()";
        $a = $this->query($sql);
        $b = $this->get_array($a);
        return $b[0];
    }

    function get_assoc($query) {
        return mysqli_fetch_assoc($query);
    }

	function fetch_last_insert_id(){
		return mysqli_insert_id($this->conn);
	}

    function data_seek($dbquery,$int) {
        return mysql_data_seek($dbquery,$int);
    }

    function escape_string($string) {
        return mysql_real_escape_string($string);
    }

    function add_slashes($string) {
        if (get_magic_quotes_gpc()) {
            return $string;
        }else {
            return addslashes($string);
        }
    }

    function getSQLVS($theValue, $theType, $theDefinedValue, $theNotDefinedValue) {
        $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
        $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);
        switch ($theType) {
            case "text":
                $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
                break;
            case "long":
            case "int":
                $theValue = ($theValue != "") ? intval($theValue) : "NULL";
                break;
            case "double":
                $theValue = ($theValue != "") ? "'" . doubleval($theValue) . "'" : "NULL";
                break;
            case "date":
                $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
                break;
            case "defined":
                $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
                break;
        }
        return $theValue;
    }

    /** Add a sql statement **/
    function addSql($sql) {
        $this->tCount++;
        $this->aSql[$this->tCount] = $sql;
    }

    // Execute transactions
    function executeTransactSql() {
    // If start transaction ok
        if ($this->executeSQL("start transaction")) {
        // Executes a sql statements
            for ($i=1; $i<=count($this->aSql); $i++) {
                $res = $this->executeSQL($this->aSql[$i]);
                // Abort, if any error
                if (!$res) {
                    break;
                }
            }
            // If all statements executes ok, commit transaction else rollback.
            if ($res) {
                $res = $this->executeSQL("commit");
                return true;
            }
            else {
                $res = $this->executeSQL("rollback");
                return false;
            }
        }
    }

    // Executes a sql statement in  MySQL database
    function executeSQL($sql) {
        if(empty($sql))
            $res = 0; // Error in connection or SQL clausule.
        if (!($res = $this->query($sql))) {
            $res = 0; //Error occurred
        }
        return $res;
    }





}
















?>
