<?php 
session_start();
$file = (file_exists('docs/result.xml'))? 'result.xml': 'input.xml';
$doc = simplexml_load_file('docs/'.$file);
$processes = $doc->xpath('//process');
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
			<div class="change_block">
				<div class="col-12">
					<div class="content_wrapper">
						<div class="content">
							<h2 class="user text-center">Вы снесли своё решение</h2>
							<h3 class="user text-center" style="text-decoration: underline;">Документ <?=$_SESSION['status']?></h3>
							<div class="user_block">
								<?php
									for($i = 0; $i < count($processes); $i += 1):
								?>
								<div class="row justify-content-center">
								<?php	
									//$count_users = $doc->xpath('//process')[$i]->count();	
									for($j = 0; $j < count($processes[$i]); $j += 1):
								?>
									<div class="col-2 <?=$processes[$i]->user[$j]->attributes()['choise'] ?>"><?=$processes[$i]->user[$j] ?></div>
								<?php	
										endfor;
								?>
								</div>
								<?php	
									endfor;
								?>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-6 offset-3 text-center">
				<a class="confirm btn btn-success btn-lg btn-block" href="index.php">Провести c другого пользователя</a>
			</div>
			</form>
		</div>
	</div>
</div>
</body>
</html>