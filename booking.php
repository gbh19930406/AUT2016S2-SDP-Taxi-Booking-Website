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
		$v_type = $_POST["v-type"];
		$v_seat = $_POST["v-seat"];
		$up_unit = $_POST["up-unit"];
		$up_street = $_POST["up-street"];
		$up_suburb = $_POST["up-suburb"];
		$up_datetime = $_POST["up-datetime"];
		$off_unit = $_POST["off-unit"];
		$off_street = $_POST["off-street"];
		$off_suburb = $_POST["off-suburb"];
		$book_datetime = $_POST["book-datetime"];
		
		$queryCreateTable = "CREATE TABLE IF NOT EXISTS `booking` (`ref` int(10) unsigned zerofill NOT NULL AUTO_INCREMENT,`c_name` varchar(100) NOT NULL,`c_phone` varchar(25) NOT NULL,`v_type` VARCHAR(20) NOT NULL DEFAULT '',`v_seat` INT(2) NOT NULL DEFAULT '0',`up_unit` varchar(5) DEFAULT NULL,`up_street` varchar(50) NOT NULL,`up_suburb` varchar(20) NOT NULL,`up_datetime` timestamp NOT NULL DEFAULT '1970-01-02 00:00:00',`off_unit` varchar(5) DEFAULT NULL,`off_street` varchar(50) NOT NULL,`off_suburb` varchar(20) NOT NULL,`status` enum('unassigned','assigned') NOT NULL DEFAULT 'unassigned',`book_datetime` timestamp DEFAULT CURRENT_TIMESTAMP,PRIMARY KEY (`ref`)) ENGINE=InnoDB DEFAULT CHARSET=utf8;"; 
		
		mysqli_query($conn, $queryCreateTable);
		
		$queryInsert = "INSERT INTO `booking` (`c_name`, `c_phone`, `v_type`, `v_seat`, `up_unit`, `up_street`, `up_suburb`, `up_datetime`, `off_unit`, `off_street`, `off_suburb`, `book_datetime`) VALUES ('$c_name', '$c_phone', '$v_type', '$v_seat', '$up_unit', '$up_street', '$up_suburb', '$up_datetime', '$off_unit', '$off_street', '$off_suburb', '$book_datetime');";

		$insertResult = mysqli_query($conn, $queryInsert);
		
		if(!$insertResult)
		{
			echo "<font color='red'>$queryInsert</font>";
		} 
		else
		{
			$querySelect = "SELECT `ref`, `c_name`, `up_unit`, `up_street`, `up_suburb`, `up_datetime` from `booking` where `up_datetime` like '$up_datetime'";
			
			$selectResult = mysqli_query($conn, $querySelect);
			
			$ref = "0";
			$name = "";
			$unit = "";
			$street = "";
			$suburb = "";
			$datetime = "";
			$time = "";
			$date = "";
			
			while($row = mysqli_fetch_row($selectResult))
			{
				$ref = (string)$row[0];
				$name = (string)$row[1];
				$unit = (string)$row[2];
				$street = (string)$row[3];
				$suburb = (string)$row[4];
				$datetime = (string)$row[5];
				$date = substr($datetime,0,10);
				$time = substr($datetime,11,5);
			}
			
			if(trim($unit) == "")
			{
        echo "Thank you, $name! Your booking reference number is $ref. You will be picked up on $street, $suburb at $time on $date.";
			}
			else
			{
        echo "Thank you, $name! Your booking reference number is $ref. You will be picked up on $unit/$street, $suburb at $time on $date.";
      }
		}
		mysqli_close($conn);
	}
?>