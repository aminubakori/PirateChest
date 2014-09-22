<?php
	if(!isset($_SESSION))
	{
	    ob_start();
	    session_start();
	}

	$user_model = $this->loadModel('UserModel');

	if(isset($_SESSION['pc_user']) || isset($_COOKIE['pc_user'])){
        if(isset($_COOKIE['pc_user'])) {
	        $userid = $_COOKIE['pc_user'];
	        $_SESSION['pc_user'] = $userid;
	    }
?>
<!DOCTYPE html>
<html>
	<head>
		<?php require 'application/views/_templates/linkrels.php'; ?>
		<script type="text/javascript">
			function new_chat_function() {
		        $.post("<?php echo URL; ?>chat/get/",
		        
		        function(data){
		            if (data != "" && data != "0") {
		            	$('div#messages').html(data);       
		            }
		        });
			}

			var chat = setInterval(function (ID) {
		        new_chat_function();
		    }, 20000);
		</script>
		<title>Chat - PirateChest</title>
	</head>

	<body class="metro">
		<header>
			<?php require 'application/views/_templates/header.php'; ?>
		</header>

		<section class="user">
			<div class="box">
				<div class="box20 sidenav">
					<ul class="sidenav">
						<a href="<?php echo URL; ?>"><li class="active">All files</li></a>
						<a href="<?php echo URL; ?>chat"><li>Pirate Chat</li></a>
						<a href="<?php echo URL; ?>logout"><li>Logout</li></a>
					</ul>
				</div>

				<div class="box80" style="height: 100%; overflow: scroll;">
					<h1><img src="<?php echo  URL; ?>public/img/favicon.png" width="60"> Pirate Chat</h1>
					<div class="chat">
						<div class="messages" id="messages">
							<?php
								$chats = $user_model->db->run('SELECT * FROM pc_chat ORDER BY ID DESC LIMIT 100');

						        foreach ($chats as $key => $chat) {
						            $ID = $chat['ID'];
						            $Username = $chat['Username'];
						            $Message = $chat['Message'];
						            $MsgColor = $chat['MsgColor'];

						            echo "
						                <div class='msg'>
						                    <p class='fg-".$MsgColor."'><b>".$Username."</b> - ".$Message."</p>
						                </div>
						            ";
						        }
							?>
						</div>

						<div class="form">
							<form method="post" action="<?php echo URL; ?>chat/add">
								<input name="username" id="username" value="<?php echo $user_model->db->select("pc_user", "ID = $userid")[0]['Username']; ?>" data-transform="input-control">
								<textarea name="message" id="message" data-transform="input-control" placeholder="Message"></textarea>

								<select data-transform="input-control" id="color" name="color">
									<option value="black">Black</option>
									<option value="red">Red</option>
									<option value="green">Green</option>
									<option value="blue">Blue</option>
								</select>
								<button class="large fg-white bg-black" type="submit">Send Message</button>
							</form>
						</div>
					</div>
				</div>
			</div>
		</section>
	</body>
</html>
<?php
	}elseif (isset($_SESSION['anonymous']) && $_SESSION['anonymous'] == true) {
		$dir = 'application/PirateChest/';

	    if(isset($_GET['dir']) && !empty($_GET['dir'])) {
	        $dir = trim(htmlentities($_GET['dir']))."/";
	    }
?>
<!DOCTYPE html>
<html>
	<head>
		<?php require 'application/views/_templates/linkrels.php'; ?>
		<script type="text/javascript">
			function new_chat_function() {
		        $.get("<?php echo URL; ?>chat/get/",
		        
		        function(data){
		            if (data != "" && data != "0") {
		            	$('div#messages').html(data);       
		            }
		        });
			}

			var chat = setInterval(function (ID) {
		        new_chat_function();
		    }, 20000);
		</script>
		<title>Chat - PirateChest</title>
	</head>

	<body class="metro">
		<header>
			<?php require 'application/views/_templates/header.php'; ?>
		</header>

		<section class="user">
			<div class="box">
				<div class="box20 sidenav">
					<ul class="sidenav">
						<a href="<?php echo URL; ?>"><li class="active">All files</li></a>
						<a href="<?php echo URL; ?>chat"><li>Pirate Chat</li></a>
						<a href="<?php echo URL; ?>logout"><li>Logout</li></a>
					</ul>
				</div>

				<div class="box80" style="height: 100%; overflow: scroll;">
					<h1><img src="<?php echo  URL; ?>public/img/favicon.png" width="60"> Pirate Chat</h1>
					<div class="chat">
						<div class="messages" id="messages">
							<?php
								$chats = $user_model->db->run('SELECT * FROM pc_chat ORDER BY ID DESC LIMIT 100');

						        foreach ($chats as $key => $chat) {
						            $ID = $chat['ID'];
						            $Username = $chat['Username'];
						            $Message = $chat['Message'];
						            $MsgColor = $chat['MsgColor'];

						            echo "
						                <div class='msg'>
						                    <p class='fg-".$MsgColor."'><b>".$Username."</b> - ".$Message."</p>
						                </div>
						            ";
						        }
							?>
						</div>

						<div class="form">
							<form method="post" action="<?php echo URL; ?>chat/add">
								<input name="username" id="username" value="Anonymous" data-transform="input-control">
								<textarea name="message" id="message" data-transform="input-control" placeholder="Message"></textarea>

								<select data-transform="input-control" id="color" name="color">
									<option value="black">Black</option>
									<option value="red">Red</option>
									<option value="green">Green</option>
									<option value="blue">Blue</option>
								</select>
								<button class="large fg-white bg-black" type="submit">Send Message</button>
							</form>
						</div>
					</div>
				</div>
			</div>
		</section>
	</body>
</html>
<?php
	}else {
		header("Location: ".URL);
	}
?>