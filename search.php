<?php
include_once "header.php";
include_once "bdd/webservice.php";
include_once "bdd/connexion.php";
?>

<body>
	<section>
		<div class="transbox" style="color: black">
		<?php
		$livre = new Webservice($db);
		$livre->search($db);
		
		if (isset($_GET['id1'])){
			$livre->DeleteLivre($db);
		} 
		?>					
		</div>		
	</section>		
</body>		

<?php
include_once "footer.php";	
?>
