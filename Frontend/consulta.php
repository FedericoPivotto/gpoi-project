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
		<title>Consulta i dati</title>

		<?php
			require_once('api/ricerca.php');
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
	</head>

	<style>
		table thead tr .bluheader
		{
			background-color: #3a6e9e;
			color:white;
		}

		table thead tr .orangeheader
		{
			background-color: #fe9103;
			color:white;
		}

		.titoloSezione
		{
			border-radius: 50px 15px 50px 15px;
			border-style:none;
			color:white;
			background: #79828c;
			transition: 0.2s;
			padding:1%;
			text-align: center;
		}

	</style>

	<script type="text/javascript">	
		$(document).ready(function(){
			$('#tipoRicerca').change(function(){
				$('.tipo').hide();
				$('#'+$(this).val()).show();
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
					<h1>Consulta i dati</h1>
				</div>
			</div>
		</div>
		<div class="container">

			<div class="row">
				<h3 class="titoloSezione">Scegli cosa vuoi cercare:</h3>
			</div>

			<div class="row">
				<select class="form-control" id="tipoRicerca" name="tipoRicerca" placeholder="Tipo di dato da cercare" autocomplete="off">
					<option value="" selected="true" disabled="disabled">Scegli</option>
					<option value="reagente">Reagente</option>
					<option value="vetreria">Vetreria</option>
					<option value="strumentazione">Strumentazione</option>
				</select>
			</div>

			<br>

			<!--INIZIO FORM DI RICERCA REAGENTE-->
			<div class="tipo container-fluid" id="reagente" style="display: none;">
				<form autocomplete="off" method="POST"> <!-- action="api/consultareagente.php" -->
					<div class="row">
						<div class="col-sm-3">
							<label for="nome">Nome del reagente</label>
							<input type="text" class="form-control" id="nome" name="nomeReagente" placeholder="Nome del reagente">
						</div>
						<div class="col-sm-3">
							<label for="aspetto">Aspetto del reagente</label>
							<select class="form-control" id="aspetto" name="aspetto" placeholder="Aspetto del reagente">
								<option value="" selected="true" disabled="disabled">Scegli</option>
								<?php stampaElencoAspetto(); ?>
								<!-- <option value="solido">Solido</option>
								<option value="liquido">Liquido</option>
								<option value="gassoso">Gassoso</option> -->
							</select>
							<!--Questo bottone (e il suo gemello) è soggetto ad una funzione jQuery che controlla se viene cambiato
							l'opzione nel select anitstante, se si allora questo bottone compare e viene visualizzato in modo che l'utente
							abbia la possibilità di resettare l'input-->
							<button type="button" class="btn btn-warning btn-block" id="resettaAspetto">Annulla la selezione</button>
						</div>
						<div class="col-sm-3">
							<label for="dittaProduttrice">Ditta produttrice</label>
							<input type="text" class="form-control" id="dittaProduttrice" name="dittaProduttrice" placeholder="Ditta produttrice">
						</div>
						<div class="col-sm-3">
							<label for="modalitaConservazione">Conservazione</label>
							<select class="form-control" id="modalitaConservazione" name="modalitaConservazione" placeholder="Modalità di conservazione">
								<option value="" selected="true" disabled="disabled">Scegli</option>
								<?php stampaElencoConservazioni(); ?>
								<!-- <option value="contenitore_chiuso">Contenitore chiuso</option>
								<option value="temperatura_bassa">A bassa temperatura</option>
								<option value="temperatura_ambiente">A temperatura ambiente</option> -->
							</select>
							<button type="button" class="btn btn-warning btn-block" id="resettaModConservazione">Annulla la selezione</button>
						</div>
					</div>
					<br>
					<div class="row">
						<input name="btnReagente" class="btn btn-success" type="submit" value="Cerca">
					</div>
				</form>
			</div>
			<!--FINE FORM DI RICERCA REAGENTE-->

			<!--INIZIO FORM DI RICERCA VETRERIA-->
			<div class="tipo container-fluid" id="vetreria" style="display: none;">
				<form autocomplete="off" method="GET" action="/vetreria.php">
					<!--OUUUUUUU QUI MANCA LA ACTION FRAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA-->
					<div class="row">
						<label for="nomeVetreria">Tipo di vetreria</label>
						<select class="form-control" id="nomeVetreria" name="idVetreria" placeholder="Nome della vetreria" required>
							<option value="" selected="true" disabled="disabled" required>Scegli</option>
							<?php stampaElencoVetreria(); ?>
							<!-- <option value="becher">Becher</option>
							<option value="cilindro">Cilindri</option>
							<option value="provette">Provette</option>
							<option value="matracci">Matracci</option>
							<option value="palloni">Palloni</option>
							<option value="imbuti">Imbuti</option>
							<option value="burette">Burette</option> -->
						</select>
					</div>
					<br>
					<div class="row">
						<input name="btnVetreria" class="btn btn-success" type="submit" value="Cerca">
					</div>
				</form>
			</div>
			<!--FINE FORM DI RICERCA VETRERIA-->

			<!--INIZIO FORM DI RICERCA STRUMENTAZIONE-->
			<div class="tipo container-fluid" id="strumentazione" style="display: none;">
				<form autocomplete="off" method="POST" action="">
					<div class="row">
						<div class="col-sm-6">
							<label for="nomeAttrezzatura">Nome dell'attrezzatura</label>
							<input type="text" class="form-control" id="nomeAttrezzatura" name="nomeAttrezzatura" placeholder="Nome dell'attrezzatura">
						</div>
						<div class="col-sm-6">
							<label for="numeroInventario">Numero di inventario</label>
							<input type="text" class="form-control" id="numeroInventario" name="numeroInventario" placeholder="Numero di inventario">
						</div>
					</div>
					<br>
					<div class="row">
						<input name="btnStrumentazione" class="btn btn-success" type="submit" value="Cerca">
					</div>
				</form>
			</div>
			<!--FINE FORM DI RICERCA STRUMENTAZIONE-->

			<?php if(isset($_POST['btnStrumentazione']) || isset($_POST['btnReagente'])) { ?>
				<div class="row">
					<h3 class="titoloSezione">Risultato della ricerca:</h3>
				</div>
			<?php } ?>

			<!--RISULTATO DELLA RICERCA REAGENTE-->
			<!--
				DA NASCONDERE SE NON DEVE VISUALIZZARE DATI
				STESSA COSA PER I RISULTATI DELLA STRUMENTAZIONE
			-->
			<div class="container-fluid">
				<div class="row">
					<div class="table-responsive">
						<table class="table table-striped">
							<thead>
								<?php
									if(isset($_POST['btnReagente']))
									{
										echo "<tr>";
										echo "\t<th class=\"bluheader\">Nome</th>";
										echo "\t<th class=\"bluheader\">Formula</th>";
										echo "\t<th class=\"bluheader\">Stato</th>";
										echo "\t<th class=\"bluheader\">Ditta produttrice</th>";
										echo "\t<th class=\"orangeheader\">Visualizza il reagente</th>";
										echo "</tr>";
									}
								?>
							</thead>
							<tbody>
								<?php
									/* Istruzioni principali */
									if(isset($_POST['btnReagente']))
									{
										require_once('api/consultareagente.php');
										$result = consultaReagenti($nome, $aspetto, $dittaProduttrice, $modalitaConservazione);
										stampaRisultatoReagenti($result);
									}
								?>
							 	<!-- <tr>
									<td>Nitrato di potassio</td>
									<td>KNO3</td>
									<td>Solido (Polvere)</td>
									<td>Carl Roth</td>
									<td><a href="reagente.html"><button class="btn btn-warning">Vai alla pagina del reagente</button></a></td> -->
									<!--Questo bottone porta alla pagina reagente.php, gli viene passata in POST la formula chimica (che dovrebbe essere unica)
									in questo modo, nella pagina reagente.php viene eseguita una query di ricerca in base alla formula che gli viene passata in POST,
									all'interno della pagina verrano visualizzati i dati presi dal DB come risultato della ricerca partendo dalla formula (nel nostro caso
									nella pagina reagente verrano visualizzati id ati collegati al reagente KNO3)-->
									<!--<td><a href="reagente.php?idReagente=1"><button>Vai alla pagina del reagente</button></a></td>-->
								<!-- </tr>
								<tr>
									<td>Ossido di zinco</td>
									<td>ZnO</td>
									<td>Solido (Polvere)</td>
									<td>Carl Roth</td>
									<td><a href="reagente.html"><button class="btn btn-warning">Vai alla pagina del reagente</button></a></td>
								</tr>
								<tr>
									<td>Stracchino</td>
									<td>Str</td>
									<td>Solido (Estremamente molle)</td>
									<td>Nonno Nanni</td>
									<td><a href="reagente.html"><button class="btn btn-warning">Vai alla pagina del reagente</button></a></td>
								</tr> -->
							</tbody>
						</table>
					</div>
				</div>
			</div>
			<!--FINE RISULTATO DELLA RICERCA REAGENTE-->

			<!--RISULTATO DELLA RICERCA VETRERIA-->
			<!--
				Dati da visualizzare:
				- Nome
				- Collocazione (che può esser più di una)
					- Sigla della stanza
					- Codice dell'armadio
					- Numero del ripiano nell'armadio
					- per ogni collocazione anche la quantità presente in quel luogo
			-->

			<!-- <div class="container-fluid">
				<div class="row">
					<div class="table-responsive">
						<table class="table table-striped">
							<thead>
								<tr>
									<th class="bluheader">Tipo</th>
									<th class="bluheader">Laboratorio</th>
									<th class="bluheader">Codice Armadio</th>
									<th class="bluheader">Numero ripiano</th>
									<th class="bluheader">Quantità</th>
									<th class="orangeheader">Visualizza i dettagli</th>
								</tr>
							</thead>
							<tbody>
								<td>Becher</td>
								<td>Microbiologia</td>
								<td>A</td>
								<td>2</td>
								<td>3</td>
								<td><a href="vetreria.html"><button class="btn btn-warning">Vai alla pagina della vetreria</button></a></td>
							</tbody>
						</table>
					</div>
				</div>
			</div> -->
			<!--FINE RISULTATO DELLA RICERCA VETRERIA-->

			<!--RISULTATO DELLA RICERCA STRUMENTAZIONE-->
			<div class="container-fluid">
				<div class="row">
					<div class="table-responsive">
						<table class="table table-striped">
							<thead>
								<?php
									if(isset($_POST['btnStrumentazione']))
									{
										echo "<tr>";
										echo "\t<th class=\"bluheader\">Nome</th>";
										echo "\t<th class=\"bluheader\">Numero di inventario</th>";
										echo "\t<th class=\"orangeheader\">Visualizza i dettagli</th>";
										echo "</tr>";
									}
								?>
							</thead>
							<tbody>
								<?php
									/* Istruzioni principali */
									if(isset($_POST['btnStrumentazione']))
									{
										require_once('api/consultastrumentazione.php');
										$result = consultaStrumentazione($nome, $inventario);
										stampaRisultatoStrumentazione($result);
									}
								?>
								<!-- <td>Distillatore</td>
								<td>135</td>
								<td><a href="vetreria.html"><button class="btn btn-warning">Vai alla pagina dello strumento</button></a></td> -->
							</tbody>
						</table>
					</div>
				</div>
			</div>
			<!--FINE RISULTATO DELLA RICERCA REAGENTE-->
			<div class="row">
				<a href="home.php"><button class="btn btn-danger">Torna indietro</button></a>
			</div>
		</div>
		<br>
	</body>
</html>
