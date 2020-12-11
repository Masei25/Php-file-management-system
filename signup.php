<?php
	//to connect to database
	error_reporting(0);	
	$con = mysqli_connect('localhost','root','','uploaddb') or die(mysqli_error($con));
	

	if (isset($_POST['reg'])) {

		//to receive all input data
		$firstname = mysqli_real_escape_string($con, $_POST['fname']);
		$lastname = mysqli_real_escape_string($con,$_POST['lname']);
		$username = mysqli_real_escape_string($con, $_POST['username']);
		$password = mysqli_real_escape_string($con, $_POST['password']);

		//form validation to check if user exist
		$user_check = "SELECT username FROM users WHERE username='$username' ";
		$result = mysqli_query($con, $user_check);
		$user_fetch = mysqli_fetch_assoc($result);

		if (count($user_fetch) <= 0) {
			$sql = "INSERT INTO users (firstname, lastname, username, password) VALUES ('$firstname','$lastname','$username','$password')";
			mysqli_query($con,$sql);
			$msg="successful you can now log in";			
		}else{
			$msg = "Username already exist";		
		}	
	};

?>



<!DOCTYPE html>
<html>
<head>
	<title>File Management System</title>
		<link type="text/css" rel="stylesheet" href="bootstrap/bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="css/style.css">
        <script type="text/javascript" src="bootstrap/popper.min.js"></script> 
        <script type="text/javascript" src="bootstrap/jquery.min.js"></script>
        <script type="text/javascript" src="bootstrap/bootstrap.min.js"></script>
        
</head>
<body>
		


		<div class="container-fluid"> 
			<nav class="navbar navbar-expand-sm bg-dark navbar-dark">
				<a href="index.php"><h5><span class="hd">AIMTOGET</span></h5></a>
				<div class="header mr-auto">
				<ul class="navbar-nav">
					<li class="nav-item"><a class="nav-link" href="index.php">Login</a></li>
					<li class="nav-item"><a class="nav-link" href="signup.php">Sign Up</a></li>	
				</ul>
				</div>
				
			</nav>
			<div class="container">
			<div class="fm row">
				<div class="col-8">
					<table class="table table-striped">
						<thead>
							<tr>
								

								<th>S/N</th>
								<th>File Name</th>
								<th>Description</th>
								<th>Download</th>
							</tr>
						</thead>
						<tbody>
								<?php

									$select = mysqli_query($con,"SELECT * FROM upload");
									while($row=mysqli_fetch_array($select)){
										
										echo"<tr>
										<td>$row[id]</td>
										<td>$row[name]</td>
										<td>$row[descript]</td>
										<td><a href='downl.php?id=".$id."'>$row[name]</a></td>
										<tr>";
										
									}
								?>
							
						</tbody>	
					</table>	

					
				</div>
				<div class="fm col-4">
					<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
						<h2>Login your account</h2>
						<input type="text" class="form-control" name="fname" placeholder="First Name" required><br>
						<input type="text" class="form-control" name="lname" placeholder="Last Name" required><br>
						<input type="text" class="form-control" name="username" placeholder="user name" required><br>
						<input type="password" class="form-control" name="password" placeholder="password" required><br>
						<button class="btn btn-info" type="submit" name="reg" id="reg">Submit</button>

						<h4><?php echo $msg; ?></h4>
					</form>
				</div>
				
					
			</div>
			</div>

		</div>



</body>
</html>