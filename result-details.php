<html>
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
	<?php
		$id = $_POST['id'];
		require "connect_db.php";
		if(isset($id)){
			$query = "select title,genre,keywords,duration,color,sound,sponsorname from p4records where videoid=".$id;
			if($stmt = mysqli_prepare($db,$query)){
				mysqli_stmt_bind_param($stmt,'i',$id);
				mysqli_stmt_execute($stmt);
				mysqli_stmt_bind_result($stmt,$title,$genre,$keywords,$duration,$color,$sound,$sponsorname);
				while(mysqli_stmt_fetch($stmt)){
					echo "<h2><b>".$title."</b></h2><br>
					<p><b>Genre:</b> ".$genre."</p>
					<p><b>Keywords</b>: ".$keywords."</p>
					<p><b>Duration</b>: ".$duration."</p>
					<p><b>Color</b>: ".$color."</p>
					<p><b>Sound</b>: ".$sound."</p>
					<p><b>Sponsor</b>: ".$sponsorname."</p>";
				}
			}
		}	
	?>
</html>