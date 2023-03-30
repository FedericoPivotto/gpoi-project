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
		<title>Admin</title>

		<?php
		require_once('api/utenti.php');
		session_start();
		if(isset($_SESSION['isLogged'])) {
			if($_SESSION['isLogged'] == "no") {
				header("location: /login.php");
			} else {
				if(!in_array($_SESSION['nomeCategoria'], array('Amministratore'))) {
					header("location: /home.php");
				}
			}
		} else if(!isset($_SESSION['isLogged'])) {
			header("location: /login.php");
		}
		?>
	</head>

	<!--Questi stili sono specifici per questa pagina-->
	<style>
		td
		{
			text-align: left;
		}
	</style>

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
			</nav>
			
			<div class="jumbotron container-fluid" style="text-align:center;">
				<div class="row">
					<div class="col-sm-3">
						<img src="media/logo_itis.gif">
					</div>
					<div class="col-sm-8">
						<h1>Admin</h1>
					</div>
				</div>
			</div>

			<div class="container">
				<h2 class="titoloSezione text-center" id="mostra-tabella-utenti">Creazione account</h2>
				<div style="text-align:center;" >
					<br>
					<form method=POST>
						<div class="form-check" >
							<input class="form-check-input" type="radio" name="categoriaUtente" id="categoriaUtente" value="Studente" checked>
							<label class="form-check-label" for="categoriaUtente">Studente</label>
							&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							<input class="form-check-input" type="radio" name="categoriaUtente" id="categoriaUtente" value="Docente">
							<label class="form-check-label" for="categoriaUtente">Docente</label>
							&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							<input class="form-check-input" type="radio" name="categoriaUtente" id="categoriaUtente" value="ITP">
							<label class="form-check-label" for="categoriaUtente">ITP</label>
						</div>
						<br>
						<input type="submit" name="btnGenera" class="btn btn-primary" value="Genera account">
					</form>

					<br>
					
					<?php
					if(isset($_POST['btnGenera']))
					{
						require_once('api/generacredenziali.php');
					?>

					<div class="container-fluid">
						<div class="table-responsive" id="tabella-utenti">
							<table class="table table-striped">
								<thead>
									<th>Username</th>
									<th>Password</th>
								</thead>
								<tbody>
									<tr>
										<!--username utente-->
										<td>
											<?php
											if(isset($_POST['btnGenera']))
											{
												echo $username;
											}
											?>
										</td>
										<!--password utente-->
										<td>
											<?php
											if(isset($_POST['btnGenera']))
											{
												echo $password;
											}
											?>
										</td>
									</tr>
								</tbody>
							</table>
						</div>
					</div>
					<?php } ?>
	            </div>
	            
	            <br>

	            <h2 class="titoloSezione text-center" id="mostra-tabella-utenti">Account esistenti</h2>
	            <div class="container-fluid">
	            	<div class="table-responsive" id="tabella-utenti">
	            		<form method="POST" action="api/eliminautente.php">
	            			<table class="table table-striped">
	            				<thead>
	            					<th>Username</th>
	            					<th>Categoria</th>
	            					<th>Elimina</th>
	            				</thead>
	            				<tbody>
	            					<?php stampaUtentiCategorie(); ?>
	                            </tbody>
	                        </table>
	                        <div style="text-align:center;">
	                        	<input type="submit" class="btn btn-danger" value="Elimina utenti">
	                        </div>
	                    </form>
	                </div>
	            </div>
	        </div>
	        <br>
	    </body>
</html>
