<?php

// error_reporting(0);	
	require __DIR__."/lib/Library.php";
    require "helper.php";
    
    $app = new Library();

	if (!empty($_POST['btnSubmit'])) {
		$firstname = input($_POST['firstname']);
		$lastname = input($_POST['lastname']);
		$username = input($_POST['username']);
		$password = input($_POST['password']);
		
		if ($firstname == "") {
            alert("Firstname field is required");
            die();
        }

        if ($lastname == "") {
            alert("Lastname field is required");
            die();
        }

		if ($username == "") {
            alert("Username field is required");
            die();
        }

        if ($password == "") {
            alert("Password field is required");
            die();
        }

		$app->register($firstname,$lastname,$username,$password);
		alert("Registration Successful, login to continue");
		header('Location:index.php');
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
								<th>Access Level</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody>
							<?php
									$statement = "SELECT * FROM uploads ORDER BY id ASC";
                                    $statement = $app->connection->query($statement);
                                        foreach ($rows = $statement->fetchAll(\PDO::FETCH_ASSOC) as $row) {
											
											$id = $row['id'];
											$name = $row['name'];
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
					<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
						<h2>Login your account</h2>
						<input type="text" class="form-control" name="firstname" placeholder="First Name" required><br>
						<input type="text" class="form-control" name="lastname" placeholder="Last Name" required><br>
						<input type="text" class="form-control" name="username" placeholder="user name" required><br>
						<input type="password" class="form-control" name="password" placeholder="password" required><br>
						<input class="btn btn-info" type="submit" name="btnSubmit">
					</form>
				</div>
				
					
			</div>
			</div>

		</div>



</body>
</html>