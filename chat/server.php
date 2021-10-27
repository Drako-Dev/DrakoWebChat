<?php 

	session_start();

	include('includes/classes.php');

	if(@$_GET['chat']){

		$_SESSION['chat'] = @$_GET['chat'];

		header("Location: index.php");

	}

	if(@$_GET['send']){

		$pdo = MySql::connect();

		$pdo = $pdo->prepare("INSERT INTO chat (id, fromm, tom, content, data) VALUES (null, ?, ?, ?, ?)");

		date_default_timezone_set('America/Sao_Paulo');

		$hora_atula = date('H:i:s');

		$pdo->execute(array($_SESSION['user_id'], $_SESSION['chat'], @$_GET['send'], $hora_atula));

	}

	$pdo = MySql::connect();

	$pdo = $pdo->prepare("SELECT * FROM chat WHERE tom = ? AND fromm = ? OR tom = ? AND fromm = ? GROUP BY id DESC");

	$pdo->execute(array($_SESSION['user_id'], @$_SESSION['chat'], @$_SESSION['chat'], $_SESSION['user_id']));

	$pdo = $pdo->fetch();

	$data_formated = explode(":", $pdo['data']);

	$data_formated = $data_formated[0].":".$data_formated[1];

	if($pdo['fromm'] == $_SESSION['user_id']){

		echo "<div class='msg_from_me'><a>",$pdo['content']," <strong>$data_formated</strong></a></div>";

	}else{

		echo "<div class='msg_to_me'><a>",$pdo['content']," <strong>$data_formated</strong></a></div>";

	}

?>