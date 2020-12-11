<?php
	session_start();
	error_reporting(0);	

	//connect to database
	$con = mysqli_connect('localhost','root','','uploaddb') or die(mysqli_error($con));

	if (!(isset($_SESSION['username']))) {
		header('Location:index.php?error=nologin');
	}

	//to file delete
	if(isset($_GET['id'])){
		$id = $_GET['id'];
		$query = "DELETE FROM upload WHERE id = $id"; 
		$result = mysqli_query($con, $query);
		$msg = 'File successfully deleted';
	}


	if (isset($_POST['username'], $_POST['password'])) {
		$username = stripcslashes($_POST['username']);
		$password = mysqli_real_escape_string($con, $_POST['password']);

		$query = "SELECT username, password FROM users WHERE username='$username' AND password='$password'";
		$res = mysqli_query($con, $query);

		if (mysqli_num_rows($res) == 1) {
			while ($check = mysqli_fetch_array($res)) {
				echo "success";
			}
		}
		else{
			echo "<p>Username or password is incorrect</p>";
		}
	}
?>

<!DOCTYPE html>
<html>
<head>
	<title>File Management System</title>
		<link type="text/css" rel="stylesheet" href="bootstrap/bootstrap.min.css">
		<link type="text/css" rel="stylesheet" href="bootstrap/font-awesome/css/font-awesome.css">
    	<link type="text/css" rel="stylesheet" href="bootstrap/font-awesome/css/font-awesome.min.css">
        <link rel="stylesheet" type="text/css" href="css/style.css">
        <script type="text/javascript" src="bootstrap/popper.min.js"></script> 
        <script type="text/javascript" src="bootstrap/jquery.min.js"></script>
        <script type="text/javascript" src="bootstrap/bootstrap.min.js"></script>
        
</head>
<body>
		<?php

		$pictures = $_FILES['pictures'];
		$descript = $_POST['descript'];
		if (!($pictures['error'])) {
			$picturename = $pictures['name'];
			$temp = $pictures['tmp_name'];

			if ($_POST['uploadfile'] != "") {
				move_uploaded_file($temp, "docc/".$picturename);
				$insert = mysqli_query($con, "INSERT INTO upload(name,descript) VALUES ('$picturename','$descript')");
				$success = "File upload successful";
			}
		}
		?>


		<div class="container-fluid"> 
			<nav class="navbar navbar-expand-sm bg-dark navbar-dark">
				<a href="#"><h5><span class="hd">AIMTOGET</span></h5></a>
				<div class="header mr-auto">
				<ul class="navbar-nav">
					<li class="nav-item"><a class="nav-link" href="<?php $_SERVER['PHP_SELF']; ?>"><i style="color: white;" class="fa fa-user"></i></a></li>
					<li class="nav-item"><a class="nav-link" href="logout.php">Logout</a></li>		
				</ul>
				</div>
				
			</nav>
			<div class="container">
			<div class="fm row">
				<div class="col-8">
					
				<div class="alert alert-light">
					<?php
						//it output the message delete message and return to default page
						$getUrl = $_SERVER['REQUEST_URI'];
						echo '<strong>'.$msg.'</strong>';
						if(strpos($getUrl,'?') != false){
							header('Refresh: 2; URL=welcome.php');
						}
					?>
				</div>

					<table class="table table-striped">
						<thead>
							<tr>	
								<th>S/N</th>
								<th>File Name</th>
								<th>Description</th>
								<th>File</th>
								<th>Delete</th>
							</tr>
						</thead>
						<tbody>
							
								<?php

									$select = mysqli_query($con,"SELECT * FROM upload ORDER BY id DESC");
									while($row=mysqli_fetch_array($select)){
										$name = $row['name'];
										$id = $row['id'];
										$filename = $row['file'];
										$type = $row['type'];
				
										echo"<tr>
										<td>$row[id]</td>
										<td>$row[name]</td>
										<td>$row[descript]</td>
										<td><a href='download.php?filename=".$name."'>$row[name]</a></td>
										<td><a href='#' data-toggle='modal' data-target='#confirm-delete$row[id]'>Delete</a></td>
										<tr>
										
										<div class='modal fade' id='confirm-delete$row[id]' tabindex='-1' role='dialog' aria-labelledby='myModalLabel' aria-hidden='true'>
										<div class='modal-dialog'>
										<div class='modal-content'>
											<div class='modal-header'>
												
											</div>
											<div class='modal-body'>
											Are you sure you want to delete this file
											</div>
											<div class='modal-footer'>
												<button type='button' class='btn btn-default' data-dismiss='modal'>Cancel</button>
												<a href='welcome.php?id=".$id."' class='btn btn-danger btn-ok'>Delete</a>
											</div>
										</div>
									</div>
								</div>";
								}

								?>		
						</tbody>	
					</table>
					
				</div>
				<div class="fm col-4">
					<h2>Welcome <?php echo $_SESSION['username']; ?></h2>
					<p>you can now upload your file</p>
				</div>
				<form method="post" action="" enctype="multipart/form-data">
						<input type="file" name="pictures" id="pictures">
						<input type="text" name="descript" id="descript" placeholder="Description">
						<input type="submit" name="uploadfile" id="uploadfile" value="upload file">
						
					</form>
					
			</div>
			<h5 style="margin-top: 20px"><?php echo $success ;?></h5>
			</div>
		</div>



</body>
</html>