<header>
	<title>MyBook</title>
	<meta charset="UTF-8">
	<link rel="stylesheet" href="style.css">
	<link rel="icon" type="image/png" href="image/livres.jpg"/>
	<table id="test">	
		<tr>
			<td><img src="image/livres.jpg"></td>
			<td><h1 id="titre">Bienvenue Sur MyBook</h1></td>
		</tr>
	</table>	
</header>


<nav>
	<ul id="menu-deroulant">
		<li style="float: left"><a href="index.php">Home</a></li>
		<li style="float: left"><a href="accueil_livre.php">Accueil</a></li>
		<li style="float: left"><a href="saisie.php">Saisir Livre</a></li>
		<li style="float: left"><a href="livre.php">Liste Livre</a></li>
            
		<li style="float: left"><a href="#">Statistique</a>
			<ul>
				<li><a href="statistique.php">Total</a></li>
				<li><a href="statistiqueTheme.php">Total par Thème</a></li>
				<li><a href="statistiqueAuteur.php">Total par Auteur</a></li>
				<li><a href="statistiqueAnnee.php">Année de Lecture</a><li>
				<li><a href="statistiqueEditeur.php">Total par Editeur</a><li>
				<li><a href="noteLivre.php">Classement Livre</a><li>
			</ul>
		</li>
		<li style="float:left"><a href="actualite.php">Actualité</a><li>
		
        <li style="float: left"><a href="#">Recherche par Titre</a>
			<ul>
                            <form style="width:300px; float: left; margin-top: 10px;" action="search.php" method="post">
                                <span style=" color:white; text-align: center;">Recherche par nom :</span> 
                                <input type="text" id="search" name="search"/>
                            </form>
                            
                            <form style="width:300px; float: left; margin-top: 10px;" action="searchAuteur.php" method="post">
                                <span style=" color:white; text-align: center;">Recherche par Auteur :</span> 
                                <input type="text" id="search" name="search"/>
                            </form>
			</ul>
		</li>
		
		
		<li style="float:right"><a href="information.php">Information</a></li>

	</ul>
</nav>


