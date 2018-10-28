<?php
include_once "header_azur.php";
include_once "bdd/webservice_azur.php";
include_once "bdd/connexion.php";
?>
<section>
	<div class="transbox">
		<p style="text-align:left"><?php
				echo "</br>";
				$livre = new Webservice_Azur($db);
				$livre->TotalAzur($db);
				echo "</br>";            
				$livre->TotalAzurStatut($db);
				echo "</br>";
			?>
		</p>
	</div>
</section>

<?php
include_once "footer.php";
?>
