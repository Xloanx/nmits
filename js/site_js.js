// Accordion

function trainerFunc() {
    var x = document.getElementById("trainerAcc");
    if (x.className.indexOf("w3-show") == -1) {
        x.className += " w3-show";
    } else {
        x.className = x.className.replace(" w3-show", "");
    }
}

function contentFunc() {
    var x = document.getElementById("contentAcc");
    if (x.className.indexOf("w3-show") == -1) {
        x.className += " w3-show";
    } else {
        x.className = x.className.replace(" w3-show", "");
    }
}

function testFunc() {
    var x = document.getElementById("testAcc");
    if (x.className.indexOf("w3-show") == -1) {
        x.className += " w3-show";
    } else {
        x.className = x.className.replace(" w3-show", "");
    }
}


function traineeFunc() {
    var x = document.getElementById("traineeAcc");
    if (x.className.indexOf("w3-show") == -1) {
        x.className += " w3-show";
    } else {
        x.className = x.className.replace(" w3-show", "");
    }
}



// Click on the "Cover" link on page load to open the accordion
document.getElementById("trainerBtn").click();
document.getElementById("contentBtn").click();
document.getElementById("testBtn").click();
document.getElementById("traineeBtn").click();


// Script to open and close sidebar
function w3_open() {
    document.getElementById("mySidebar").style.display = "block";
    document.getElementById("myOverlay").style.display = "block";
}

function w3_close() {
    document.getElementById("mySidebar").style.display = "none";
    document.getElementById("myOverlay").style.display = "none";
}
//end of Accordion

var acc = document.getElementsByClassName("accordion");
var i;

for (i = 0; i < acc.length; i++) {
  acc[i].addEventListener("click", function() {
    /* Toggle between adding and removing the "active" class,
    to highlight the button that controls the panel */
    this.classList.toggle("active");

    /* Toggle between hiding and showing the active panel */
    var panel = this.nextElementSibling;
    if (panel.style.display === "block") {
      panel.style.display = "none";
    } else {
      panel.style.display = "block";
    }
  });
}

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


function confirmp(){
  if (confirm("Are you sure you want to continue?")) return true;
  else return false;
}


function disagreeOnRegulation(){
    document.getElementById('alertclass').style.display = "none";
  }

function showRegulation()
  {
    // Show Regulations
    document.getElementById('alertclass').style.display = "block";
  }
//child window callers//
/*
function takeTest()
{
window.open('testing.php',null,'left=150,top=20,height=600, width=800,scrollbars=yes,status= Yes, resizable= Yes, scrollbars=Yes, toolbar=no,location=no,menubar=yes');
}
*/

/*
function takeTest1(){
  var line1 = "1. You will be exposed to some number of questions in this module's test.<br/>";
  var line2 = "2. Each question as a stipulated amount of time attached to it and this time counts down at the top right corner of the test page.<br/>";
  var line3 = "3. If you do not choose an answer before the time runs out, the test takes you to another question automatically.<br/>"
  var line4 = "4. The test does not allow you to go back to change answers to questions you have gone past.<br/>"
  var line5 = "5. You must click on the next button to move to the next question.<br/>"
  var line6 = "Do you want to continue ?"
  var info = line1 + line2 + line3 + line4 + line5 + line6;
  var retVal = confirm(info);
  if( retVal == true ) {
     window.open('testing.php',null,'left=150,top=20,height=600, width=800,scrollbars=yes,status= Yes, resizable= Yes, scrollbars=Yes, toolbar=no,location=no,menubar=yes');
     return true;
  }
  else {
     return false;
  }


}*/









/*
//child window callers//
function addVisitation()
{
window.open('addvisitation.php',null,'left=150,top=20,height=300, width=800,scrollbars=yes,status= Yes, resizable= Yes, scrollbars=Yes, toolbar=no,location=no,menubar=yes');
}
*/
//end of child window callers
