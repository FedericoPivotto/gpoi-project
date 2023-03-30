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
			require_once('api/vetreria.php');
			session_start();
			//echo "\$_SESSION': " . print_r($_SESSION);
			if(isset($_SESSION['isLogged'])) {
				if($_SESSION['isLogged'] == "no") {
					header("location: /login.php");
				}
			} else if(!isset($_SESSION['isLogged'])) {
				header("location: /login.php");
			}
		?>

		<title><?php echo $nomeVA; ?></title>
	</head>

	<script type="text/javascript">
		$(document).ready(function(){
			$('#btnAggiungiCollocazioneVetreria').click(function() {
				//Svuota i campi
				$('#divAggiungiCollocazioneVetreria').toggle();
				$('#aggiungiCollocazioneVetreria').find(':text').removeClass();
				$('#aggiungiCollocazioneVetreria').find(':text').val(null);
				$('#aggiungiCollocazioneVetreria').find(':text').addClass("defaultempty");
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
					<h1><?php echo $nomeVA; ?><!--Becher--></h1>
				</div>
			</div>
		</div>
		<!--
			- Caratteristiche generali:
			Nome
			Numero di inventario
		-->
		<div class="container">
			<div class="row">
				<div class="col-sm-12 text-center" style="padding:1%;">
					<h3>Nome:</h3>
					<div class="caratteristiche">
						<!--PHPSTAMPAMI nome del reagente nella descrizione generale-->
						<h4><?php echo $nomeVA; ?><!--Becher 1000ml--></h4>
					</div>
				</div>
			</div>

			<h2 class="titoloSezione text-center" id="mostra-tabella-collocazione">Collocazione</h2>

			<div class="container-fluid" id="tabella-collocazione">
				<div class="table-responsive">
					<table class="table table-striped">
						<thead>
							<th>Laboratorio</th>
							<th>Armadio</th>
							<th>Ripiano</th>
							<th>Quantit&agrave;</th>
							<th>Data di verifica della quantit&agrave;</th>
							<th>Data di scadenza</th>
							<th>
								<?php if ( in_array($_SESSION['nomeCategoria'], array('Amministratore', 'Docente', 'ITP')) ) { ?>
								Azioni
								<?php } ?>
							</th>
						</thead>
						<tbody>
								<?php stampaCollocazioneQuantitaVetreria(); ?>
						</tbody>
					</table>
				</div>

				<?php if ( in_array($_SESSION['nomeCategoria'], array('Amministratore', 'Docente')) ) { ?>
					<div class="row-fluid">
						<button class="btn btn-primary" id="btnAggiungiCollocazioneVetreria">Aggiungi una collocazione</button>
					</div>
				<?php } ?>

				<div class="collapse" id="divAggiungiCollocazioneVetreria">
					<form autocomplete="off" method="POST" action="api/aggiungicollocazionevetreria.php" id="aggiungiCollocazioneVetreria">
						<?php 
							echo "<input type=\"hidden\" name=\"idVetreria\" value=\"".$idVetreria."\">";
						?>
						<div class="row">
							<div class="col-sm-3">
								<label for="stanzaManualeStrumento"><h4>Collocazione:</h4></label>
							</div>
							<!--I tre elementi della collocazione: stanza, armadio ripiano-->
							<div class="col-sm-3">
								<h4><input type="text" name="stanza" id="stanza" class="defaultempty" onblur="checkInput('stanza')" placeholder="Laboratorio" required="true"></h4>
							</div>
							<div class="col-sm-3">
								<h4><input type="text" name="armadio" id="armadio" class="defaultempty" onblur="checkInput('armadio')" placeholder="Armadio" required="true"></h4>
							</div>
							<div class="col-sm-3">
								<h4><input type="text" name="ripiano" id="ripiano" class="defaultempty" onblur="checkInput('ripiano')" placeholder="Ripiano" required="true"></h4>
							</div>
						</div>
						<div class="row">
							<div class="col-sm-3">
								<label for="siglastanza"><h4>Altri dettagli:</h4></label>
							</div>
							<div class="col-sm-3">
								<h4><input type="text" name="quantita" id="quantita" class="defaultempty" onblur="checkInput('quantita')" placeholder="Quantità" required="true"></h4>
							</div>
						</div>
						<div class="row">
							<div class="col-sm-3">
								<label for="siglastanza"><h4>Data di verifica:</h4></label>
							</div>
							<div class="col-sm-3">
								<h4><input type="date" name="dataVerifica" id="dataVerifica" class="defaultempty" onblur="checkInput('dataVerifica')" placeholder="Data di verifica" required="true"></h4>
							</div>
						</div>
						<div class="row">
							<div class="col-sm-3">
								<label for="siglastanza"><h4>Data di scadenza:</h4></label>
							</div>
							<div class="col-sm-3">
								<h4><input type="date" name="dataScadenza" id="dataScadenza" class="defaultempty" onblur="checkInput('dataScadenza')" placeholder="Data di scadenza" required="true"></h4>
							</div>
						</div>
						<div class="row">
							<div class="col-sm-12">
								<input type="submit" class="btn btn-success" name="inviaNuovaCollocazione" value="Salva">
							</div>
						</div>
					</form>
				</div>
			</div>

			<br>
			<div class="row">
				<a href="consulta.php"><button class="btn btn-danger">Torna indietro</button></a>
			</div>
		</div>
		<br>
	</body>
</html>
