<?php
include_once "header.php";
include_once "bdd/webservice.php";
include_once "bdd/connexion.php";
?>
<section>
	<div class="transbox">
		<p style="text-align:left">
			<?php
			echo "</br>";
			$livre = new Webservice($db);
			$livre->TotalLivreDateLecture($db);
			?>
		</p>
	</div>
</section>

<?php
include_once "footer.php";
?>
