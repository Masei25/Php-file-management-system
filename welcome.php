<?php
	session_start();
	// error_reporting(0);	

	require __DIR__."/lib/Library.php";
    require "helper.php";
    
    $app = new Library();

	if (!(isset($_SESSION['id']))) {
		header('Location:index.php?error=nologin');
	}

	//to file delete
	if(isset($_GET['id'])){
		$id = $_GET['id'];
		$query = "DELETE FROM upload WHERE id = $id"; 
		$result = $app->connection->query($query);
		$msg = 'File successfully deleted';
	}

	$user = "SELECT * FROM users WHERE id='$_SESSION[id]'";
	$user = $app->connection->query($user);
	$user = $user->fetch(1);
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

		if (!empty($_POST['upload'])) {
			$file = $_FILES['file'];
			$name = input($_POST['name']);
			
			
			if (!($file['error']) && !empty($name)) {
				$fileName = $file['name'];
				$fileExt = explode('.',$fileName)[1];
				$fileSize = $file['size'];
				$fileTmp = $file['tmp_name'];
				$fileNewName = uniqid().'.'.$fileExt;
				
				if($fileSize > 500000) {
					alert("File size too large");
					header('Location :'. $_SESSION['HTTP_REFERER']);
				}
	
				$statement = "INSERT INTO upload (name, file, userid) VALUES('$name', '$fileNewName', '$_SESSION[id]')";

				try {
					$app->connection->exec($statement);
					move_uploaded_file($fileTmp, "uploads/".$fileName);
					alert("File upload successful");
				} catch (\PDOException $e) {
					exit($e->getMessage());
				}
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
					<table class="table table-striped">
						<thead>
							<tr>	
								<th>S/N</th>
								<th>File Name</th>
								<th>Access</th>
								<th>Delete</th>
							</tr>
						</thead>
						<tbody>
							
								<?php
									$statement = "SELECT * FROM upload WHERE userid='$_SESSION[id]' ORDER BY id ASC";
									$statement = $app->connection->query($statement);
									foreach ($rows = $statement->fetchAll(\PDO::FETCH_ASSOC) as $row) {
										
										$name = $row['name'];
										$id = $row['id'];
										$filename = $row['file'];
				
										echo"<tr>
										<td>$row[id]</td>
										<td>$row[name]</td>
										<td>$row[access_level]</td>
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
					<h2>Welcome <?php echo $user['username']; ?></h2>
					<p>you can now upload your file</p>
				</div>
				<form method="post" action="" enctype="multipart/form-data">
					<input type="file" name="file" id="file">
					<input type="text" name="name" id="name" placeholder="File Name" required>
					<input type="submit" name="upload" value="upload file">	
				</form>
					
		</div>



</body>
</html>