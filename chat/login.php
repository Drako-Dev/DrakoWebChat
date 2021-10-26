<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>DRAKO CHAT</title>
</head>
<body>
	<div>
		<form method="POST">
			<input type="text" name="user" placeholder="Usuario">
			<input type="pass" name="pass" placeholder="Senha">
			<button type="submit">LOGIN!</button>
		</form>
	</div>
	
	<?php

		session_start();

		if(isset($_POST['user'])){

			include('includes/classes.php');

			@$user = $_POST['user'];

			@$pass = $_POST['pass'];

			$pdo = MySql::connect();

			$pdo = $pdo->prepare("SELECT * FROM users WHERE user = ? AND pass = ?");

			$pdo->execute(array($user, $pass));

			$fpdo = $pdo->fetch();

			if($pdo->rowCount() > 0){

				$_SESSION['logado'] = true;

				$_SESSION['user_id'] = $fpdo['id'];

				header('Location: index.php');

			}else{

				echo "Usuario ou senha incorretos";

			}

		}

	?>

</body>
</html>