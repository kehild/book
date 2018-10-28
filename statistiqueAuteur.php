<?php
include_once "header_livre.php";
include_once "bdd/webservice.php";
include_once "bdd/connexion.php";
?>
<body>
<section>
	<div class="transbox">
		<p style="text-align:left">
			<?php			
			$livre = new Webservice($db);
			$livre->TotalAuteur($db);
			?>
		</p>
	</div>
</section>
</body>
<?php
include_once "footer.php";
?>
