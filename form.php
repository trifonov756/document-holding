<?php
	session_start();
	$login = $_SESSION['login'];
	$file = (file_exists('docs/result.xml'))? 'result.xml': 'input.xml';
	$doc =  simplexml_load_file('docs/'.$file);

	$current_process = $doc->xpath('//process[not(@result)]')[0]; // первый процесс без записанного результата
	if($current_process == false){
		header('Location: document.php');
	}
	if($current_process->xpath('./user[text() = "'.$login.'" and @choise]')){
		$_SESSION['error'] = 'Пользователь '.$login.' уже внес своё решение';
		header('Location: error.php');
	}
	if(array_search($login, (array)$current_process->user) === false){
		$_SESSION['error'] = 'Пользователь '.$login.' не может проводить документ';
		header('Location: error.php');
	}
	if(isset($_POST['confirm'])){
		//добавление результата пользователя
		foreach($current_process->user as $user){
			if($user == $login){
				if(!$user->attributes()['choise']) $user->addAttribute('choise', $_POST['verify']);
			}
		}
		//проверка на проведение всеми юзерами
		if(count($current_process->xpath("./user")) == count($current_process->xpath("./user[@choise]"))){ //все юзеры заполнены
			//добавление результата процесса
			if($current_process->attributes()['operation'] == 'or'){
				if(count($current_process->xpath('./user[@choise = "y"]')) >= 1){
					$current_process->addAttribute('result', 'y');
				} else {
					$current_process->addAttribute('result', 'n');
				}
			} else
			if($current_process->attributes()['operation'] == 'and' || $current_process->attributes()['operation'] == null){
				if(count($current_process->xpath('./user[@choise = "n"]')) >= 1){
					$current_process->addAttribute('result', 'n');
				} else {
					$current_process->addAttribute('result', 'y');
				}
			}
		}
		$doc->asXML('docs/result.xml');
		//начать проверку проведения всего документа
		$status = 'в проведении...';
		if($doc->xpath('//process[not(@result)]') == null){
			if(count($doc->xpath('//process[@result="y"]')) == $doc->process->count()){
				$status = 'проведен';
			} else{
				$status = 'НЕ проведен';
			}
		}
		$_SESSION["status"] = $status;
		header('Location: document.php');
	}
	
	$doc_title = $doc->attributes()['title'];
	$step = $current_process->attributes()['step'];
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
			<h1 class="head_title text-center">Проведение документа «<?=$doc_title?>»</h1>
			<div class="change_block">
				<div class="col-12">
					<div class="content_wrapper">
						<div class="content">
							<h2 class="user text-center"><?=$login?></h2>
							<div class="row">
								<div class="col-6 text-center change">
									<div class="custom-control custom-radio custom-control-inline">
										<input type="radio" id="customRadio1" name="verify" value="y" class="custom-control-input" checked>
										<label class="custom-control-label" for="customRadio1">Да</label>
									</div>
								</div>
								<div class="col-6 text-center change">
									<div class="custom-control custom-radio custom-control-inline">
										<input type="radio" id="customRadio2" name="verify" value="n" class="custom-control-input">
										<label class="custom-control-label" for="customRadio2">Нет</label>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-6 offset-3 text-center">
				<button name="confirm" type="submit" class="confirm btn btn-success btn-lg btn-block">Согласовать</button>
			</div>
			</form>
		</div>
	</div>
</div>
</body>
</html>