
<?php
include_once "header.php";
include_once "bdd/connexion.php";
include_once "bdd/webservice.php";
?>
<body>
	<section>
		<div class="transbox">
			</br>
			<div class="slideshow-container">
					<div class="mySlides fade">
					  <div class="numbertext">1 / 5</div>
					  <img src="image/foret.png" style="width:100%">
					</div>

					<div class="mySlides fade">
					  <div class="numbertext">2 / 5</div>
					  <img src="image/eau.jpg" style="width:100%">
					</div>

					<div class="mySlides fade">
					  <div class="numbertext">3 / 5</div>
					  <img src="image/librairie.jpg" style="width:100%">
					</div>

					<div class="mySlides fade">
					  <div class="numbertext">4 / 5</div>
					  <img src="image/sorciere.jpg" style="width:100%">
					</div>
					
					<div class="mySlides fade">
					  <div class="numbertext">5 / 5</div>
					  <img src="image/secret.jpg" style="width:100%">
				</div>
				<br>
				<div style="text-align:center">
				  <span class="dot"></span> 
				  <span class="dot"></span> 
				  <span class="dot"></span>
				  <span class="dot"></span>
				  <span class="dot"></span>
				</div>
			</div>
				<?php		
				$livre = new Webservice($db);
				$livre->DernierLivreRentree($db);
				
				echo "</br></br>";
				$livre->DernierAzur($db);
				?>

		<script>
			var slideIndex = 0;
			showSlides();

			function showSlides() {
				var i;
				var slides = document.getElementsByClassName("mySlides");
				var dots = document.getElementsByClassName("dot");
				for (i = 0; i < slides.length; i++) {
				   slides[i].style.display = "none";  
				}
				slideIndex++;
				if (slideIndex> slides.length) {slideIndex = 1}    
				for (i = 0; i < dots.length; i++) {
					dots[i].className = dots[i].className.replace(" active", "");
				}
				slides[slideIndex-1].style.display = "block";  
				dots[slideIndex-1].className += " active";
				setTimeout(showSlides, 3000); // Change image every 2 seconds
			}
		</script>		
	</section>		
</body>
<?php
include_once "footer.php";
?>
