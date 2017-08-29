<?php
include_once "header.php";
include_once "bdd/webservice.php";
include_once "bdd/connexion.php";

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
            <div class="site">
                <h2>Lien Site d'information</h2>
                <a href="https://booknode.com" target="_blank">Booknode</a>
                <h2>Lien Site de ddl</h2>
                <a href="https://www.ebook-gratuit.co" target="_blank">EBook Gratuit</a></br></br>
                <a href="http://www.pearltrees.com/kanalista/livres/id11779166" target="_blank">Mes Livres</a></br></br>
                <a href="http://roman-gratuit.net" target="_blank">Roman Gratuit</a>
            </div>
	</div>

</section>

<?php
	
include_once "footer.php";
?>
