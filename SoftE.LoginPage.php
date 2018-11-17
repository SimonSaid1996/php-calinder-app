
<?php
require 'SoftInfo.php';

$connection = mysqli_connect($dbserver,$dbuser,$dbpass,$dbdatabase);

if($connection === false) {
    // Handle error - notify administrator, log to a file, show an error screen, etc.
	echo "connection error";
	echo mysqli_error($connection);
}

$userEmail=$_GET['emialN'];// get user email input
$userPassword=$_GET['password'];// get user password input	
	
$emailArray=array();
$passwordArray=array();
//to storage data in the database and check in the future
if($_GET['accountType']=="viewer"){
		$resultEmail = mysqli_query($connection, "SELECT email FROM user ");
		if($resultEmail === false) {
				echo 'no emails found.';
				//generic error message
				echo mysqli_error($connection);
			} 
		else{
			$resultE = mysqli_query($connection, "SELECT email FROM user");

					while ($emailExist = mysqli_fetch_assoc($resultE)) {
						$Email=$emailExist['email'];
						array_push($emailArray,$Email);//insert into emailArray
					}
			}

		$resultPassword = mysqli_query($connection, "SELECT password FROM user ");
		if($resultPassword === false) {
				echo 'no passwords found.';
				echo mysqli_error($connection);
			} 
		else{
			$resultP = mysqli_query($connection, "SELECT password FROM user");//another table

					while ($passwordExist = mysqli_fetch_assoc($resultP)) {
						$Password=$passwordExist['password'];
						array_push($passwordArray,$Password);//insert into passwordArray
					}
			}
		
	
	if (in_array($userEmail, $emailArray, true)) {
		if (in_array($userPassword, $passwordArray, true)) {
			header ('location: http://127.0.0.1/software enginering - Copy\calendar-event.php');
		}
		else {
			echo '<script language="javascript">';
			echo 'alert("no password matches, create a new account")';
			echo '</script>';
			echo '<a href="http://127.0.0.1/software enginering - Copy/SoftE.Login2.html">back to the loggin page</a> ';
		}
	}
	else {
		echo '<script language="javascript">';
			echo 'alert("no email matches, create a new account")';
			echo '</script>';
			echo '<a href="http://127.0.0.1/software enginering - Copy/SoftE.Login2.html">back to the loggin page</a> ';
	}
}
else {
	$resultEmail = mysqli_query($connection, "SELECT email FROM manager ");
		if($resultEmail === false) {
				echo 'no emails found.';
				//generic error message
				echo mysqli_error($connection);
			} 
		else{
			$resultE = mysqli_query($connection, "SELECT email FROM manager");

					while ($emailExist = mysqli_fetch_assoc($resultE)) {
						$Email=$emailExist['email'];
						array_push($emailArray,$Email);//insert into emailArray
					}
			}

		$resultPassword = mysqli_query($connection, "SELECT password FROM manager ");
		if($resultPassword === false) {
				echo 'no passwords found.';
				//generic error message
				echo mysqli_error($connection);
			} 
		else{
			$resultP = mysqli_query($connection, "SELECT password FROM manager");//another table

					while ($passwordExist = mysqli_fetch_assoc($resultP)) {
						$Password=$passwordExist['password'];
						array_push($passwordArray,$Password);//insert into passwordArray
					}
			}
		

	if (in_array($userEmail, $emailArray, true)) {
		if (in_array($userPassword, $passwordArray, true)) {
			header ('location: http://127.0.0.1/software enginering - Copy\SoftwareDec11Build\SoftwareDec11Build\SoftwareProjectPage.php');
			//change the direction to the calendar 
		}
		else {
			echo '<script language="javascript">';
			echo 'alert("no password matches, create a new account")';
			echo '</script>';
			echo '<a href="http://127.0.0.1/software enginering - Copy/SoftE.Login2.html">back to the loggin page</a> ';
		}
	}
	else {
		echo '<script language="javascript">';
			echo 'alert("no email matches, create a new account")';
			echo '</script>';
			echo '<a href="http://127.0.0.1/software enginering - Copy/SoftE.Login2.html">back to the loggin page</a> ';
	}
}

?>