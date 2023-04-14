<html>
	<meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <script src="https://kit.fontawesome.com/0c4f236ae7.js"></script>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
	
	<!-- need this for sending ajax request when calling for the login & sign up page -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
	<script src="https://code.jquery.com/jquery-3.5.1.js" integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc="></script>

	<link href="../src/land.css" rel="stylesheet" type="text/css">
	<link rel="stylesheet" type="text/css" href="../src/font/flaticon.css">
	
<?php session_start(); 
if(isset($_SESSION['username'])) header("Location: ../docs/feed.php");
	session_regenerate_id(); 
	libxml_disable_entity_loader($disable=true);
	?>

<div class="container" id="container" >
	<div class="form-container all-night-container">
		<form action="#">
			<h1>ALL NIGHT</h1>
			<br><br>
			<i class="fab fa-earlybirds" style="margin-top: -30px;"></i>
			<p style="color: white; margin-top: 10px; font-family: ">BokBokKeh</p>
			<button type=button onclick="location.href='../docs/login.php'" style="color: white; width: 220px;">Login</button>
			<br>
			<button type=button onclick="location.href='../docs/Register.php'" style="color: white">Sign Up</button>
		</form>
	</div>
	<div class="form-container bok-bok-container">
		<form action="#">
			<h1 style="margin-top: -20px;">BOK BOK</h1>	
			<i class="flaticon-hatch" style="margin-top: 0px;"></i>
			<p style="font-weight: bold; margin-top: 0px; color: white; margin-left: 15px;">BokBokKeh</p>
		</form>
	</div>
	<div class="overlay-container">
		<div class="overlay">
			<div class="overlay-panel overlay-all-day">
				<h1 style="margin-top: -20px;">ALL DAY</h1>
				<br><br>
				<i class="flaticon-hatch" style="margin-top: -45px;"></i>
				
				<button class="ghost" id="signIn">BACK</button>
			</div>
			<div class="overlay-panel overlay-hoot-hoot">
				<h1 style="margin-top: -30;">HOOT HOOT</h1>
				<br>
				<i class="fab fa-earlybirds" style="font-size: 100px;"></i>
				<br>
				<button class="ghost" id="signUp">GET STARTED</button>
			</div>
		</div>
	</div>
</div>
	<script type="text/javascript">
		const signUpButton = document.getElementById('signUp');
		const signInButton = document.getElementById('signIn');
		const container = document.getElementById('container');

    	signUpButton.addEventListener('click', () => {
    	container.classList.add("right-panel-active");
    	});
    
    	signInButton.addEventListener('click', () => {
    	container.classList.remove("right-panel-active");
    	});
	</script>
	<?php 
		function loginpage(){
		    header("Location: ../docs/login.php");
		}
		
	
	?>
</html>
	