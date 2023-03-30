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
		<title>Aggiungi uno strumento</title>
		<?php
			require_once('api/formaggiuntastrumento.php');
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

	<script type="text/javascript">

		//Funzione che gestisce la comparsa/scomparsa degli elementi del tipo di ricerca
		$(document).ready(function(){

			$('#bottonetipoStrumento').hide();
			$('#bottonestrumento').hide();
			//Nasconde tutti gli elementi con classe tipo (i due grandi pezzi della pagina
			//quello per l'aggiunta dello strumento e quello del tipo di strumento)
			$('.tipo').hide();


			$('#tipoAggiunta').change(function(){
				$('.tipo').find(':text').removeClass();
				$('.tipo').find(':text').val(null);
				$('.tipo').find(':text').addClass("defaultempty");

				//Nasconde i due bottoni per inviare i form
				$('#bottonetipoStrumento').hide();
				$('#bottonestrumento').hide();

				//Nasconde la sezione di pagina collegata
				$('.tipo').hide();
				//Mostra la sezione interessata
				$('#'+$(this).val()).show();
				//Mostra anche il bottone interessato
				$('#bottone'+$(this).val()).show();
			});

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
				if($('#tipoAggiunta').val()==="tipoStrumento")
				{
					if(($('#checkDig').prop("checked") == false) && ($('#checkFis').prop("checked") == false))
					{
						$("[name='aggiungiTipoStrumento']").prop('disabled',true);
					}else
					{
						$("[name='aggiungiTipoStrumento']").prop('disabled',false);
					}
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
					<h1>Aggiungi uno strumento</h1>
				</div>
			</div>
		</div>

		<div class="container">
			<div class="row">
				<?php
					if(isset($_POST['aggiungiStrumento'])) {
						require_once('api/nuovostrumento.php');
						aggiungiNumeroInventario();
					}
				?>

				<?php
					if(isset($_POST['aggiungiTipoStrumento'])) {
						require_once('api/aggiungistrumento.php');
						aggiungiStrumento();
					}
				?>
			</div>
			<!--Chiedi all'utente se vuole inserire un nuovo tipo di strumento o un nuovo strumento-->
			<div class="row">
				<div class="col-sm-4">
					<p>Scegli cosa inserire</p>
				</div>
				<div class="col-sm-6">
					<select class="form-control" id="tipoAggiunta" placeholder="Tipo di operazione" autocomplete="off">
						<option value="" selected="true" disabled="disabled">Scegli</option>
						<option value="tipoStrumento">Nuovo tipo di strumentazione</option>
						<option value="strumento">Nuovo strumento</option>
					</select>
				</div>
			</div>

			<!--Inserimento di un nuovo tipo di strumento-->
			<div class="tipo" id="tipoStrumento" style="">
				<!--FORM-->
				<form autocomplete="off" method="post" action="">
					<!--Titolo della sezione-->
					<div class="row" style="text-align: center;">
						<h2 class="titoloTipo">Nuovo tipo di strumentazione</h2>
					</div>

					<!--Nome-->
					<div class="row">
						<div class="col-sm-3">
							<label for="nome"><h4>Nome:</h4></label>
						</div>
						<div class="col-sm-9">
							<h4><input type="text" name="nome" id="nome" class="defaultempty" onblur="checkInput('nome')" required></h4>
						</div>
					</div>
					
					<!--Caratteristiche tecniche-->
					<div class="row">
						<div class="col-sm-3">
							<label for="caratteristiche"><h4>Caratteristiche tecniche:</h4></label>
						</div>
						<div class="col-sm-9">
							<h4><input type="text" name="caratteristiche" id="caratteristiche" class="defaultempty" onblur="checkInput('caratteristiche')" required></h4>
						</div>
					</div>

					<!--Nome manuale-->
					<div class="row">
						<div class="col-sm-3">
							<label for="nomemanuale"><h4>Nome del manuale di istruzioni:</h4></label>
						</div>
						<div class="col-sm-9">
							<h4><input type="text" name="nomemanuale" id="nomemanuale" class="defaultempty" onblur="checkInput('nomemanuale')" required></h4>
						</div>
					</div>

					<!--Data di rilascio del manuale-->
					<div class="row">
						<div class="col-sm-3">
							<label for="datarilasciomanuale"><h4>Data di rilascio del manuale:</h4></label>
						</div>
						<div class="col-sm-9">
							<h4><input type="date" name="datarilasciomanuale" id="datarilasciomanuale" class="form-control" onblur="checkInput('datarilasciomanuale')" required></h4>
						</div>
					</div>

					<!--Checkbox per manuale, se fisico o digitale-->
					<div class="row">
						<div class="col-sm-3">
							<label for="tipomanuale"><h4>Il manuale è:</h4></label>
						</div>
						<div class="form-check">
							<div class="col-sm-2">
								<input type="checkbox" name="checkFis" id="checkFis" class="form-check-input">
								<label for="manualeFisico" class="form-check-label"><h4>Fisico</h4></label>
							</div>
							<div class="col-sm-2">
								<input type="checkbox" name="checkDig" id="checkDig" class="form-check-input">
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
							<h4><input type="text" name="linkmanuale" id="linkmanuale" class="defaultempty" onblur="checkInput('linkmanuale')"></h4>
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
								<h4><input type="text" name="stanzaTipoStrumento" id="stanzaTipoStrumento" class="defaultempty" onblur="checkInput('stanzaTipoStrumento')" placeholder="Laboratorio"></h4>
							</div>
							<div class="col-sm-3">
								<h4><input type="text" name="armadioTipoStrumento" id="armadioTipoStrumento" class="defaultempty" onblur="checkInput('armadioTipoStrumento')" placeholder="Armadio"></h4>
							</div>
							<div class="col-sm-3">
								<h4><input type="text" name="ripianoTipoStrumento" id="ripianoTipoStrumento" class="defaultempty" onblur="checkInput('ripianoTipoStrumento')" placeholder="Ripiano"></h4>
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

					<div id="bttonetipoStrumento" style="">
						<div class="row">
							<input class="btn btn-success" type="submit" name="aggiungiTipoStrumento" value="Aggiungi">
						</div>
					</div>
				</form>
				<!--Fine form inserimento tipo strumento-->
			</div>

			<!--Inserimento di un nuovo strumento-->
			<div class="container tipo" id="strumento" style="">
				<form autocomplete="off" method="post">
					<!--Titolo della sezione-->
					<div class="row" style="text-align: center;">
						<h2 class="titoloTipo">Nuovo strumento</h2>
					</div>
					
					<div class="row">
						<div class="col-sm-3">
							<label for="linkmanuale"><h4>Tipo di strumento</h4></label>
						</div>
						<div class="col-sm-9">
							<select class="form-control" name="nomeStrumento" placeholder="Tipologia di strumento" autocomplete="off">
								<option value="" selected="true" disabled="disabled">Scegli</option>
								<?php stampaElencoStrumenti(); ?>
							</select>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-3">
							<label for="numeroinventario"><h4>Numero di inventario:</h4></label>
						</div>
						<div class="col-sm-9">
							<h4><input type="text" name="numeroinventario" id="numeroinventario" class="defaultempty" onblur="checkInput('numeroinventario')" required></h4>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-3">
							<label for="siglastanza"><h4>Collocazione (Fisico)</h4></label>
						</div>
						<!--I tre elementi della collocazione: stanza, armadio ripiano-->
						<div class="col-sm-3">
							<h4><input type="text" name="stanzaStrumento" id="stanzaStrumento" class="defaultempty" onblur="checkInput('stanzaStrumento')" placeholder="Laboratorio" required></h4>
						</div>
						<div class="col-sm-3">
							<h4><input type="text" name="armadioStrumento" id="armadioStrumento" class="defaultempty" onblur="checkInput('armadioStrumento')" placeholder="Armadio" required></h4>
						</div>
						<div class="col-sm-3">
							<h4><input type="text" name="ripianoStrumento" id="ripianoStrumento" class="defaultempty" onblur="checkInput('ripianoStrumento')" placeholder="Ripiano" required></h4>
						</div>
					</div>

					<div id="bttonestrumento" style="">
						<div class="row">
							<input class="btn btn-success" type="submit" name="aggiungiStrumento" value="Aggiungi">
						</div>
					</div>
				</form>
				<!--Fine form inserimento nuovo strumento-->
			</div>
		</div>
		<br><br>
	</body>

</html>