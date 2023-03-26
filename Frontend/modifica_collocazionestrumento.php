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
		<title>Modifica collocazione</title>

		<link rel="stylesheet" href="/css/styles.css">

        <?php
            session_start();
            if(isset($_SESSION['isLogged'])) {
                if($_SESSION['isLogged'] == "no") {
                    header("location: /login.php");
                } else {
                    if(!in_array($_SESSION['nomeCategoria'], array('Amministratore', 'Docente', 'ITP'))) {
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
			</div>
		</nav>

        <div class="jumbotron container-fluid" style="text-align:center;">
            <div class="row">
                <div class="col-sm-3">
                    <img src="media/logo_itis.gif">
                </div>
                <div class="col-sm-8">
                    <h1>Modifica collocazione</h1>
                </div>
            </div>
        </div>

        <div class="container">
    		<h2 class="titoloSezione text-center" id="mostra-tabella-utenti">Modifica collocazione</h2>
    		<form autocomplete="off" method="POST" action="api/modificacollocazionestrumento.php">
                <?php 
                    echo "<input type=\"hidden\" name=\"idStrumentazione\" value=\"".$_GET['idStrumentazione']."\">";
                    echo "<input type=\"hidden\" name=\"numeroInventario\" value=\"".$_GET['numeroInventario']."\">";
                ?>
	            <div style="text-align:center;">
					<div class="form-group">
						<label for="exampleFormControlSelect1">Stanza</label>
						<input type="text" name="stanza" id="stanza" class="defaultempty" onblur="checkInput('stanza')" placeholder="Laboratorio" required="true">
				  	</div>
					<div class="form-group">
						<label for="exampleFormControlSelect2">Armadio</label>
						<input type="text" name="armadio" id="armadio" class="defaultempty" onblur="checkInput('armadio')" placeholder="Armadio" required="true">
					</div>
					<div class="form-group">
						<label for="exampleFormControlSelect3">Ripiano</label>
						<input type="text" name="ripiano" id="ripiano" class="defaultempty" onblur="checkInput('ripiano')" placeholder="Ripiano" required="true">
					</div>
					<input type="submit" name="btnModifica" class="btn btn-primary" value="Modifica">
				</div>
			</form>
        </div>
        <br><br>
	</body>
</html>
