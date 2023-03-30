<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<!--Qui richiamo le classi di Bootstap e jQuery-->
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
		<link href="media/fermi.ico" rel="shortcut icon" type="image/vnd.microsoft.icon"/>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

		<link rel="stylesheet" href="css/styles.css">

		<script type="text/javascript" src="js/funzioni.js"></script>

		<?php
			require_once('api/tuttistrumentazione.php');
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

	<title>Gestione elementi</title>
	</head>

	<!--Questi stili sono specifici per questa pagina-->
	<style>

		td
		{
			text-align: left;
		}

	</style>

	<script type="text/javascript">
		$(document).ready(function(){
			$('#mostra-lista-reagenti').click(function()
			{
				$('#lista-reagenti').toggle();
			});

			$('#mostra-lista-vetreria').click(function()
			{
				$('#lista-vetreria').toggle();
			});

			$('#mostra-lista-strumenti').click(function()
			{
				$('#lista-strumenti').toggle();
			});
		});
	</script>

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
					<h1>Gestione elementi</h1>
				</div>
			</div>
		</div>

		<div class="container">
			<h2 class="titoloSezione text-center" id="mostra-lista-reagenti">Lista reagenti</h2>
			<div class="row" id="lista-reagenti" style="display: none;">
				<div class="container table-responsive">
					<table class="table table-striped">
						<thead>
							<th>Nome</th>
							<th>
								<?php if ( in_array($_SESSION['nomeCategoria'], array('Amministratore', 'Docente', 'ITP')) ) { ?>
								Azioni
								<?php } ?>
							</th>
						</thead>
						<tbody>
							<?php require_once('api/tuttireagenti.php'); ?>
						</tbody>
					</table>
				</div>
			</div>

			<h2 class="titoloSezione text-center" id="mostra-lista-vetreria">Lista vetreria</h2>
			<div class="row" id="lista-vetreria" style="display: none;">
				<div class="container table-responsive">
					<table class="table table-striped">
						<thead>
							<th>Nome</th>
							<th>
								<?php if ( in_array($_SESSION['nomeCategoria'], array('Amministratore', 'Docente', 'ITP')) ) { ?>
								Azioni
								<?php } ?>
							</th>
						</thead>
						<tbody>
							<?php require_once('api/tuttivetreria.php'); ?>
						</tbody>
					</table>
				</div>
			</div>

			<h2 class="titoloSezione text-center" id="mostra-lista-strumenti">Lista strumenti</h2>
			<div class="row" id="lista-strumenti" style="display: none;">
				<div class="col-sm-6">
				<h2 class="titoloSezione text-center">Tipologia</h2>
					<div class="table-responsive">
						<table class="table table-striped">
							<thead>
								<th>Nome</th>
								<th>
									<?php if ( in_array($_SESSION['nomeCategoria'], array('Amministratore', 'Docente', 'ITP')) ) { ?>
									Azioni
									<?php } ?>
								</th>
							</thead>
							<tbody>
								<?php stampaStrumenti(); ?>
							</tbody>
						</table>
					</div>
				</div>

				<div class="col-sm-6">
					<h2 class="titoloSezione text-center">Inventario</h2>
					<div class="table-responsive">
						<table class="table table-striped">
							<thead>
								<th>Nome</th>
								<th>Numero di inventario</th>
								<th>
									<?php if ( in_array($_SESSION['nomeCategoria'], array('Amministratore', 'Docente', 'ITP')) ) { ?>
									Azioni
									<?php } ?>
								</th>
							</thead>
							<tbody>
								<?php stampaInventario(); ?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
		<br>
	</body>
</html>
