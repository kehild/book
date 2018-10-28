<?php
include_once "header_livre.php";
include_once "bdd/webservice.php";
include_once "bdd/connexion.php";
?>
<section>
	<div class="transbox">
		<p style="text-align:left"><?php
				echo "</br>";
				$livre = new Webservice($db);
				$livre->noteLivre($db);
				echo "</br>";
			?>
		</p>
	</div>
</section>

<?php
include_once "footer.php";
?>
