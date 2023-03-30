<!DOCTYPE html>
<html>
	<!--Se stai leggendo questo commento vuol dire che non dovresti essere qui
		Ma mi hai trovato comunque, sono un easter egg!
	-->
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
			require_once('api/reagente.php');
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

		<title><?php echo $nomeReagente; ?></title>
	</head>

	<script type="text/javascript">
		$(document).ready(function(){
			
			$('#btnAggiungiSchedaSicurezza').click(function() {
				//Svuota i campi
				$('#divAggiungiSchedaSicurezza').toggle();
				$('#nuovaSchedaSicurezza').find(':text').removeClass();
				$('#nuovaSchedaSicurezza').find(':text').val(null);
				$('#nuovaSchedaSicurezza').find(':text').addClass("defaultempty");
			});

			$('#btnAggiungiEsperienza').click(function() {
				//Svuota i campi
				$('#divAggiungiEsperienza').toggle();
				$('#aggiungiEsperienza').find(':text').removeClass();
				$('#aggiungiEsperienza').find(':text').val(null);
				$('#aggiungiEsperienza').find(':text').addClass("defaultempty");
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
					<!--PHPSTAMPAMI nome del reagente titolo della pagina-->
					<h1><?php echo $nomeReagente; ?></h1>
				</div>
			</div>
		</div>
	
		<div class="container">
			<!--
			- Caratteristiche di base
			Nome Formula Stato (solido, gassoso o liquido)
			Tre elementi sulla stessa riga, uno sopra l'altro nei dispositivi come tablet e telefoni
			-->
			<div class="container-fluid">				
				<div class="row">
					<div class="col-sm-4 text-center" style="padding:1%;">
						<h4>Nome:</h4>
						<div class="caratteristiche">
							<!--PHPSTAMPAMI nome del reagente nella descrizione generale-->
							<h4><?php echo $nomeReagente; ?></h4>
						</div>
					</div>

					<div class="col-sm-4 text-center" style="padding:1%;">
						<h4>Formula:</h4>
						<div class="caratteristiche">
							<!--PHPSTAMPAMI formula chimica-->
							<h4><?php echo $formulaChimica; ?></h4>
						</div>
					</div>

					<div class="col-sm-4 text-center" style="padding:1%;">
						<h4>Stato:</h4>
						<div class="caratteristiche">
							<!--PHPSTAMPAMI stato-->
							<h4><?php echo $statoMateria; ?></h4>
						</div>
					</div>
				</div>
			</div>


			<!--
			- Descrizione
			modalità di conservazione (contenitore ben chiuso, lontano da fonti di calore)
			temperatura di conservazione (temperatura ambiente)
			Nome ditta (carl roth)
			Frasi di rischio con pittogrammi (possono essere molteplici)
			-->
			<h2 class="titoloSezione text-center">Descrizione</h2>
			<table class="table">
				<tbody>
					<tr>
						<td><h4><b>Modalit&agrave; di conservazione</b></h4></td>
						<td><h4><?php echo $modalita; ?></h4></td>
					</tr>
					<tr>
						<td><h4><b>Temperatura di conservazione</b></h4></td>
						<td><h4><?php echo $temperatura; ?></h4></td>
					</tr>
					<tr>
						<td><h4><b>Azienda produttrice</b></h4></td>
						<td><h4><?php echo $nomeDitta . " - " . $indirizzo . " - " . $telefono . " - " . $email; ?></h4></td>
					</tr>
					<tr>
						<td><h4><b>Frasi di rischio</b></h4></td>
						<td>
							<h4>
								<ul>
									<?php stampaFrasi(); ?>
								</ul>
							</h4>
						</td>
						<tr>
							<td><h4><b>Pittogrammi</b></h4></td>
							<td>
								<?php stampaPittogrammi(); ?>
							</td>
						</tr>
					</tr>
				</tbody>
			</table>

			<!--
			- Collocazione (che può esser più di una)
			Sigla della stanza o laboratorio
			Codice dell'armadio
			Numero del ripiano nell'armadio
			per ogni collocazione anche la quantità presente in quel luogo
				- data di verifica della quantità
				- data di scadenza
			-->
			<h2 class="titoloSezione text-center" id="mostra-tabella-collocazione">Collocazione</h2>

			<div id="tabella-collocazione">
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
							<?php stampaCollocazioneQuantitaReagente() ?>
						</tbody>
					</table>
				</div>

				<?php if ( in_array($_SESSION['nomeCategoria'], array('Amministratore', 'Docente')) ) { ?>

					<div class="container row">
						<button class="btn btn-primary" id="btnAggiungiCollocazione">Aggiungi una collocazione</button>
					</div>

				<?php } ?>

				<div class="collapse row-fluid" id="divAggiungiCollocazione">
					<form autocomplete="off" method="POST" action="api/aggiungicollocazionereagente.php" id="nuovaCollocazione">
						<?php 
							echo "<input type=\"hidden\" name=\"idReagente\" value=\"".$idReagente."\">";
						?>
						<div class="row">
							<div class="col-sm-3">
								<label for="siglastanza"><h4>Collocazione:</h4></label>
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
								<h4><input type="text" name="quantita" id="quantita" class="defaultempty" onblur="checkInput('quantita')" placeholder="Quantità"></h4>
							</div>
						</div>
						<div class="row">
							<div class="col-sm-3">
								<label for="siglastanza"><h4>Data di verifica:</h4></label>
							</div>
							<div class="col-sm-3">
								<h4><input type="date" name="dataVerifica" id="dataVerifica" class="defaultempty" onblur="checkInput('dataVerifica')" placeholder="Data di verifica"></h4>
							</div>
						</div>
						<div class="row">
							<div class="col-sm-3">
								<label for="siglastanza"><h4>Data di scadenza:</h4></label>
							</div>
							<div class="col-sm-3">
								<h4><input type="date" name="dataScadenza" id="dataScadenza" class="defaultempty" onblur="checkInput('dataScadenza')" placeholder="Data di scadenza"></h4>
							</div>
						</div>
						<!--piedini-->
						<div class="row">
							<div class="col-sm-3">
								<input type="submit" name="inviaNuovaCollocazione" class="btn btn-success" value="Salva">
							</div>
						</div>
					</form>
				</div>
			</div>

			<!--
			- Scheda di sicurezza
				nome
				data di rilascio
				link (se è digitale)
				Sigla della stanza
				Codice dell'armadio
				Numero del ripiano nell'armadio
			-->
			<h2 class="titoloSezione text-center" id="mostra-tabella-scheda">Scheda di sicurezza</h2>

			<div id="tabella-scheda">
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
							<?php stampaSchedaSicurezza(); ?>
						</tbody>
					</table>
				</div>

				<?php if ( in_array($_SESSION['nomeCategoria'], array('Amministratore', 'Docente')) ) { ?>
					<div class="container row">
						<button class="btn btn-primary" id="btnAggiungiSchedaSicurezza">Aggiungi una scheda si sicurezza</button>
					</div>
				<?php } ?>

				<div class="collapse row-fluid" id="divAggiungiSchedaSicurezza">
					<form autocomplete="off" method="POST" action="api/aggiungicollocazioneschedareagente.php" id="nuovaSchedaSicurezza">

						<?php 
							echo "<input type=\"hidden\" name=\"idReagente\" value=\"".$idReagente."\">";
							echo "<input type=\"hidden\" name=\"idScheda\" value=\"".$idScheda."\">";
						?>

						<!--Collocazione della nuova scheda-->
						<div class="row">
							<div class="col-sm-3">
								<label for="siglastanza"><h4>Collocazione</h4></label>
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
								<h4><input type="text" name="quantita" id="quantita" class="defaultempty" onblur="checkInput('quantita')" placeholder="Quantità"></h4>
							</div>
						</div>
						<div class="row">
							<div class="col-sm-3">
								<input type="submit" name="inviaNuovaCollocazione" class="btn btn-success" value="Salva">
							</div>
						</div>
					</form>
				</div>
			</div>
			
			<!--
				- nome delle esperienze collegate
			-->
			<h2 class="titoloSezione text-center" id="mostra-tabella-esperienze">Esperienze collegate</h2>

			<div id="tabella-esperienze">
				<div class="table-responsive">
					<table class="table table-striped">
						<tbody>
							<thead>
								<th>Nome dell'esperienza collegata</th>
								<th>Link</th>
								<th>
									<?php if ( in_array($_SESSION['nomeCategoria'], array('Amministratore', 'Docente', 'ITP')) ) { ?>
									Azioni
									<?php } ?>
								</th>
							</thead>
							<tbody>
								<?php stampaEsperienzeDidattiche(); ?>
							</tbody>
						</tbody>
					</table>
				</div>

				<?php if ( in_array($_SESSION['nomeCategoria'], array('Amministratore', 'Docente')) ) { ?>
					<div class="container row">
						<button class="btn btn-primary" id="btnAggiungiEsperienza">Aggiungi un'esperienza collegata</button>
					</div>
				<?php } ?>

				<div class="collapse row-fluid" id="divAggiungiEsperienza">
					<form autocomplete="off" method="POST" action="api/aggiungiesperienza.php" id="aggiungiEsperienza">
						<?php 
							echo "<input type=\"hidden\" name=\"idReagente\" value=\"".$idReagente."\">";
						?>

						<div class="col-sm-6">
							<h4><input type="text" name="nomeEsperienza" id="nomeEsperienza" class="defaultempty" onblur="checkInput('nomeEsperienza')" placeholder="Nome esperienza" required="true"></h4>
						</div>
						<div class="col-sm-6">
							<h4><input type="text" name="linkEsperienza" id="linkEsperienza" class="defaultempty" onblur="checkInput('linkEsperienza')" placeholder="Link dell'esperienza" required="true"></h4>
						</div>
						<div class="row">
							<div class="col-sm-12">
								<input type="submit" name="inviaNuovaEsperienza" class="btn btn-success" value="Salva">
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
