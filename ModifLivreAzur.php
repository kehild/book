<script type="text/javascript" src="./jquery.min.js"></script>
<?php
include_once "header_azur.php";
include_once "bdd/webservice.php";
include_once "bdd/connexion.php";
?>	
	<p><?php 
			$livre = new Webservice($db);
			$livre->modification_azur($db);

			if (isset($_POST['Annuler'])) {
				echo '<meta http-equiv="refresh" content="0;URL=azur.php">';	
			}
			if (isset($_POST['Modifier'])) {
				$livre->UpdateLivreAzur($db);
			}
		?>
	</p>
<?php
include_once "footer.php";
?>
