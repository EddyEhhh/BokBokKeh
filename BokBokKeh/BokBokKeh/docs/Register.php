<!DOCTYPE html>
<html>
	<?php 
	
	//check for session    
	session_start(); if(isset($_SESSION['username'])) header("Location: ../docs/feed.php");
	session_regenerate_id();
	?>

	<head>
		<meta charset="utf-8">
		<script src='https://www.google.com/recaptcha/api.js'></script>
		<title>Register</title>
		<link href="../src/Register.css" rel="stylesheet" type="text/css">
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
	</head>
	<body>
		<div class="login">
			<h1>Register</h1>
			<form action="../src/new_user.php" method="post">
			<label for="username">
					<i class="fas fa-user"></i>
				</label>
			<input type="text" name="username" placeholder="Username" id="username" required> 
			<label  for="password">
				<i class="fas fa-lock"></i>
				 </label>
				<input type="password" name="password" placeholder="Password" id="password" required>
				
				<label for="phone_number"> 
					<i class="fas fa-phone"></i>
				</label>
				<input type="text" name="contact" placeholder="Contact Number" id="phone_number" required>
				
				<label for="email">
					<i class="fas fa-at"></i>
				</label>
					<input type="text" name="email" placeholder="Email" id="email" required> 
				<div class="g-recaptcha" data-sitekey="6LcphAMaAAAAAGsk4TInD1DCSMxiMQO71239fRUH"></div>
				
				<a href="login.php">Existing user?<br>Click here to Login</a>
				
				<input type="submit" name='submit' value="Register">
				
			</form>
			
				<p class="error"><?php if(isset($_GET['username'])) echo "Username may contain letters, numbers, underscores and dash.<br>";?>
				<p class="error"><?php if(isset($_GET['password'])) echo "Passwords must be at least length 8. May contain letters, numbers and symbols.<br>";?>
				<p class="error"><?php if(isset($_GET['contact'])) echo "Contact must only contain numbers.<br>";?>
				<p class="error"><?php if(isset($_GET['email'])) echo "Invalid email<br>";?>
				<p class="error"><?php if(isset($_GET['captcha'])) echo "Captcha failed.<br>";?>
				
		</div>
	</body>
</html>
