<script type="text/javascript" src="./jquery.min.js"></script>
<script type="text/javascript" src="./jquery.autocomplete.min.js"></script>

﻿<?php
include_once "header_livre.php";
include_once "bdd/connexion.php";
include_once "bdd/webservice.php";

if (isset($_POST['Valider'])) {
	$livre = new Webservice($db);
        $livre->CadreImage(); 
	$livre->SaisieLivre($db,$_POST['titre'],$_POST['tome'],$_POST['page'],$_POST['auteur'],$_POST['annee'],$_POST['theme'],$_POST['format'],$_POST['date_lecture'],$_POST['file'],$_POST['editeur'],$_POST['note']);	
}

?>

<div>
  <form method="post" action="">
    	</br>
	<label for="titre">Titre</label>
    	</br>
	<input type="text" id="titre" name="titre">
	</br>
	<label for="tome">Nombre Tome</label>
    	</br>
	<input type="text" id="tome" name="tome">
	</br>
	<label for="page">Nombre Page</label>
   	 </br>
	<input type="text" id="page" name="page">
	</br>
    <label for="auteur">Auteur</label>
    </br>
	<input type="text" id="auteur" name="auteur">&nbsp;
	</br>
	<label for="annee">Année</label>
    	</br>
	<input type="text" id="annee" name="annee">
	</br>
	<label for="theme">Thème</label>
    	</br>
	<input type="text" id="theme" name="theme">&nbsp;<?php // $livre = new Webservice($db); $livre->ThemeConnu($db); ?>
	</br>
	<label for="format">Format</label>
   	 </br>
	<select name="format" id="format">
        <option value="papier">Papier</option>
		<option value="numerique">Numérique</option>
		<option value="numerique amazon">Numérique Amazon</option>		
		<option value="papier/numerique">Papier / Numérique</option>		
	</select>
	</br>
	<label for="resume">Résumé</label>
   	 </br>
	<textarea name="resume" rows="6" cols="60"></textarea>
	</br>
	<label for="date_lecture">Année de lecture</label>
    </br>
	<input type="text" id="date_lecture" name="date_lecture">
    </br>
	 <label for="editeur">Editeur</label>
    </br>
	<input type="text" id="editeur" name="editeur">&nbsp;
	</br>
    <label for="image">Image</label>
	</br>
	<input type="file" id="file" name="file">
	</br>
	<label for="note">Note 1 à 20</label>
	</br>
	<select name="note" id="note">
        <option value="1">1</option>
		<option value="2">2</option>
		<option value="3">3</option>		
		<option value="4">4</option>
		<option value="5">5</option>
		<option value="6">6</option>
		<option value="7">7</option>
		<option value="8">8</option>
		<option value="9">9</option>
		<option value="10">10</option>
        <option value="11">11</option>
		<option value="12">12</option>
		<option value="13">13</option>		
		<option value="14">14</option>
		<option value="15">15</option>
		<option value="16">16</option>
		<option value="17">17</option>
		<option value="18">18</option>
		<option value="19">19</option>
		<option value="20">20</option>		
	</select>

	
    <input type="submit" name="Valider" value="Valider">
  </form>
</div>

<?php
	include_once"footer.php";
?>

<script>
$(document).ready(function() {
    $('#auteur').autocomplete({
        serviceUrl: 'auto.php',
        dataType: 'json'
    });
});

$(document).ready(function() {
    $('#theme').autocomplete({
        serviceUrl: 'auto_theme.php',
        dataType: 'json'
    });
});

$(document).ready(function() {
    $('#editeur').autocomplete({
        serviceUrl: 'auto_editeur.php',
        dataType: 'json'
    });
});
 
</script>    