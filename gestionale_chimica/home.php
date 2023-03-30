<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8"/>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<!--Qui richiamo le classi di Bootstap e jQuery-->
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
		<link href="media/fermi.ico" rel="shortcut icon" type="image/vnd.microsoft.icon"/>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

		<link rel="stylesheet" href="css/styles.css">
		<script type="text/javascript" src="js/funzioni.js"></script>
		<title>Home</title>

		<?php
			session_start();
			if(isset($_SESSION['isLogged'])) {
				if($_SESSION['isLogged'] == "no") {
					header("location: /login.php");
				}
			} else if(!isset($_SESSION['isLogged'])) {
				header("location: /login.php");
			}
		?>
	</head>

	<style>
		a
		{
			text-decoration: none;
			color:white;
		}
		a:link
		{
			text-decoration: none;
			color:white;
			transition: 0.2s;
		}
		a:hover
		{
			color:black;
		}

		footer
		{
			vertical-align: baseline; 
			width: 100%;
		}

		.sezioneElimina:hover
		{
			background-color:#c92840;
		}

		.sezioneAggiungi:hover
		{
			background-color:#5AB06C;
		}

	</style>

	<script type="text/javascript">
		$(document).ready(function(){

			$('#mostra-opzioni-aggiungi').click(function() {
				$('#opzioni-aggiungi').toggle();
			});

			$('#colElimina').mouseenter(function(){
				$('#eliminaTesto').hide();
				$('#eliminaIco').show();
			});
			$('#colElimina').mouseleave(function(){
				$('#eliminaIco').hide();
				$('#eliminaTesto').show();
			});

			$('#colConsulta').mouseenter(function(){
				$('#consultaTesto').hide();
				$('#consultaIco').show();
			});
			$('#colConsulta').mouseleave(function(){
				$('#consultaIco').hide();
				$('#consultaTesto').show();
			});

			$('#mostra-opzioni-aggiungi').mouseenter(function(){
				$('#aggiungiTesto').hide();
				$('#aggiungiIco').show();
			});
			$('#mostra-opzioni-aggiungi').mouseleave(function(){
				$('#aggiungiIco').hide();
				$('#aggiungiTesto').show();
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
				<div class="col-sm-9">
					<h1>Laboratori di chimica</h1>
				</div>
			</div>
		</div>

		<div class="container" style="height: 90%;">
			<div class="row align-items-center">
				<div class="col align-items-center text-center">
					<h1>Benvenuto&nbsp;<b><?php echo $_SESSION['username']; ?></b>!</h1>
					<h3>Nel software gestionale dei laboratori di chimica</h3>
				</div>
			</div>
			<!--I tre diversi bottoni inseriti nel controll in php-->
			<div class="row">
				<?php if(in_array($_SESSION['nomeCategoria'], array('Amministratore', 'Docente'))) { ?>
				<!--Consulta-->
				<div class="col-sm-4 text-center">
					<a href="consulta.php">
						<h1 class="titoloSezione" id="colConsulta">
							<span id="consultaTesto">Consulta</span>
							<span id="consultaIco" style="display: none;"><img title="Consulta" alt="consulta" src="media/bottoni/result.svg" width="25" height="25"/></span>
						</h1>
					</a>
					Cerca reagenti, vetreria e strumentazione immagazzinati nel database
				</div>
				<!--Aggiungi-->
				<div class="col-sm-4 text-center">
					<h1 class="titoloSezione sezioneAggiungi" id="mostra-opzioni-aggiungi">
						<span id="aggiungiTesto">Aggiungi</span>
						<span id="aggiungiIco" style="display: none;"><img title="Aggiungi" alt="aggiungi" src="media/bottoni/plus.svg" width="25" height="25"/></span>
					</h1>
					Aggiungi dei nuovi reagenti, della nuova vetreria o un nuovo strumento.
					<h3 class="titoloSezione" id="opzioni-aggiungi" style="display: none;">
						<a href="aggiungi_reagente.php">Reagente</a><br>
						<a href="aggiungi_strumento.php">Strumentazione</a><br>
						<a href="aggiungi_vetreria.php">Vetreria</a>
						<?php if(in_array($_SESSION['nomeCategoria'], array('Amministratore', 'Docente'))) { ?>
							<br><a href="/aggiungi_dittaproduttrice.php">Ditta produttrice</a>
						<?php } ?>
					</h3>
				</div>
				<!--Elimina-->
				<div class="col-sm-4 text-center">
					<a href="gestione.php">
						<h1 class="titoloSezione sezioneElimina" id="colElimina">
							<span id="eliminaTesto">Elimina</span>
							<span id="eliminaIco" style="display:none;"><img title="Elimina" alt="Elimina" src="media/bottoni/can.svg" width="25" height="25"/></span>
						</h1>
					</a>
					Elimina dei dati dal database
				</div>
				<?php } else { ?>
				<!--Consulta-->
				<div class="col-sm-4"></div>
				<div class="col-sm-4 text-center">
					<a href="consulta.php">
						<h1 class="titoloSezione" id="colConsulta">
							<span id="consultaTesto">Consulta</span>
							<span id="consultaIco" style="display: none;"><img title="Consulta" alt="consulta" src="media/bottoni/result.svg" width="25" height="25"/></span>
						</h1>
					</a>
					Cerca reagenti, vetreria e strumentazione immagazzinati nel database
				</div>
				<div class="col-sm-4"></div>
				<?php } ?>
				</div>
			</div><!--Fine row bottoni-->
		</div><!--Fine container-->
		<footer class="container-fluid text-center hidden-sm hidden-xs" style="margin-bottom: 0%; height: 10%; color: #919191;">
			<form method="post" action="api/logout.php">
				<br><br>
				<button name="logoutBtn" class="btn btn-danger">Effettua il logout</button>
				<?php
					/*if(isset($_POST['logoutBtn'])) {
						require_once('api/logout.php');
					}*/
				?>
			</form>
			<br>
			<div class="container-fluid">
				<dl>
					<small>Francesco Guidolin - Cesare Brunello - Filippo Lucchin - Federico Pivotto</small>
					<small>5AI AS 2019/2020</small>
				</dl>
			</div>
		</footer>
	</body>
</html>
