<script type="text/javascript" src="./jquery.min.js"></script>
<script type="text/javascript" src="./jquery.autocomplete.min.js"></script>

﻿<?php
include_once "header.php";
include_once "bdd/connexion.php";
include_once "bdd/webservice.php";

if (isset($_POST['Valider'])) {
	$livre = new Webservice($db);
    	$livre->SaisieLivreAzur($db,$_POST['titre'],$_POST['auteur'],$_POST['page'],$_POST['annee'],$_POST['resume']);	
}

?>

<div>
  <form method="post" action="">
    	</br>
	<label for="titre">Titre</label>
    	</br>
	<input type="text" id="titre" name="titre">
	</br>
	<label for="auteur">Auteur</label>
    	</br>
	<input type="text" id="auteur" name="auteur">
	</br>
	<label for="page">Nombre Page</label>
   	 </br>
	<input type="text" id="page" name="page">
	</br>
    	<label for="annee">Année</label>
    	</br>
	<input type="text" id="annee" name="annee">
	</br>
	<label for="resume">Résumé</label>
   	 </br>
	<textarea name="resume" rows="6" cols="60"></textarea>
	</br>
	<input type="submit" name="Valider" value="Valider">
  </form>
</div>

<script>
$(document).ready(function() {
    $('#auteur').autocomplete({
        serviceUrl: 'auto_azur.php',
        dataType: 'json'
    });
});

</script>    