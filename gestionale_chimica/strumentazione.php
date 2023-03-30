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
			require_once('api/strumentazione.php');
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

		<title><?php echo $nomeSA; ?></title> <!--Bilancia-->
	</head>

	<script type="text/javascript">
		$(document).ready(function(){
			
			$('#btnAggiungiCollocazioneManuale').click(function() {
				//Svuota i campi
				$('#divAggiungiCollocazioneManuale').toggle();
				$('#aggiungiCollocazioneManuale').find(':text').removeClass();
				$('#aggiungiCollocazioneManuale').find(':text').val(null);
				$('#aggiungiCollocazioneManuale').find(':text').addClass("defaultempty");
			});

			$('#btnAggiungiManutenzioneOrdinaria').click(function() {
				//Svuota i campi
				$('#divAggiungiManutenzioneOrdinaria').toggle();
				$('#aggiungiManutenzioneOrdinaria').find(':text').removeClass();
				$('#aggiungiManutenzioneOrdinaria').find(':text').val(null);
				$('#aggiungiManutenzioneOrdinaria').find(':text').addClass("defaultempty");
			});

			$('#btnAggiungiManutenzioneStraordinaria').click(function() {
				//Svuota i campi
				$('#divAggiungiManutenzioneStraordinaria').toggle();
				$('#aggiungiManutenzioneStraordinaria').find(':text').removeClass();
				$('#aggiungiManutenzioneStraordinaria').find(':text').val(null);
				$('#aggiungiManutenzioneStraordinaria').find(':text').addClass("defaultempty");
			});

			$('#btnAggiungiRiparazione').click(function() {
				//Svuota i campi
				$('#divAggiungiRiparazione').toggle();
				$('#aggiungiRiparazione').find(':text').removeClass();
				$('#aggiungiRiparazione').find(':text').val(null);
				$('#aggiungiRiparazione').find(':text').addClass("defaultempty");
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
					<h1><?php echo $nomeSA; ?></h1>
				</div>
			</div>
		</div>

		<!--
			- Caratteristiche generali:
			Nome
			Numero di inventario
		-->
		<div class="container">
			<div class="container-fluid">
				<div class="row">
					<div class="col-sm-6 text-center" style="padding:1%;">
						<h4>Nome:</h4>
						<div class="caratteristiche">
							<!--PHPSTAMPAMI nome del reagente nella descrizione generale-->
							<h4><?php echo $nomeSA; ?></h4>
						</div>
					</div>

					<div class="col-sm-6 text-center" style="padding:1%;">
						<h4>Numero di inventario:</h4>
						<div class="caratteristiche">
							<h4><?php echo $numeroInventario ?></h4>
						</div>
					</div>
				</div>
			</div>

			<!--Caratteristiche tecniche-->
			<div class="row container-fluid">
				<h2 class="titoloSezione text-center">Caratteristiche tecniche</h2>
				<p><?php echo $caratteristicaTecnica ?></p>
			</div>

			<!--
				- Collocazione (che può esser più di una)
				Sigla della stanza
				Codice dell'armadio
				Numero del ripiano nell'armadio
				Per ogni collocazione anche la quantità presente in quel luogo
			-->
			<h2 class="titoloSezione text-center" id="mostra-tabella-collocazione">Collocazione</h2>

			<div class="container-fluid" id="tabella-collocazione">
				<div class="table-responsive">
					<table class="table table-striped">
						<thead>
							<th>Laboratorio</th>
							<th>Armadio</th>
							<th>Ripiano</th>
							<th>Quantit&agrave;</th>
							<th>
								<?php if ( in_array($_SESSION['nomeCategoria'], array('Amministratore', 'Docente', 'ITP')) ) { ?>
								Azioni
								<?php } ?>
							</th>
						</thead>
						<tbody>
							<tr>
								<?php 
									stampaCollocazioneAttuale();
								?>
						</tbody>
					</table>
					<br>
					<table class="table table-striped">
						<thead>
							<th>Laboratorio</th>
							<th>Armadio</th>
							<th>Ripiano</th>
							<th>Quantit&agrave;</th>
							<th>Data di verifica della quantit&agrave;</th>
							<th>Data di scadenza</th>
						</thead>
						<tbody>
							<tr>
								<?php
									stampaCollocazioneQuantitaStrumentazione();
								?>
						</tbody>
					</table>
				</div>
			</div>

			<!--
				- Nome manuale
				link (se è digitale)
				Sigla della stanza
				Codice dell'armadio
				Numero del ripiano nell'armadio
			-->
			<!--Titolo sezione del manuale-->
			<h2 class="titoloSezione text-center" id="mostra-tabella-scheda">Manuale</h2>

			<!--Scehda contenente i dati del manuale-->
			<div class="container-fluid" id="tabella-scheda">
				<div class="table-responsive">
					<table class="table table-striped">
						<thead>
							<th>Nome</th>
							<th>Data di Rilascio</th>
							<th>Link</th>
							<th>Laboratorio</th>
							<th>Armadio</th>
							<th>Ripiano</th>
							<th>Quantit&agrave;</th>
							<th>
								<?php if ( in_array($_SESSION['nomeCategoria'], array('Amministratore', 'Docente', 'ITP')) ) { ?>
								Azioni
								<?php } ?>
							</th>
						</thead>
						<tbody>
							<?php stampaManualeIstruzioni() ?>
						</tbody>
					</table>
				</div>
				<!--Form di aggiunta nuova collocazione manuale-->
				
				<?php if ( in_array($_SESSION['nomeCategoria'], array('Amministratore', 'Docente')) ) { ?>
					<div class="row">
						<button class="btn btn-primary" id="btnAggiungiCollocazioneManuale">Aggiungi una collocazione</button>
					</div>
				<?php } ?>

				<div class="collapse row" id="divAggiungiCollocazioneManuale">
					<form autocomplete="off" method="POST" action="api/aggiungicollocazionemanualestrumento.php" id="aggiungiCollocazioneManuale">
						<?php 
							echo "<input type=\"hidden\" name=\"numeroInventario\" value=\"".$numeroInventario."\">";
							echo "<input type=\"hidden\" name=\"idManuale\" value=\"".$idManuale."\">";
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
								<input type="submit" class="btn btn-success" name="inviaNuovaCollocazione" value="Salva">
							</div>
						</div>
					</form>
				</div>
			</div>
			
			<!--Riga di manutenzione ordinaria e straordinaria-->
			<div class="row">
				<!--Colonna manutenzione ordinaria-->
				<div class="col-sm-6">
					<!--
						- Storico manutenzione ordinaria
						Azione
						Data
					-->
					<h2 class="titoloSezione text-center" id="mostra-tabella-manutenzione">Manutenzione ordinaria</h2>

					<div class="container-fluid" id="tabella-manutenzione">
						<div class="table-responsive">
							<table class="table table-striped">
								<thead>
									<th>Data</th>
									<th>Cosa è stato fatto</th>
								</thead>
								<tbody>
									<?php stampaStoricoManutenzioneOrdinaria(); ?>
								</tbody>
							</table>
						</div>
					</div>

					<?php if ( in_array($_SESSION['nomeCategoria'], array('Amministratore', 'Docente')) ) { ?>
						<div class="row-fluid">
							<button class="btn btn-primary" id="btnAggiungiManutenzioneOrdinaria">Aggiungi manutenzione ordinaria</button>
						</div>
					<?php } ?>

					<div class="row collapse" id="divAggiungiManutenzioneOrdinaria">
						<form autocomplete="off" method="POST" action="api/aggiungimanutenzioneord.php" id="aggiungiManutenzioneOrdinaria">
							<?php 
								echo "<input type=\"hidden\" name=\"numeroInventario\" value=\"".$numeroInventario."\">";
							?>
							<div class="col-sm-4">
								<h4><input type="date" name="dataManutenzione" id="dataManutenzione" class="defaultempty" onblur="checkInput('dataManutenzione')" required="true"></h4>
							</div>
							<div class="col-sm-8">
								<h4><input type="text" name="azione" id="azione" class="defaultempty" onblur="checkInput('azione')" placeholder="Cosa è stato fatto" required="true"></h4>
							</div>
							<div class="row-fluid">
								<div class="col-sm-3">
									<input type="submit" name="inviaNuovaManutenzioneOrdinaria" class="btn btn-success" value="Salva">
								</div>
							</div>
						</form>
					</div>
				</div>

				<!--Colonna manutenzione straordinaria-->
				<div class="col-sm-6">
					<!--
						- Storico manutenzione straordinaria
						Data
						Azione
					-->
					<h2 class="titoloSezione text-center" id="mostra-tabella-manutenzione-str">Manutenzione straordinaria</h2>

					<div class="container-fluid" id="tabella-manutenzione-str">
						<div class="table-responsive">
							<table class="table table-striped">
								<thead>
									<th>Data</th>
									<th>Cosa è stato fatto</th>
								</thead>
								<tbody>
									<?php stampaStoricoManutenzioneStraordinaria(); ?>
								</tbody>
							</table>
						</div>
					</div>
					
					<?php if ( in_array($_SESSION['nomeCategoria'], array('Amministratore', 'Docente')) ) { ?>
						<div class="row-fluid">
							<button class="btn btn-primary" id="btnAggiungiManutenzioneStraordinaria">Aggiungi manutenzione straordinaria</button>
						</div>
					<?php } ?>

					<div class="collapse row" id="divAggiungiManutenzioneStraordinaria">
						<form autocomplete="off" method="POST" action="api/aggiungimanutenzionestraord.php" id="aggiungiManutenzioneStraordinaria">
							<?php 
								echo "<input type=\"hidden\" name=\"numeroInventario\" value=\"".$numeroInventario."\">";
							?>
							<div class="col-sm-4">
								<h4><input type="date" name="dataManutenzione" id="dataManutenzione" class="defaultempty" onblur="checkInput('dataManutenzione')" required="true"></h4>
							</div>
							<div class="col-sm-8">
								<h4><input type="text" name="azione" id="azione" class="defaultempty" onblur="checkInput('azione')" placeholder="Cosa è stato fatto" required="true"></h4>
							</div>
							<div class="row-fluid">
								<div class="col-sm-3">
									<input type="submit" name="inviaNuovaManutenzioneStraordinaria" class="btn btn-success" value="Salva">
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
			
			<!--
				- Riparazione
				Data
				Motivazione
			-->
			<!--Titolo sezione della scheda delle riparazioni-->
			<h2 class="titoloSezione text-center" id="mostra-tabella-scheda">Riparazione</h2>

			<!--Scehda contenente i dati delle riparazioni-->
			<div class="container-fluid">
				<div class="table-responsive">
					<table class="table table-striped">
						<thead>
							<th>Data</th>
							<th>Motivazione della riparazione</th>
						</thead>
						<tbody>
							<?php stampaRiparazioni() ?>
						</tbody>
					</table>
				</div>

				<?php if ( in_array($_SESSION['nomeCategoria'], array('Amministratore', 'Docente')) ) { ?>
					<div class="row">
						<button class="btn btn-primary" id="btnAggiungiRiparazione">Aggiungi una riparazione</button>
					</div>
				<?php } ?>

				<div class="collapse" id="divAggiungiRiparazione">
					<form autocomplete="off" method="POST" action="api/aggiungiriparazione.php" id="aggiungiRiparazione">
						<?php 
							echo "<input type=\"hidden\" name=\"numeroInventario\" value=\"".$numeroInventario."\">";
						?>
						<div class="row">
							<div class="col-sm-3">
									<h4><input type="date" name="dataRiparazione" id="dataRiparazione" class="defaultempty" onblur="checkInput('dataRiparazione')" required="true"></h4>
							</div>
							<div class="col-sm-6">
								<h4><input type="text" name="motivazione" id="motivazione" class="defaultempty" onblur="checkInput('motivazione')" placeholder="Cosa è stato riparato" required="true"></h4>
							</div>
							<div class="row">
								<div class="col-sm-12">
									<input type="submit" name="inviaNuovaRiparazione" class="btn btn-success" value="Salva">
								</div>
							</div>
						</div>
					</form>
				</div>
			</div>
			<br>
			<div class="row-fluid">
				<a href="consulta.php"><button class="btn btn-danger">Torna indietro</button></a>
			</div>
		</div>
	</body>
</html>