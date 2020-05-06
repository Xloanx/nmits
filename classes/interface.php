<?php

require_once('accessdb.php');
class interface1{


function __construct(){

		$_SESSION_CART = array();
}

function header($title='NMITS') {

echo <<<_header

<!DOCTYPE html>
<html>
<head>
<title>$title</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="css/w3.css">
<link rel="stylesheet" href="css/w3-theme-black.css">
<link rel="stylesheet" href="css/font-awesome.min.css">
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<link rel="stylesheet" href="https://www.w3schools.com/lib/w3-theme-black.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.3.0/css/font-awesome.min.css">
<link rel="stylesheet" href="css/custom.css">
<script src="js/site_js.js" language="javascript" type="text/javascript"> </script>
</head>
<body>

<!-- Header -->
<header class="w3-container w3-theme w3-padding" id="myHeader">
<!---  <i onclick="w3_open()" class="fa fa-bars w3-xlarge w3-button w3-theme"></i>--->
  <div class="w3-center">
  <h1 class="w3-xxxlarge w3-animate-bottom w3-right"> THE NUMERICAL METHODS INTELLIGENT TUTORING SYSTEM</h1>
<!---    <div class="w3-padding-32">
      <button class="w3-btn w3-xlarge w3-dark-grey w3-hover-light-grey" onclick="document.getElementById('id01').style.display='block'" style="font-weight:900;">LEARN W3.CSS</button>
    </div> -->
  </div>
</header>

_header;
}


function TrainerSideNav($title='TRAINER PAGE') {

echo <<<_TrainerSideNav

<!DOCTYPE html>
<html>
<head>
<title>$title</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="../css/w3.css">
<link rel="stylesheet" href="../css/w3-theme-black.css">
<link rel="stylesheet" href="../css/font-awesome.min.css">
<link rel="stylesheet" href="../css/custom.css">
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<link rel="stylesheet" href="https://www.w3schools.com/lib/w3-theme-black.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.3.0/css/font-awesome.min.css">
<script src="../js/site_js.js" language="javascript" type="text/javascript"> </script>
</head>
<body class="">

<!-- Sidebar/menu -->
<nav class="w3-sidebar w3-bar-block w3-grey w3-collapse w3-top" style="z-index:3;width:250px" id="mySidebar">
<header class="w3-container w3-theme w3-padding w3-round-large" id="myHeader">
  <div class="w3-center">
  <h1 class="w3-xxxlarge w3-animate-bottom"> NMITS</h1>
  </div>
</header>
  <div class="w3-container w3-display-container w3-padding-64 w3-large w3-text-grey" style="font-weight:bold">
	    <i onclick="w3_close()" class="fa fa-remove w3-hide-large w3-button w3-display-topright"></i>
    <p style="font-color:white">TASKS</p>
		<a href="../logout.php"><button type="submit" class="w3-btn w3-medium w3-round-xxlarge w3-dark-grey w3-hover-light-grey" style="font-weight:900;">Logout</button> </a>
    <a onclick="trainerFunc()" href="javascript:void(0)" class="w3-button w3-block w3-grey w3-left-align accordion" id="TrainerBtn"> Trainer Details <i class="fa fa-caret-down"></i></a>
    <div id="trainerAcc" class="w3-bar-block w3-hide w3-padding-large w3-medium panel w3-grey">
      <a href="change-pwd.php" class="w3-bar-item w3-button">Change Password</a>
      <a href="edit-own-details.php" class="w3-bar-item w3-button">Edit own Details</a>
			<a href="add-trainer.php" class="w3-bar-item w3-button">Add New Trainer</a>
    </div>

	<a onclick="contentFunc()" href="javascript:void(0)" class="w3-button w3-block w3-grey w3-left-align" id="contentBtn"> Module <i class="fa fa-caret-down"></i></a>
    <div id="contentAcc" class="w3-bar-block w3-hide w3-padding-large w3-medium w3-grey">
      <a href="add-module.php" class="w3-bar-item w3-button">Add Module Content</a>
      <a href="add-test.php" class="w3-bar-item w3-button">Add Module Test </a>
 <!--     <a href="edit-module.php" class="w3-bar-item w3-button">Edit Module Content</a>
      <a href="delete-module.php" class="w3-bar-item w3-button">Delete Module Content</a>  -->
    </div>
 <!-- 
	<a onclick="testFunc()" href="javascript:void(0)" class="w3-button w3-block w3-white w3-left-align" id="testBtn"> Module Test <i class="fa fa-caret-down"></i></a>
    <div id="testAcc" class="w3-bar-block w3-hide w3-padding-large w3-medium">
      <a href="add-test.php" class="w3-bar-item w3-button">Add Module Test </a>
    <a href="edit-test.php" class="w3-bar-item w3-button">Edit Module Test</a>
      <a href="delete-test.php" class="w3-bar-item w3-button">Delete Module Test</a> 
    </div>  -->

	<a onclick="traineeFunc()" href="javascript:void(0)" class="w3-button w3-block w3-grey w3-left-align" id="traineeBtn"> Views <i class="fa fa-caret-down"></i></a>
    <div id="traineeAcc" class="w3-bar-block w3-hide w3-padding-large w3-medium w3-grey">
<!---      <a href="trainees.php" class="w3-bar-item w3-button">View All Trainees</a>
			<a href="logged-trainees.php" class="w3-bar-item w3-button">View Logged In Trainees</a>
      <a href="perf.php" class="w3-bar-item w3-button">View Performances</a>  -->
			<a href="contents-view.php" class="w3-bar-item w3-button">View Modules Content</a>
			<a href="tests-view.php" class="w3-bar-item w3-button">View Tests</a>
    </div>
<!-- 
		<a onclick="traineeFunc()" href="javascript:void(0)" class="w3-button w3-block w3-white w3-left-align" id="traineeBtn"> <img src="img/settings.jpg" width="50px"> <i class="fa fa-caret-down"></i></a>
	    <div id="traineeAcc" class="w3-bar-block w3-hide w3-padding-large w3-medium">
	      <a href="trainees.php" class="w3-bar-item w3-button">View All Trainees</a>
				<a href="logged_trainees.php" class="w3-bar-item w3-button">View Logged In Trainees</a>
	      <a href="perf.php" class="w3-bar-item w3-button">View Performances</a>
				<a href="tests_view.php" class="w3-bar-item w3-button">View Tests</a>
				<a href="contents_view" class="w3-bar-item w3-button">View Modules Content</a>
	    </div>-->

  </div>
</nav>

<!-- Top menu on small screens -->
<header class="w3-bar w3-top w3-hide-large w3-black w3-xlarge">
<div class="w3-bar-item w3-padding-24 w3-wide"><img src="../img/study.jpg" style="width:15%"></div>
<a href="javascript:void(0)" class="w3-bar-item w3-button w3-padding-24 w3-right" onclick="w3_open()"><i class="fa fa-bars"></i></a>
</header>

<!-- Overlay effect when opening sidebar on small screens -->
<div class="w3-overlay w3-hide-large" onclick="w3_close()" style="cursor:pointer" title="close side menu" id="myOverlay"></div>

<!-- !PAGE CONTENT! -->
<div class="w3-main" style="margin-left:250px">

<!-- Push down content on small screens -->
<div class="w3-hide-large" style="margin-top:83px"></div>



<!-- Header 
<header class="w3-container w3-theme w3-padding" id="myHeader">
<!---  <i onclick="w3_open()" class="fa fa-bars w3-xlarge w3-button w3-theme"></i>
  <div class="w3-center">
  <h1 class="w3-xxxlarge w3-animate-bottom"> THE NUMERICAL METHODS INTELLIGENT TUTORING SYSTEM</h1>
<!---    <div class="w3-padding-32">
      <button class="w3-btn w3-xlarge w3-dark-grey w3-hover-light-grey" onclick="document.getElementById('id01').style.display='block'" style="font-weight:900;">LEARN W3.CSS</button>
    </div> 
  </div>
</header>
-->

_TrainerSideNav;
}



function TraineeSideNav($title='TRAINEE PAGE', $current_moduleno) {

echo <<<_TraineeSideNav

<!DOCTYPE html>
<html>
<head>
<title>$title</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="../css/w3.css">
<link rel="stylesheet" href="../css/w3-theme-black.css">
<link rel="stylesheet" href="../css/font-awesome.min.css">
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<link rel="stylesheet" href="https://www.w3schools.com/lib/w3-theme-black.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.3.0/css/font-awesome.min.css">
<link rel="stylesheet" type='text/css' href="../css/custom.css">
<script src="../js/site_js.js" language="javascript" type="text/javascript"> </script>

<script>

function alertMe(){
  alert("I am connected");
}


function openPage(pageName, elmnt, color) {
  // Declare all variables
  var i, contentclass, tablinks;

  // Get all elements with class="content_class" and hide them
  contentclass = document.getElementsByClassName("contentclass");
  for (i = 0; i < contentclass.length; i++) {
    contentclass[i].style.display = "none";
  }

  // Get all elements with class="tablinks" and remove the class "active"
  tablinks = document.getElementsByClassName("tablink");
  for (i = 0; i < tablinks.length; i++) {
    tablinks[i].style.backgroundColor = "";
    tablinks[i].className = tablinks[i].className.replace(" active", "");
  }

  // Show the current tab, and add an "active" class to the link that opened the tab
  document.getElementById(pageName).style.display = "block";
  pageName.currentTarget.className += " active";

  elmnt.style.backgroundColor = color;
} 

// Get the element with id="defaultOpen" and click on it
document.getElementById("defaultOpen").click();

//child window callers//
function takeTest(myCurrMod)
	{
	window.open('testing.php?mod=myCurrMod',null,'left=150,top=20,height=600, width=800,scrollbars=yes,status= Yes, resizable= Yes, scrollbars=Yes, toolbar=no,location=no,menubar=yes');
}

function disagreeOnRegulation(){
    document.getElementById('alertclass').style.display = "none";
  }

function showRegulation()
  {
    // Show Regulations
    document.getElementById('alertclass').style.display = "block";
  }

</script>
</head>
<body>

<!-- Sidebar/menu -->
<nav class="w3-sidebar w3-bar-block w3-white w3-collapse w3-top navigator" style="z-index:3;width:250px;" id="mySidebar">
<header class="w3-container w3-theme w3-padding w3-round-large" id="myHeader">
  <div class="w3-center">
  <h1 class="w3-xxxlarge w3-animate-bottom"> NMITS</h1>
  </div>
</header>
  <div class="w3-padding-64 w3-large w3-text-grey" style="font-weight:bold">
		<a href="../logout.php"><button type="submit" class="w3-btn w3-medium w3-round-xxlarge w3-dark-grey w3-hover-light-grey" style="font-weight:900;">Logout</button> </a>
	  <p>TABLE OF CONTENTS</p>
		<a onclick="trainerFunc()" href="javascript:void(0)" class="w3-button w3-block w3-white w3-left-align" id="TrainerBtn"> Course Content <i class="fa fa-caret-down"></i></a>
    <div id="trainerAcc" class="tab w3-bar-block w3-hide w3-padding-large w3-medium">
		<!--
			<button type='submit' class='tablink w3-btn w3-xlarge w3-dark-grey w3-hover-light-grey' onclick="openPage('module1', this, 'red')" style='font-weight:200' id='defaultOpen'>Module 1</button><br/><br/>
			<button type='submit' class='tablink w3-btn w3-xlarge w3-dark-grey w3-hover-light-grey' onclick="openPage('module2', this, 'green')" style='font-weight:200;'>Module 2</button><br/><br/>
			<button type='submit' class='tablink w3-btn w3-xlarge w3-dark-grey w3-hover-light-grey' onclick="openPage('module3', this, 'blue')" style='font-weight:200;'>Module 3</button><br/><br/>
-->
<!--			<button type='submit' class='tablink w3-btn w3-xlarge w3-dark-grey w3-hover-light-grey' onclick="alertMe()" style='font-weight:200;'>Module 4</button><br/><br/>
--->
_TraineeSideNav;


for ($i=1; $i<=$current_moduleno; $i++){
		echo "<button type='submit' class='tablink w3-btn w3-medium w3-round-xxlarge w3-dark-grey w3-hover-light-grey' onclick=\"openPage('module$i', this, 'grey')\" style='font-weight:200' id='defaultOpen'>Module $i</button><br/><br/>";
}

echo <<<_TraineeSideNav1

<!--
			  <a href="change-pwd.php" class="w3-bar-item w3-button">Module 1</a>
      <a href="#" class="w3-bar-item w3-button">Module 2</a>
			<a href="#" class="w3-bar-item w3-button">Module 3</a>
			<a href="#" class="w3-bar-item w3-button">Module 4</a>
			<a href="#" class="w3-bar-item w3-button">Module 5</a>



	<a onclick="contentFunc()" href="javascript:void(0)" class="w3-button w3-block w3-white w3-left-align" id="contentBtn"> Intermediate <i class="fa fa-caret-down"></i></a>
    <div id="contentAcc" class="w3-bar-block w3-hide w3-padding-large w3-medium">
      <a href="#" class="w3-bar-item w3-button">Module 6</a>
      <a href="#" class="w3-bar-item w3-button">Module 7</a>
      <a href="#" class="w3-bar-item w3-button">Module 8</a>
			<a href="#" class="w3-bar-item w3-button">Module 9</a>
    </div>
--->
<!--
	<a onclick="testFunc()" href="javascript:void(0)" class="w3-button w3-block w3-white w3-left-align" id="testBtn"> Advanced <i class="fa fa-caret-down"></i></a>
    <div id="testAcc" class="w3-bar-block w3-hide w3-padding-large w3-medium">
      <a href="#" class="w3-bar-item w3-button w3-light-grey"><i class="fa fa-caret-right w3-margin-right"></i>Skinny</a>
      <a href="add-new-patient.php" class="w3-bar-item w3-button">Module 10 </a>
			<a href="add-new-patient.php" class="w3-bar-item w3-button">Module 11 </a>
			<a href="add-new-patient.php" class="w3-bar-item w3-button">Module 12 </a>
			<a href="add-new-patient.php" class="w3-bar-item w3-button">Module 13 </a>
    </div>
	---->
		</div>
	</div>
</nav>

<!-- Top menu on small screens -->
<header class="w3-bar w3-top w3-hide-large w3-black w3-xlarge">
<div class="w3-bar-item w3-padding-24 w3-wide">LOGO</div>
<a href="javascript:void(0)" class="w3-bar-item w3-button w3-padding-24 w3-right" onclick="w3_open()"><i class="fa fa-bars"></i></a>
</header>

<!-- Overlay effect when opening sidebar on small screens -->
<div class="w3-overlay w3-hide-large" onclick="w3_close()" style="cursor:pointer" title="close side menu" id="myOverlay"></div>

<!-- !PAGE CONTENT! -->
<div class="w3-main" style="margin-left:250px">

<!-- Push down content on small screens -->
<div class="w3-hide-large" style="margin-top:83px"></div>

<!-- Header
<header class="w3-container w3-theme w3-padding" id="myHeader">
<!---  <i onclick="w3_open()" class="fa fa-bars w3-xlarge w3-button w3-theme"></i>
  <div class="w3-center">
  <h1 class="w3-xxxlarge w3-animate-bottom"> THE NUMERICAL METHODS INTELLIGENT TUTORING SYSTEM</h1>
<!---    <div class="w3-padding-32">
      <button class="w3-btn w3-xlarge w3-dark-grey w3-hover-light-grey" onclick="document.getElementById('id01').style.display='block'" style="font-weight:900;">LEARN W3.CSS</button>
    </div> 
  </div>
</header>-->

_TraineeSideNav1;
}




function testheader($title='NMITS'){

echo <<<_header

<!DOCTYPE html>
<html>
<head>
<title>$title</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="../css/w3.css">
<link rel="stylesheet" href="../css/w3-theme-black.css">
<link rel="stylesheet" href="../css/font-awesome.min.css">
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<link rel="stylesheet" href="https://www.w3schools.com/lib/w3-theme-black.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.3.0/css/font-awesome.min.css">
<link rel="stylesheet" href="../css/custom.css">
<script src="../js/site_js.js" language="javascript" type="text/javascript"> </script>
<script>


	function disagreeOnRegulation(){
		document.getElementById('allTestPageContent').style.display = "none";
	}

  function showRegulation()
  {
    // Show Regulations
    document.getElementById('alertclass').style.display = "block";
  }
 
	function startTest()
		{

			// Declare all variables
			var testclass;

			//hide the continue button
			document.getElementById('alert').style.display = "none";

			//display the questions
			testclass = document.getElementsByClassName("testclass");
			for (i = 0; i < testclass.length; i++) {
				testclass[i].style.display = "block";
			}

	}
///////////////////////////////////////////COUNT DOWN SNIPPET STARTS HERE//////////////////////////////////////////
var testTime = 30; //in mins
var today = new Date();
//var date = today.getFullYear()+'-'+(today.getMonth()+1)+'-'+today.getDate();
var date = (today.getMonth()+1)+' '+today.getDate()+','+' '+today.getFullYear();
var secs = today.getSeconds();
var mins = today.getMinutes()+testTime;
if (mins >= 60 )    //if after adding the test Time, the sum of minute is greater than an hour
  {
  var remFloor = Math.floor(mins/60);
  var remMod = (mins%60);
  var hrs = (today.getHours()+remFloor);
  var time = hrs + ":" + remMod+ ":" + today.getSeconds();
}
else
  {
  var hrs = today.getHours();
  var time = today.getHours() + ":" + mins + ":" + today.getSeconds();
}



//var time = today.getHours() + ":" + (today.getMinutes()+testTime)+ ":" + today.getSeconds();
var dateTime = date+' '+time;   //2018-8-3 11:12:40
//var dateTime = date
// Set the date we're counting down to
//var countDownDate = new Date("10 6, 2019 23:00:00").getTime();
var countDownDate = new Date(dateTime).getTime();

// Update the count down every 1 second
var x = setInterval(function() {

  // Get today's date and time
  var now = new Date().getTime();

  // Find the distance between now and the count down date
  var distance = countDownDate - now;

  // Time calculations for days, hours, minutes and seconds
  var days = Math.floor(distance / (1000 * 60 * 60 * 24));
  var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
  var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
  var seconds = Math.floor((distance % (1000 * 60)) / 1000);

  // Display the result in the element with id="demo"
  //document.getElementById("countdown").innerHTML = days + "d " + hours + "h " + minutes + "m " + seconds + "s ";
  document.getElementById("countdown").innerHTML = hours + "h " + minutes + "m " + seconds + "s ";
  
  // If the count down is finished, write some text
  if (distance < 0) {
    clearInterval(x);
    document.getElementById("countdown").innerHTML = "EXPIRED";
  }
}, 1000);
////////////////////////////////////////////COUNT DOWN SNIPPET ENDS HERE///////////////////////////////////////////

</script>
</head>
<body>

<!-- Header -->
<header class="w3-container w3-theme w3-padding" id="myHeader">
  <div class="w3-center">
  <p class="w3-xlarge w3-animate-bottom w3-center"> NMITS :: TEST KING </p>

  </div>
</header>

_header;
}

}
?>
