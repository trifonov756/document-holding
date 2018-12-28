<?php
	session_start();

	unset($_SESSION['login']);
	if (isset($_POST['submit'])) {
		$_SESSION['login'] = $_POST['login'];
		header('Location: form.php');
	}
	$file_users = "docs/users.xml";
	$xml_users = simplexml_load_file($file_users);
	$logins = [];
	foreach ($xml_users as $user) {
		array_push($logins, $user->login);
	}
?>
<!DOCTYPE html>
<head lang="ru">
	<title>Согласование документа</title>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="assets/bootstrap.min.css"/>
	<link rel="stylesheet" type="text/css" href="assets/main.css">
</head>
<body>
	<div class="container">
		<br><br><br><br><br><br><br>
		<div class="row">
			<div class="offset-4 col-4">
				<form method="POST">
					<h1>Авторизация</h1>
					<br>
					<div class="input-group">
					  <select class="custom-select" name="login">
					   <?php foreach ($logins as $login): ?>
							<option value="<?=$login?>"><?=$login?></option>
						<?php endforeach; ?>
					  </select>
					  <div class="input-group-append">
					    <button name="submit" class="btn btn-success" type="submit">Выбрать</button>
					  </div>
					</div>
				</form>
			</div>
		</div>
	</div>
</body>
</html>