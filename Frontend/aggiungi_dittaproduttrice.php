<!DOCTYPE html>
<html>
	<head>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">

		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
		<link href="media/fermi.ico" rel="shortcut icon" type="image/vnd.microsoft.icon"/>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

		<link rel="stylesheet" href="css/styles.css">
		<script type="text/javascript" src="js/funzioni.js"></script>
		<title>Aggiungi ditta</title>

		<?php
		session_start();
		if(isset($_SESSION['isLogged'])) {
			if($_SESSION['isLogged'] == "no") {
				header("location: /login.php");
			} else {
				if(!in_array($_SESSION['nomeCategoria'], array('Amministratore', 'Docente'))) {
					header("location: /home.php");
				}
			}
		} else if(!isset($_SESSION['isLogged'])) {
			header("location: /login.php");
		}
		?>

	</head>

	<body>

		<nav class="navbar navbar-default" style="margin-bottom: 0%;">
			<div class="container-fluid">
				<!--Header della navbar-->
				<div class="navbar-header navElemento navTitolo">
					<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navigazioneSito">
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
					<a class="navbar-brand" href="#">Laboratori di Chimica</a>
				</div>

				<!--Corpo centrale della navbar-->
				<div class="collapse navbar-collapse" id="navigazioneSito">
					<ul class="nav navbar-nav">
						<li><a href="/home.php" class="navElemento">Home</a></li>
						<li><a href="/consulta.php" class="navElemento">Cerca dati</a></li>
						<?php if(in_array($_SESSION['nomeCategoria'], array('Amministratore', 'Docente'))) { ?>
							<li class="dropdown">
								<a class="dropdown-toggle navElemento navElementoAggiungi" data-toggle="dropdown" href="#">Aggiungi
								<span class="caret"></span></a>
								<ul class="dropdown-menu">
									<li><a href="/aggiungi_reagente.php">Reagente</a></li>
									<li><a href="/aggiungi_vetreria.php">Vetreria</a></li>
									<li><a href="/aggiungi_strumento.php">Strumentazione</a></li>
									<li><a href="/aggiungi_dittaproduttrice.php">Ditta produttrice</a></li>
								</ul>
							</li>
						<?php } ?>
						
						<?php if(in_array($_SESSION['nomeCategoria'], array('Amministratore', 'Docente'))) { ?>
							<li><a href="/gestione.php" class="navElemento navElementoElimina">Elimina dati</a></li>
						<?php } ?>
						<?php if(in_array($_SESSION['nomeCategoria'], array('Amministratore'))) { ?>
							<li><a href="/admin.php" class="navElemento">Admin</a></li>
						<?php } ?>
					</ul>
					<!--Parte a destra della navbar-->
					<ul class="nav navbar-nav navbar-right navbar-collapse">
						<li class="dropdown">
							<a class="dropdown-toggle navElemento" data-toggle="dropdown" href="#"><?php echo $_SESSION['username']; ?>
							<span class="caret"></span></a>
							<ul class="dropdown-menu" id="azioniUtente">
								<li>
									<a href="api/logout.php">Logout</a>
								</li>
							</ul>
						</li>
					</ul>
				</div>
			</div>
		</nav>

		<div class="jumbotron container-fluid" style="text-align:center;">
			<div class="row">
				<div class="col-sm-3">
					<img src="media/logo_itis.gif">
				</div>
				<div class="col-sm-8">
					<h1>Aggiungi ditta</h1>
				</div>
			</div>
		</div>

		<div class="container">
			<h2 class="titoloSezione text-center" id="mostra-tabella-utenti">Aggiungi ditta</h2>
			<form autocomplete="off" method="POST" action="api/aggiungiditta.php">
				<div style="text-align:center;">
					<div class="form-group">
						<label for="exampleFormControlSelect1">Nome ditta</label>
						<input type="text" name="nomeDitta" id="nomeDitta" class="defaultempty" onblur="checkInput('nomeDitta')" placeholder="Nome ditta" required="true">
					</div>
					<div class="form-group">
						<label for="exampleFormControlSelect2">Indirizzo</label>
						<input type="text" name="indirizzo" id="indirizzo" class="defaultempty" onblur="checkInput('indirizzo')" placeholder="Indirizzo" required="true">
					</div>
					<div class="form-group">
						<label for="exampleFormControlSelect3">Telefono</label>
						<input type="text" name="telefono" id="telefono" class="defaultempty" onblur="checkInput('telefono')" placeholder="Telefono" required="true">
					</div>
					<div class="form-group">
						<label for="exampleFormControlSelect3">Email</label>
						<input type="text" name="email" id="email" class="defaultempty" onblur="checkInput('email')" placeholder="Email" required="true">
					</div>
					<input type="submit" name="btnAggiungi" class="btn btn-primary" value="Aggiungi">
				</div>
			</form>
		</div>
		<br><br>
	</body>
</html>
