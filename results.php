<html>
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
	<script>
	
	//query suggestion JQuery AJAX
		$(document).ready(function(){
			$('#term').keyup(function(){ 
				var word = document.getElementById('term').value;
				$.ajax({
					method: "post",
					url: "keyword-suggestions.php",
					data: {
						term: word,
					},
					dataType: "html",
					success: function(data,status){
						$("#suggustion").html(data);
					}
				}); 
			});
		});
		
	//result detail JQuery AJAX	
			$(document).ready(function(){
				$('tr').mouseover(function(){ 
					var videoid = $(this).attr('videoid');
					$.ajax({
						method: "post",
						url: "result-details.php",
						data: {
							id:videoid,
						},
						dataType: "html",
						success: function(data,status){
							$("#detail").html(data);
						}
					});
				}); 
				$('tr').mouseleave(function(){ 
					$("#detail").text("");
				}); 
			});
	</script>
	
	<!--The search box: area B-->
	<div name = 'blockb' style="position:fixed;width:200px;top:50px;left:30px">
		<form action = 'results.php' method = 'get'>
			<input type = 'text' name = 'term' id= 'term'>
			<input type = 'submit' value = 'search'>
		</form>
	</div>
	
	<!--The search result: area A-->
	<div name = 'blocka' style="position:fixed;width:600px;left:300px;top:5px">
		<h1>Open Video</h1>
		<?php
			session_start();
			$user = $_POST['username'];
			$pass = $_POST['password'];
			if (isset($user) && isset($pass)){ 
				require "connect_db.php";
				$query = "select password from p4users where username = '".$user."'";
				if($stmt = mysqli_prepare($db,$query)){
					mysqli_stmt_bind_param($stmt,'s',$password);
					mysqli_stmt_execute($stmt);
					mysqli_stmt_bind_result($stmt,$password);
					if(mysqli_stmt_fetch($stmt)){
						if ($pass == $password){
							$_SESSION['user'] = $user;
						}
					}
					else{
						echo "<p>Invalid User. Please try again.</p>";
					}
				}
	
			};
			if(isset($_SESSION['user'])){
				echo "<p style= 'position:fixed;right:50px;top:5px'>Hello ".$_SESSION['user']."<a href='logout.php'>(log out)</a></p>";
				$term = $_GET['term'];
				if(isset($term)){
					require "connect_db.php";
					$query = "select videoid,title,description,creationyear,keyframeurl from p4records where match (title, description, keywords) against ('".$term."')";
					if($stmt = mysqli_prepare($db,$query)){
						mysqli_stmt_bind_param($stmt,'s',$term);
						mysqli_stmt_execute($stmt);
						mysqli_stmt_bind_result($stmt,$videoid,$title,$description,$creationyear,$keyframeurl);
						echo "Showing results for: ". $term;
						echo "<table border= 1>";
						while(mysqli_stmt_fetch($stmt)){
							$description = substr($description,0,200);
							echo "<tr videoid=".$videoid.">
								<td rowspan='2'><a href = 'http://www.open-video.org/details.php?videoid=".$videoid."'>"."<image src='http://www.open-video.org/surrogates/keyframes/".$videoid."/".$keyframeurl."'></a></td>
								<td height = 50><b><a href = 'http://www.open-video.org/details.php?videoid=".$videoid."'>".$title."</a> (".$creationyear.")"."</b></td>
							</tr>
							<tr videoid=".$videoid."><td height = 50>".$description."</td></tr>";
						}
						echo "</table>";
					}
				}
			}
			else{
				echo "<form method='post' action='results.php'>
					Username:&nbsp;<input type='text' name='username'><p> 
					Password:&nbsp;<input type='password' name='password'><p> 
					<input type='submit' value='Log In'>
					</form>";
					}
			
		?>
	</div>
	
	<!--The suggested queries: area C-->
	<div name = 'blockc' style="position:fixed;width:200px;top:200px;left:30px">
		<p>Suggestions:</p>
		<div id = 'suggustion'></div>
	</div>
	
	<!--The result detail: area D-->
	<div name = 'blockd' style="position:fixed;width:300px;left:1000px;top:20px">
		<div id='detail'></div>
	</div>
	
</html>
