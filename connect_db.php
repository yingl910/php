<?php
		$h = "pearl.ils.unc.edu";
		$u = "webdb12";
		$p = "liang1401";
		$dbname = "webdb12";
		$db = mysqli_connect($h,$u,$p,$dbname);
		if(mysqli_connect_errno()){
			echo "The problem is".mysqli_connect_error();
			exit();
		}		
?>