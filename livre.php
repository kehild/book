<?php
include_once "header.php";
include_once "bdd/webservice.php";
include_once "bdd/connexion.php";
?>
<section>
	<div class="transbox"  style="position:absolute">
		<p>
		<?php  
		$livre = new Webservice($db);
		$livre->ListeLivre($db);
		
		if (isset($_GET['id1'])){
			$livre->DeleteLivre($db);
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
