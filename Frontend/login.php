<!DOCTYPE html>
<html>
	<head>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<!--Qui richiamo le classi di Bootstap e jQuery-->
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
		<link href="media/fermi.ico" rel="shortcut icon" type="image/vnd.microsoft.icon"/>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

		<link rel="stylesheet" href="css/styles.css">
		<script type="text/javascript" src="js/funzioni.js"></script>
		<title>Indice</title>

		<?php
			require_once('api/login.php');
			session_start();
			//echo "\$_SESSION': " . print_r($_SESSION);
			if(isset($_SESSION['isLogged'])) {
				if($_SESSION['isLogged'] == "yes") {
					header("location: /home.php");
				}
			}
		?>
	</head>

	<body>
		
		<div class="jumbotron container-fluid" style="text-align:center;">
			<div class="row">
				<div class="col-sm-3">
					<img src="media/logo_itis.gif">
				</div>
				<div class="col-sm-8">
					<h1>Laboratori di chimica</h1>
				</div>
			</div>
		</div>

		<!--contenuto principale della pagina-->
		<div class="container">
			<!--Inizio del form di login-->
			<div class="form-group" id="login">
				<form method="post"> <!-- action="/api/login.php" -->
					<div class="row">
						<?php 
							if(isset($_POST['loginBtn'])) {
								controlloCredenziali($usernameUtente, $passwordUtente);
								if($_SESSION['isLogged'] == "no") {
									echo "<p style=\"color: red;\"><b>Le credenziali inserite sono errate</b></p>";
								} else if($_SESSION['isLogged'] == "yes") {
									header("location: /home.php");
								}
							}
						?>
					</div>
					<div class="row">
						<div class="col-sm-2">
							<label for="docenteNome">Nome utente:</label>
						</div>
						<div class="col-sm-4">
							<input type="text" name="username" class="form-control" id="docenteNome" placeholder="Nome utente">
						</div>
					</div>
					<br>
					<div class="row">
						<div class="col-sm-2">
							<label for="docentePassword">Password:</label>
						</div>
						<div class="col-sm-4">
							<input type="password" name="password" class="form-control" id="docentePassword" placeholder="Password">
						</div>
					</div>
					<br>
					<div class="row">
						<div class="col-sm-2">
							<input type="submit" name="loginBtn" class="btn btn-primary" id="invia" value="Login">
						</div>
					</div>
				</form>
				<!-- <a href="home.html"><button class="btn btn-success">Login</button></a> -->
			</div>
		</div>
	</body>
</html>
