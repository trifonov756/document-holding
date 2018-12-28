<?php 
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Проведение документа</title>
	<link rel="stylesheet" href="assets/bootstrap.min.css">
	<link rel="stylesheet" href="assets/style.css"/>
</head>
<body>
	<div id="template" class="container">
	<div class="row">
		<div class="col-12">
			<form method="POST">
			<!-- <h1 class="head_title text-center"></h1> -->
			<div class="change_block">
				<div class="col-12">
					<div class="content_wrapper">
						<div class="content">
							<h3 class="user text-center"><?=$_SESSION['error']?></h3>
							
						</div>
					</div>
				</div>
			</div>
			<div class="col-6 offset-3 text-center">
				<a class="confirm btn btn-danger btn-lg btn-block" href="index.php">Попробовать снова</a>
			</div>
			</form>
		</div>
	</div>
</div>
</body>
</html>