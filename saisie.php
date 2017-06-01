<?php
include_once "header.php";
include_once "bdd/connexion.php";
include_once "bdd/webservice.php";

if (isset($_POST['Valider'])) {
	$livre = new Webservice($db);
	$livre->SaisieLivre($db,$_POST['titre'],$_POST['tome'],$_POST['page'],$_POST['auteur'],$_POST['annee'],$_POST['theme'],$_POST['format'],$_POST['date_lecture']);	
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
	<input type="text" id="auteur" name="auteur">&nbsp;<?php $livre = new Webservice($db); $livre->AuteurConnu($db); ?>
	</br>
	<label for="annee">Année</label>
    	</br>
	<input type="text" id="annee" name="annee">
	</br>
	<label for="theme">Thème</label>
    	</br>
	<input type="text" id="theme" name="theme">&nbsp;<?php $livre = new Webservice($db); $livre->ThemeConnu($db); ?>
	</br>
	<label for="format">Format</label>
   	 </br>
	<select name="format" id="format">
        	<option value="papier">Papier</option>
		<option value="numerique">Numérique</option> 
		<option value="papier/numerique">Papier / Numérique</option>		
	</select>
	</br>
	<label for="resume">Résumé</label>
   	 </br>
	<textarea name="resume" rows="6" cols="60"></textarea>
	</br>
	<label for="date_lecture">Date lecture</label>
    	</br>
	<input type="text" id="date_lecture" name="date_lecture">
    <input type="submit" name="Valider" value="Valider">
  </form>
</div>

<?php
	include_once"footer.php";
?>
