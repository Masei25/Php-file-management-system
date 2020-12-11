<?php
	session_start();
	error_reporting(0);
	
	$con = new mysqli('localhost','root', '', 'uploaddb');

	if($con->connect_error) {
		die("failed to connect: ". $con->connect_error);
	}
	


	if (isset($_POST['username'], $_POST['password'])) {
		$username = stripcslashes($_POST['username']);
		$password = mysqli_real_escape_string($con, $_POST['password']);

		$query = "SELECT username, password FROM users WHERE username='$username' AND password='$password'";
		$res = mysqli_query($con, $query);

		if (mysqli_num_rows($res) == 1) {
			while ($check = mysqli_fetch_array($res)) {
				$_SESSION['username'] = $check['username'];
				$_SESSION['password'] = $check['password'];	
			}
				$_SESSION['username'] = $_POST['username'];
				header("Location: welcome.php");
		}
		else{
			$error =  "<p>Incorrect login detail</p>";
		}

	}

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
		<!--to upload file-->



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
								<th>File</th>
							</tr>
						</thead>
						<tbody>
							

								<?php
									$select = mysqli_query($con, "SELECT * FROM upload ORDER BY id ASC");
										while($row=mysqli_fetch_array($select)){
											
											//date_default_timezone_set("Europe/Paris");
											$name = $row['name'];
											$id = $row['id'];
											$filename = $row['file'];
										
										echo"<tr>
										<td>$row[id]</td>
										<td>$row[name]</td>
										<td>$row[descript]</td>
										<td><a href='download.php?filename=".$name."'>$row[name]</a></td>
										<tr>";
										
									}
								?>
							
						</tbody>	
					</table>	

					
				</div>
				<div class="fm col-4">
					<form method="post" action="index.php">
						<h2>Login your account</h2>
						<input type="text" class="form-control" name="username" placeholder="user name"><br>
						<input type="password" class="form-control" name="password" placeholder="password"><br>
						<button class="btn btn-info" type="submit" name="button">Submit</button>

						
					</form>
					<h4><?= $error?? ""; ?></h4>
				</div>					
			</div>
			<h5 style="margin-top: 20px"><?= $success ?? "" ;?></h5>
			</div>

		</div>


</body>
</html>