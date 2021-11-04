<?php 

	session_start();

	ob_start();

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
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Open+Sans&display=swap" rel="stylesheet">
</head>
<body>
	<div class="content">
		<div class="app">
			<div class="chats">

				<?php 

					echo "<div class='chats_header'>
							<div style='width: 90%'>
								<div class='profile_pic'>
									<img style='margin-left: 5px;' src='assets/images/profile_pics/",$_SESSION['user_id'],".png'>
								</div>
							</div>
							<div class='chats_header_options'>
								<div style='display: flex;'>
									<a href=''><i class='fas fa-comment-medical'></i></a>
									<a href=''><i class='fas fa-ellipsis-v'></i></a>
								</div>
							</div>
						  </div>";

					echo "<div style='height: 10px;'></div>";

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

						$data_formated = explode(":", $pdo[0]['data']);

						$data_formated = $data_formated[0].":".$data_formated[1];

						if($pdo[0]['fromm'] == $_SESSION['user_id']){

							$f_ultima_msg = 'Você: '.$f_ultima_msg;

						}

						echo "<a href='server.php?chat=$f_id'>
								<div class='one_chat'>
									<div class='profile_pic'><img style='margin-left: 5px;' src='assets/images/profile_pics/$f_id.png'></div>
									<div style='width: 100%;padding: 5px 10px 0px;'>
										<div>",$f_name,"</div>
										<div>",$f_ultima_msg," <p>$data_formated</p></div>
									</div>
								</div>
							</a>";

					}

				?>

			</div>
			<style type="text/css">
				.messages{
					width: 100%;
				    background-image: url(assets/images/chat_background/bg_dark.jpg);
					background-repeat: no-repeat;
				    background-position: center;
				}
			</style>
			<div style="width: 100%;">

					<?php 

						$pdo = MySql::connect();

						$pdo = $pdo->prepare("SELECT * FROM chat WHERE tom = ? AND fromm = ? OR tom = ? AND fromm = ?");

						$pdo->execute(array($_SESSION['user_id'], @$_SESSION['chat'], @$_SESSION['chat'], $_SESSION['user_id']));

						$pdo = $pdo->fetchAll();

						echo "
								<div class='chat_header'>
									<div class='profile_pic'><img src='assets/images/profile_pics/$f_id.png'></div>
									<div class='chat_header_name'><strong>",$f_name,"</strong></div>
								</div>
							";

						echo "<div class='messages'>";

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
				<a href="" onclick="send_msg()"><i class="fas fa-paper-plane"></i></a>
				</div>
			</div>
		</div>
	</div>
</body>
<script type="text/javascript" src="app.js"></script>
<script src="https://kit.fontawesome.com/bb2a181e2f.js" crossorigin="anonymous"></script>
</html>