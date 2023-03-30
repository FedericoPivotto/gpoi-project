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
		<title>Aggiungi un reagente</title>
		<?php
			require_once('api/formaggiuntareagente.php');
			session_start();
			//echo "\$_SESSION': " . print_r($_SESSION);
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

	<style>
		/*Questi stili vengono usati per l'inserimento dei pittogrammi nella pagina di inserimento del reagente*/
		input[type="checkbox"].pittogramma
		{
			display:none;
		}

		label.check
		{
			cursor: pointer;
			transition: 0.2s;
		}
		:checked + label.check
		{
			cursor: pointer;
			border-radius: 5px 5px 5px 5px;
			background-color: #5AB06C;
			transition: 0.2s;
		}
	</style>

	<script>
		//Funzione che gestisce la comparsa/scomparsa degli elementi del tipo di ricerca
		$(document).ready(function(){

			//Funzione per check e uncheck per le checkbox riguardanti il manuale
			$('#checkDig').change(function()
			{
				if(this.checked)
					$('#campiPerManualeDigitale').fadeIn('slow');
				else
					$('#campiPerManualeDigitale').fadeOut('slow');
					$('#campiPerManualeDigitale').find('input:text').val('');
			});

			$('#checkFis').change(function()
			{
				if(this.checked)
					$('#campiPerManualeFisico').fadeIn('slow');
				else
					$('#campiPerManualeFisico').fadeOut('slow');
					$('#campiPerManualeFisico').find('input:text').val('');
			});

			$('body').mousemove(function(){
				if(($('#checkDig').prop("checked") == false) && ($('#checkFis').prop("checked") == false))
				{
					$("[name='aggiungiReagente']").prop('disabled',true);
				}else
				{
					$("[name='aggiungiReagente']").prop('disabled',false);
				}
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
					<h1>Aggiungi un reagente</h1>
				</div>
			</div>
		</div>

		<div class="container">
			<!--
				Caratteristiche di base
				Nome
				Formula chimica
				Stato (solido, gassoso o liquido)
			-->
			<div class="row">
				<?php
					if(isset($_POST['aggiungiReagente'])) {
						require_once('api/aggiungireagente.php');
						aggiungiReagente();
					}
				?>
			</div>

			<form autocomplete="off" method="post" action="">
				<!--Titolo della sezione-->
					<div class="row" style="text-align: center;">
						<h2 class="titoloTipo">Nuovo tipo di reagente</h2>
					</div>

				<!--Nome del reagente-->
				<div class="row">
					<div class="col-sm-3">
						<label for="nome"><h4>Nome:</h4></label>
					</div>
					<div class="col-sm-9">
						<h4><input type="text" name="nome" id="nome" class="defaultempty" onblur="checkInput('nome')" required="true"></h4>
					</div>
				</div>

				<!--Formula-->
				<div class="row">
					<div class="col-sm-3">
						<label for="formula"><h4>Formula:</h4></label>
					</div>
					<div class="col-sm-9">
						<h4><input type="text" name="formula" id="formula" class="defaultempty" onblur="checkInput('formula')" required="true"></h4>
					</div>
				</div>

				<!--Stato della materia-->
				<div class="row">
					<div class="col-sm-3">
						<label for="stato"><h4>Stato:</h4></label>
					</div>
					<div class="col-sm-9">
						<select class="form-control" name="stato" id="stato" required="true">
							<option value="" selected="true" disabled="disabled">Scegli</option>
							<?php stampaElencoAspetto(); ?>
						</select>
					</div>
				</div>

				<hr>

				<!--Ditta produttrice-->
				<div class="row">
					<div class="col-sm-3">
						<h4>Ditta produttrice:</h4>
					</div>
					<div class="col-sm-9">
						<select class="form-control" name="nomeDitta" id="stato" required="true">
							<option value="" selected="true" disabled="disabled">Scegli</option>
							<?php stampaElencoDittaProduttrice(); ?>
						</select>
					</div>
				</div>

				<!--Modalità di conservazione-->
				<div class="row">
					<div class="col-sm-3">
						<label for="modalitaConservazione"><h4>Modalità di conservazione:</h4></label>
					</div>
					<div class="col-sm-9">
						<h4><input type="text" name="modalitaConservazione" id="modalitaConservazione" class="defaultempty" onblur="checkInput('modalitaConservazione')" required="true"></h4>
					</div>
				</div>

				<!--Temperatura di conservazione-->
				<div class="row">
					<div class="col-sm-3">
						<label for="temperaturaConservazione"><h4>Temperatura di conservazione:</h4></label>
					</div>
					<div class="col-sm-9">
						<h4><input type="text" name="temperaturaConservazione" id="temperaturaConservazione" class="defaultempty" onblur="checkInput('temperaturaConservazione')" required="true"></h4>
					</div>
				</div>

				<hr>

				<!--Scheda di sicurezza-->
				<div class="row">
					<div class="col-sm-3">
						<label for="nomescheda"><h4>Scheda di sicurezza:</h4></label>
					</div>
					<div class="col-sm-9">
						<h4><input type="text" name="nomescheda" id="nomescheda" class="defaultempty" onblur="checkInput('nomescheda')" required="true"></h4>
					</div>
				</div>

				<!--Data di rilascio-->
				<div class="row">
					<div class="col-sm-3">
						<label for="datarilascioscheda"><h4>Data di rilascio della scheda:</h4></label>
					</div>
					<div class="col-sm-9">
						<h4><input type="date" name="datarilascioscheda" id="datarilascioscheda" class="form-control" onblur="checkInput('datarilascioscheda')" required="true"></h4>
					</div>
				</div>

				<!--Checkbox per manuale, se fisico o digitale-->
				<div class="row">
					<div class="col-sm-3">
						<label for="tipomanuale"><h4>Il manuale è:</h4></label>
					</div>
					<div class="form-check">
						<div class="col-sm-2">
							<input type="checkbox" name="checkFis" id="checkFis" value="isDig" class="form-check-input">
							<label for="manualeFisico" class="form-check-label"><h4>Fisico</h4></label>
						</div>
						<div class="col-sm-2">
							<input type="checkbox" name="checkDig" id="checkDig" value="isDig" class="form-check-input">
							<label for="manualeDigitale" class="form-check-label"><h4>Digitale</h4></label>
						</div>
					</div>
				</div>

				<!--Link del manuale (se è digitale)-->
				<div class="container-fluid row" id="campiPerManualeDigitale" style="display: none;">
					<div class="col-sm-3">
						<label for="linkmanuale"><h4>Link al manuale (Digitale)</h4></label>
					</div>
					<div class="col-sm-9">
						<h4><input type="text" name="linkscheda" id="linkmanuale" class="defaultempty" onblur="checkInput('linkmanuale')"></h4>
					</div>
				</div>

				<!--Collocazione e quantità se il manuale è anche fisico-->
				<div class="container-fluid" id="campiPerManualeFisico" style="display: none;">
					<div class="row">
						<div class="col-sm-3">
							<label for="siglastanza"><h4>Collocazione (Fisico)</h4></label>
						</div>
						<!--I tre elementi della collocazione: stanza, armadio ripiano-->
						<div class="col-sm-3">
							<h4><input type="text" name="stanzaManuale" id="stanzaManuale" class="defaultempty" onblur="checkInput('stanzaManuale')" placeholder="Laboratorio"></h4>
						</div>
						<div class="col-sm-3">
							<h4><input type="text" name="armadioManuale" id="armadioManuale" class="defaultempty" onblur="checkInput('armadioManuale')" placeholder="Armadio"></h4>
						</div>
						<div class="col-sm-3">
							<h4><input type="text" name="ripianoManuale" id="ripianoManuale" class="defaultempty" onblur="checkInput('ripianoManuale')" placeholder="Ripiano"></h4>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-3">
							<label for="quantita"><h4>Quantità</h4></label>
						</div>
						<div class="col-sm-9">
							<h4><input type="text" name="quantita" id="quantita" class="defaultempty" onblur="checkInput('quantita')"></h4>
						</div>
					</div>
				</div>

				<!--Pittogrammi di sicurezza-->
				<div class="row">
					<div class="col-sm-3">
						<h4>Pittogrammi di sicurezza</h4>
					</div>
					<div class="col-sm-9">
						<?php stampaElencoPittogrammi(); ?>
					</div>
				</div>
				<div class="row">
					<input class="btn btn-success" type="submit" name="aggiungiReagente" value="Aggiungi">
				</div>
			</form>
		</div>

		<br><br>

	</body>
</html>