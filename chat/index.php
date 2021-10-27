<?php 

	session_start();

	if($_SESSION['logado']){

		//...

	}else{

		header('Location: login.php');

	}
	
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>DRAKO CHAT</title>
	<link rel="stylesheet" type="text/css" href="assets/css/style.css">
</head>
<body>
	<div class="content">
		<div class="app">
			<div class="chats">

				<?php 

					include('includes/classes.php');

					$pdo = MySql::connect();

					$pdo = $pdo->prepare("SELECT * FROM friends WHERE user1 = ? OR user2 = ?");

					$pdo->execute(array($_SESSION['user_id'], $_SESSION['user_id']));

					$pdo = $pdo->fetchAll();

					foreach ($pdo as $key => $value) {
						
						if($value['user1'] == $_SESSION['user_id']){

							$f_id = $value['user2'];

						}else{

							$f_id = $value['user1'];

						}

						$pdo = MySql::connect();

						$pdo = $pdo->prepare("SELECT * FROM chat WHERE fromm = ? OR tom = ? GROUP BY id DESC");

						$pdo->execute(array($f_id, $f_id));

						$pdo = $pdo->fetchAll();

						@$f_name = Functions::getUserById($f_id)[0]['name'];

						@$f_ultima_msg = $pdo[0]['content'];

						if($pdo[0]['fromm'] == $_SESSION['user_id']){

							$f_ultima_msg = 'Você: '.$f_ultima_msg;

						}

						echo "<a href='server.php?chat=$f_id'>
								<div class='one_chat'>
									<div>",$f_name,"</div>
									<div>",$f_ultima_msg,"</div>
								</div>
							</a>";

					}

				?>

			</div>
			<div style="width: 100%;">
				<div class="messages">
					
					<?php 

						$pdo = MySql::connect();

						$pdo = $pdo->prepare("SELECT * FROM chat WHERE tom = ? AND fromm = ? OR tom = ? AND fromm = ?");

						$pdo->execute(array($_SESSION['user_id'], @$_SESSION['chat'], @$_SESSION['chat'], $_SESSION['user_id']));

						$pdo = $pdo->fetchAll();

						foreach ($pdo as $key => $value) {

							$data_formated = explode(":", $value['data']);

							$data_formated = $data_formated[0].":".$data_formated[1];
							
							if($value['fromm'] == $_SESSION['user_id']){

								echo "<div class='msg_from_me'><a>",$value['content']," <strong>$data_formated</strong></a></div>";

							}else{

							    echo "<div class='msg_to_me'><a>",$value['content']," <strong>$data_formated</strong></a></div>";

							}

						}

					?>

				</div>
				<div class="message_inputs">
				<input type="text" name="msg_input" id="msg" placeholder="Mensagem">
				<button style="padding: 10px;" type="submit" onclick="send_msg()">ENVIAR !</button>
				</div>
			</div>
		</div>
	</div>
</body>
<script type="text/javascript" src="app.js"></script>
</html>