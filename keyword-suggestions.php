<html>
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
	<?php
		require "connect_db.php";
			$term = $_POST['term'];
			if(isset($term)){
				$query = "select query from query where query LIKE '".$term."%' limit 10";
				if($stmt = mysqli_prepare($db,$query)){
					mysqli_stmt_bind_param($stmt,'s',$query);
					mysqli_stmt_execute($stmt);
					mysqli_stmt_bind_result($stmt,$query);
					while(mysqli_stmt_fetch($stmt)){
						echo "$query";
						echo "<br>";
					}
				}
			}	
	?>
</html>