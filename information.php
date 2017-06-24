<?php
include_once "header.php";
include_once "bdd/webservice.php";
include_once "bdd/connexion.php";

 	if (isset($_POST['export'])) {
		
		$livre = new Webservice($db);
		$livre->dumpMySQL($db, 3);
		
	}	

?>
<section>
	<div class="transbox">
		<div id="param">
			<a href="ModifText.php" ><img src="image/param.png"></a>
			<div id="doc">
				<?php
				$myfile = fopen("info.txt", "r") or die("Unable to open file!");
				echo nl2br(utf8_encode(fread($myfile,filesize("info.txt"))));
				fclose($myfile);
				?>
			</div>
		</div>

	</div>
</section>

<?php
	
include_once "footer.php";
?>
