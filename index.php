<?php
    if(!isset($_SESSION)) {
		session_start();
	}
    // error_reporting(0);

    require __DIR__."/lib/Library.php";
    require "helper.php";
    
    $app = new Library();
	
	$app->Auth('id');

    if (!empty($_POST['btnSubmit'])) {
		$userinput = trim($_POST['userinput']);
        $password = input($_POST['password']);

        if (empty($userinput)) {
            alert("Username field is required");
            die();
        }

        if (empty($password)) {
            alert("Password field is required");
            die();
        }

        $user_id = $app->login($userinput, $password);
        dd('out not correct');
        if ($user_id > 0) {
            $_SESSION['id'] = $user_id;
            header("Location: welcome.php");
        }

        if (!($user_id > 0)) {
            alert("Incorrect login detail");
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
					<li class="nav-item"><a class="nav-link" href="register.php">Register</a></li>	
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
								<th>Access Type</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody>
								<?php
									$statement = "SELECT * FROM uploads WHERE access_level=1 ORDER BY id ASC";
                                    $statement = $app->connection->query($statement);
                                        foreach ($rows = $statement->fetchAll(\PDO::FETCH_ASSOC) as $row) {
											
											$id = $row['id'];
											$name = $row['name'];
                                            $filename = $row['file'];
											$access = $row['access_level'];
											if($access == '1') {
												$access = 'Public';
											}
                                        
                                            echo"<tr>
													<td>$row[id]</td>
													<td>$row[name]</td>
													<td>$access</td>
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
						<input type="text" class="form-control" name="userinput" placeholder="user name"><br>
						<input type="password" class="form-control" name="password" placeholder="password"><br>
						<input class="btn btn-info" type="submit" name="btnSubmit">
					</form>
					<h4><?= $error?? ""; ?></h4>
				</div>					
			</div>
			<h5 style="margin-top: 20px"><?= $success ?? "" ;?></h5>
			</div>

		</div>


</body>
</html>