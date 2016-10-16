<?php
	require_once("settings.php");

	$conn = mysqli_connect($host, $user, $pswd, $dbnm);

	if(!$conn) 
	{
		echo "<font color='red'>Connection Failure</font>";
	} 
	else 
	{
    $l_username = $_POST["l-username"];
    $l_password = $_POST["l-password"];

		$querySelect = "SELECT `l_username`, `l_password` from `customer` where `l_username` like '$l_username'";
			
		$selectResult = mysqli_query($conn, $querySelect);

		$username = "";
		$password = "";
			
		while($row = mysqli_fetch_row($selectResult))
		{
			$username = (string)$row[0];
			$password = (string)$row[1];
		}
			
		if(trim($username) != "")
		{
      if(trim($password) == $l_password)
      {
        echo "Congratulations, You have login now!";
      }
      else
      {
        echo "Sorry, Login Username or Password does not match!";
      }
		}
		else
		{
      echo "Sorry, Login Username does not exist!";
		}
		mysqli_close($conn);
	}
?>