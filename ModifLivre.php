<script type="text/javascript" src="./jquery.min.js"></script>
<?php
include_once "header_livre.php";
include_once "bdd/webservice.php";
include_once "bdd/connexion.php";
?>	
	<p><?php 
			$livre = new Webservice($db);
			$livre->modification($db);

			if (isset($_POST['Annuler'])) {
				echo '<meta http-equiv="refresh" content="0;URL=livre.php">';	
			}
			if (isset($_POST['Modifier'])) {
				$livre->UpdateLivre($db);
			}
			
			if (isset($_POST['cadre'])){
				$livre->ModifCadre();
				
			}
		?>
	</p>
<?php
include_once "footer.php";
?>
