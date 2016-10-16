<?php
	$cname = $_POST["checkName"];
	$cphone = $_POST["checkPhone"];
	$cgender = $_POST["checkGender"];
	$cemail = $_POST["checkEmail"];
	$cdateofbirth = $_POST["checkBirthDatetime"];
	$homeunit = $_POST["checkHomeUnit"];
	$homestreet = $_POST["checkHomeStreet"];
	$homesuburb = $_POST["checkHomeSuburb"];
	$lusername = $_POST["checkLoginUsername"];
	$lpassword = $_POST["checkLoginPassword"];
	
	if(trim($cname) != "")
	{
		if(!preg_match('/^[a-zA-Z ]*$/', $cname))
		{
			echo "<font color='red'>Only letters and space</font>";
		}
		else
		{
			echo "<font color='green'>OK</font>";
		}
	}
	
	if(trim($cphone) != "")
	{
		if(!preg_match('/^[0-9]*$/', $cphone))
		{
			echo "<font color='red'>Only numbers</font>";
		}
		else
		{
			echo "<font color='green'>OK</font>";
		}
	}
	
	if(trim($cgender) != "")
	{
		if($cgender != "Male" and $cgender != "Female")
		{
			echo "<font color='red'>Only Male and Female</font>";
		}
		else
		{
			echo "<font color='green'>OK</font>";
		}
	}
	
	if(trim($cemail) != "")
	{
		if(!filter_var($cemail, FILTER_VALIDATE_EMAIL))
		{
			echo "<font color='red'>Invalid email format</font>";
		}
		else
		{
			echo "<font color='green'>OK</font>";
		}
	}
	
	if(trim($cdateofbirth) != "")
	{
		$currentDate = date("Y-m-d") . " " . "00:00:00";
		$newBirthDateTime = substr($cdateofbirth,0,10) . " " . "00:00:00";
		$currentDateNumber = strtotime($currentDate) + (0 * 60 * 60);
		$newBirthDateTimeNumber = strtotime($newBirthDateTime);
		$newBirthDateTimeNumber = $newBirthDateTimeNumber + (((16*365)+4)*24*60*60);
		if($newBirthDateTimeNumber > $currentDateNumber)
		{
			echo "<font color='red'>Only before 16 years from right now</font>";
		}
		else
		{
			echo "<font color='green'>OK</font>";
		}
	}
	
	if(trim($homeunit) != "")
	{
		if(!preg_match('/^[0-9A-Z]*$/', $homeunit))
		{
			echo "<font color='red'>Only numbers or Uppercase letters</font>";
		}
		else
		{
			echo "<font color='green'>OK</font>";
		}
	}
	
	if(trim($homestreet) != "")
	{
		if(!preg_match('/^[a-zA-Z0-9 ]*$/', $homestreet))
		{
			echo "<font color='red'>Only letters and numbers and space</font>";
		}
		else
		{
			echo "<font color='green'>OK</font>";
		}
	}
	
	if(trim($homesuburb) != "")
	{
		if(!preg_match('/^[a-zA-Z ]*$/', $homesuburb))
		{
			echo "<font color='red'>Only letters and space</font>";
		}
		else
		{
			echo "<font color='green'>OK</font>";
		}
	}
	
	if(trim($lusername) != "")
	{
		if(!preg_match('/^[a-zA-Z0-9]*$/', $lusername))
		{
			echo "<font color='red'>Only letters and numbers</font>";
		}
		else
		{
			require_once("settings.php");

      $conn = mysqli_connect($host, $user, $pswd, $dbnm);

      if(!$conn) 
      {
        echo "<font color='red'>Connection Failure</font>";
      }
      else
      {
        $querySelect = "SELECT `l_username` from `customer` where `l_username` like '$lusername'";
        
        $selectResult = mysqli_query($conn, $querySelect);
        
        $existUsername = "";
        
        while($row = mysqli_fetch_row($selectResult))
        {
          $existUsername = (string)$row[0];
        }
        
        if(trim($existUsername) == $lusername)
        {
          echo "<font color='red'>The login username <font color='purple'>$existUsername</font> is taken, please try another one!</font>";
        }
        else
        {
          echo "<font color='green'>OK</font>";
        }
       }
       mysqli_close($conn);
     }
	}
	
	if(trim($lpassword) != "")
	{
		if(!preg_match('/^[a-zA-Z0-9]*$/', $lpassword))
		{
			echo "<font color='red'>Only letters and numbers</font>";
		}
		else
		{
			echo "<font color='green'>OK</font>";
		}
	}
?>