<?php
	require_once("settings.php");

	$conn = mysqli_connect($host, $user, $pswd, $dbnm);

	if(!$conn) 
	{
		echo "<font color='red'>Connection Failure</font>";
	} 
	else 
	{
		$c_name = $_POST["c-name"];
		$c_phone = $_POST["c-phone"];
		$c_gender = $_POST["c-gender"];
		$c_email = $_POST["c-email"];
		$c_dateofbirth = $_POST["c-dateofbirth"];
		$home_unit = $_POST["home-unit"];
		$home_street = $_POST["home-street"];
		$home_suburb = $_POST["home-suburb"];
    $l_username = $_POST["l-username"];
    $l_password = $_POST["l-password"];
		$register_datetime = $_POST["register-datetime"];
		
		$queryCreateTable = "CREATE TABLE IF NOT EXISTS `customer` (`c_id` INT(10) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT, `c_name` VARCHAR(100) NOT NULL, `c_phone` VARCHAR(25) NOT NULL, `c_gender` ENUM('Male','Female') NOT NULL DEFAULT 'Male', `c_email` VARCHAR(50) NOT NULL, `c_dateofbirth` DATETIME NOT NULL DEFAULT '1970-01-02 00:00:00', `home_unit` VARCHAR(5) NULL DEFAULT NULL, `home_street` VARCHAR(50) NOT NULL, `home_suburb` VARCHAR(20) NOT NULL, `l_username` VARCHAR(20) NOT NULL, `l_password` VARCHAR(20) NOT NULL, `register_datetime` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP, PRIMARY KEY (`c_id`)) ENGINE=InnoDB DEFAULT CHARSET=utf8;"; 
		
		mysqli_query($conn, $queryCreateTable);
		
		$queryInsert = "INSERT INTO `customer` (`c_name`, `c_phone`, `c_gender`, `c_email`, `c_dateofbirth`, `home_unit`, `home_street`, `home_suburb`, `l_username`, `l_password`, `register_datetime`) VALUES ('$c_name', '$c_phone', '$c_gender', '$c_email', '$c_dateofbirth', '$home_unit', '$home_street', '$home_suburb', '$l_username', '$l_password', '$register_datetime');";

		$insertResult = mysqli_query($conn, $queryInsert);
		
		if(!$insertResult)
		{
			echo "<font color='red'>$queryInsert</font>";
		} 
		else
		{
			$querySelect = "SELECT `c_id`, `c_name`, `c_phone`, `c_gender`, `c_email`, `l_username`, `l_password` from `customer` where `l_username` like '$l_username'";
			
			$selectResult = mysqli_query($conn, $querySelect);
			
			$id = "0";
			$name = "";
			$phone = "";
			$gender = "";
			$email = "";
			$username = "";
			$password = "";
			
			while($row = mysqli_fetch_row($selectResult))
			{
				$id = (string)$row[0];
				$name = (string)$row[1];
				$phone = (string)$row[2];
				$gender = (string)$row[3];
				$email = (string)$row[4];
				$username = (string)$row[5];
				$password = (string)$row[6];
			}
			
			if(trim($gender) == "Male")
			{
        echo "Congratulations, Mr <font color='blue'>$name</font>! Yours customer number is <font color='blue'>$id</font>. Yours phone number is <font color='blue'>$phone</font> and email address is <font color='blue'>$email</font>. And yours login username is <font color='blue'>$username</font> and password is <font color='blue'>$password</font>.";
			}
			else
			{
        echo "Congratulations, Mrs/Miss <font color='blue'>$name</font>! Yours customer number is <font color='blue'>$id</font>. Yours phone number is <font color='blue'>$phone</font> and email address is <font color='blue'>$email</font>. And yours login username is <font color='blue'>$username</font> and password is <font color='blue'>$password</font>.";
      }
		}
		mysqli_close($conn);
	}
?>