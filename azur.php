<?php
include_once "header.php";
include_once "bdd/webservice.php";
include_once "bdd/connexion.php";
?>
<section>
	<div class="transbox"  style="position:absolute">
		<?php
			$livre = new Webservice($db); 
			$livre->TotalAzur($db);
		
			$livre->ListeLivreAzur($db);
		
			if (isset($_GET['id2'])){
				$livre->DeleteLivreAzur($db);
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

