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
		<title>Aggiungi vetreria</title>
	</head>

	<script type="text/javascript">

		function checkInput(nomeElemento)
		{
			var elemento = document.getElementById(nomeElemento);
			var valueElemento = document.getElementById(nomeElemento).value;

			elemento.classList.remove("defaultempty");

			if (valueElemento.trim()=='')
			{
				//se l'input è vuoto
				//togli la classe che gestisce l'input corretto
				//e aggiungi quella che segnala che l'input è vuoto
				elemento.classList.remove("full");
				elemento.classList.add("empty");
			}
			else
			{
				elemento.classList.remove("empty");
				elemento.classList.add("full");
			}
		}

		//Funzione che gestisce la comparsa/scomparsa degli elementi del tipo di ricerca
		$(document).ready(function(){

			//Nasconde tutti gli elementi con classe tipo (i due grandi pezzi della pagina
			//quello per l'aggiunta dello srumento e quello del tipo di strumento)
			$('.tipo').hide();

			$('#tipoAggiunta').change(function(){
				$('.tipo').find('input').removeClass();
				$('.tipo').find('input').val(null);
				$('.tipo').find('input').addClass("defaultempty");
				$('.tipo').hide();
				$('#'+$(this).val()).show();
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
				if(($('#checkDig').prop("checked") == false) && ($('#checkFis').prop("checked") == false))
				{
					$("[name='btnVetreria']").prop('disabled',true);
				}else
				{
					$("[name='btnVetreria']").prop('disabled',false);
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
					<h1>Aggiungi vetreria</h1>
				</div>
			</div>
		</div>

		<div class="container">
			<div class="row">
				<?php 
					if(isset($_POST['btnVetreria'])){
						require_once('api/aggiungivetreria.php');
						aggiungiVetreria();
					}
				?>	
			</div>
			<!--Inserimento di un nuovo tipo di strumento-->
			<form autocomplete="off" method="post">
				<!--Titolo della sezione-->
				<div class="row" style="text-align: center;">
					<h2 class="titoloTipo">Nuovo tipo di vetreria</h2>
				</div>

				<!--Nome-->
				<div class="row">
					<div class="col-sm-3">
						<label for="nome"><h4>Nome:</h4></label>
					</div>
					<div class="col-sm-9">
						<h4><input type="text" name="nomeVetreria" id="nomeVetreria" class="defaultempty" onblur="checkInput('nomeVetreria')" required></h4>
					</div>
				</div>

				<div class="row">
					<input name="btnVetreria" class="btn btn-success" type="submit" value="Aggiungi">
				</div>
			</form>
		</div>
	</body>
