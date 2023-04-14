<!DOCTYPE html>
<html>
	<?php 
	//check if user is already logged in. 
	session_start(); if(isset($_SESSION['username'])) header("Location: ../docs/feed.php");
	session_regenerate_id(); //regenerate session id
	
	?>



	<head>
		<script src='https://www.google.com/recaptcha/api.js'></script>
		<meta charset="utf-8">
		<title>Login</title>
		<link href="../src/login.css" rel="stylesheet" type="text/css">
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
	</head>
	<body>
		<div class="login">
			<h1>Login</h1>
			<form action="../src/authenticate.php" method="post">
				<label for="username">
					<i class="fas fa-user"></i>
				</label>
				<input type="text" name="username" placeholder="Username" id="username" required>
				<label for="password">
					<i class="fas fa-lock"></i>
				</label>
				<input type="password" name="password" placeholder="Password" id="password" required>
				<div class="g-recaptcha" data-sitekey="6LcphAMaAAAAAGsk4TInD1DCSMxiMQO71239fRUH"></div>
				
				<a href="register.php">New user?<br>Click here to Register</a>
				
				<input type="submit" name='submit' value="Login">
				<!-- If captcha or username/password invalid output error -->
				<p class="error"><?php if(isset($_GET['captcha'])) echo "Captcha failed.<br>";?> 
				<p class="error"><?php if(isset($_GET['err'])) echo "Invalid username or password.<br>";?>

			</form>
		</div>
	</body>
</html>
