<?php
include_once "header_azur.php";
include_once "bdd/webservice_azur.php";
include_once "bdd/connexion.php";
?>
<section>
	<div class="transbox"  style="position:absolute">
		<?php
			$livres = new Webservice_Azur($db); 		
			$livres->ListeLivreAzur($db);
		
			if (isset($_GET['id2'])){
				$livres->DeleteLivreAzur($db);
			}
		?>
		</p>
	</div>
</section>

<?php
/*
include_once "footer.php";
 * 
 */
?>

