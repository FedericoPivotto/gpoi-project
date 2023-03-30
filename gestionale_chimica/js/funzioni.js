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

$(document).ready(function(){

	//Funzioni che nascondono o mostrano le tabelle nella pagina del reagente, nella strumentazione e nella vetreria
	//per la sezione della collocazione
	$('#tabella-collocazione').hide();
	$('#mostra-tabella-collocazione').click(function() {
		$('#tabella-collocazione').toggle();
	});

	//Per la tabella della scheda, usata anche per il manuale della strumentazione
	$('#tabella-scheda').hide();
	$('#mostra-tabella-scheda').click(function() {
		$('#tabella-scheda').toggle();
	});

	//Usata solo per le esperienze di laboratorio collegate ad un reagente
	$('#tabella-esperienze').hide();
	$('#mostra-tabella-esperienze').click(function() {
		$('#tabella-esperienze').toggle();
	});

	//Funzione che mostra o nasconde i bottoni per resettare i campi
	//nel form di ricerca del reagente
	//consulta.html
	//Funzione per l'aspetto del reagente
	$(function(){
		$('#resettaAspetto').hide();
		$('#aspetto').change(function(){
			$('#resettaAspetto').show();
		});
	});

	$('#resettaAspetto').click(function(){
		$('#aspetto').prop('selectedIndex',0);
		$('#resettaAspetto').hide();
	})
	
	//Funzione per la modalità di conservazione del reagente
	$(function(){
		$('#resettaModConservazione').hide();
		$('#modalitaConservazione').change(function(){
			$('#resettaModConservazione').show();
		});
	});

	$('#resettaModConservazione').click(function(){
		$('#modalitaConservazione').prop('selectedIndex',0);
		$('#resettaModConservazione').hide();
	})

	$('#btnAggiungiCollocazione').click(function() {
		//Svuota i campi
		$('#divAggiungiCollocazione').toggle();
		$('#nuovaCollocazione').find(':text').removeClass();
		$('#nuovaCollocazione').find(':text').val(null);
		$('#nuovaCollocazione').find(':text').addClass("defaultempty");
	});

});