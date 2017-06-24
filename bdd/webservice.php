<?php
class Webservice{
  private $_db; // Instance de PDO

  public function __construct($db){
    $this->setDb($db);
  }
   
public function DernierLivreRentree($db){
						
			// Afficher dernier livre rentrer
					
			$stmt = $db->prepare("SELECT * FROM book ORDER BY id DESC LIMIT 1"); 
			$stmt->execute();
					
			foreach(($stmt->fetchAll()) as $donnees){
						
			echo "<table id='dernier' align='center'>";
						
			echo "<tr><th>"; echo "Titre"; echo "</th>";
			echo "<th>"; echo "Tome"; echo "</th>";
			echo "<th>"; echo "Auteur"; echo "</th>";
			echo "<th>"; echo "Nb Page"; echo "</th>";
			echo "<th>"; echo "Année"; echo "</th>";
			echo "<th>"; echo "Thème"; echo "</th>";
			echo "<th>"; echo "Résumé"; echo "</th>";
			echo "<th>"; echo "Format"; echo "</th></tr>";
						
			echo "<tr><th>"; echo $donnees['titre']; echo "</th>";
			echo "<th>"; echo $donnees['tome']; echo "</th>";
			echo "<th>"; echo $donnees['auteur']; echo "</th>";
			echo "<th>"; echo $donnees['page']; echo "</th>";
			echo "<th>"; echo $donnees['annee'];  echo "</th>";
			echo "<th>"; echo $donnees['theme'];  echo "</th>";
			echo "<th>"; echo $donnees['resume']; echo "</th>";
			echo "<th>"; echo $donnees['format']; echo "</th></tr>";
						
			echo "</table>";
		}
	}   
   
 
  public function SaisieLivre($db,$titre,$tome,$page,$auteur,$annee,$theme,$format,$date_lecture){
		
		try {	
				
			$resume = $_POST['resume'];
			$resume = str_replace("'", " ", $resume);
			$resume = str_replace("’", " ", $resume);
			
			$sql = "Insert INTO book (titre, auteur, annee, theme, resume, tome, page, format, date_lecture) VALUES ('$titre','$auteur','$annee','$theme',' ".$resume."','$tome','$page','$format','$date_lecture')";
			$db->exec($sql);
			echo "Insertion réussi";

			}
			catch(Exception $e){
				
				echo("<h1>Erreur : Base de données </h1>");
				die('Erreur : ' .$e->getMessage());
			
			}
  } 

public function ListeLivre($db){ // Pagination
 echo '<div class="pagination">';
$messagesParPage=10;
$retour_total=$db->prepare('SELECT COUNT(*) AS total FROM book');
$retour_total->execute();
$donnees_total=$retour_total->fetch(); 
$total=$donnees_total['total'];
$nombreDePages=ceil($total/$messagesParPage);

if(isset($_GET['page'])){ 

     $pageActuelle=intval($_GET['page']);
 
     if($pageActuelle>$nombreDePages){
	
         $pageActuelle=$nombreDePages;
     }
} else{
     $pageActuelle=1;
}
 
$premiereEntree=($pageActuelle-1)*$messagesParPage; 
 
$retour_messages=$db->prepare("SELECT * FROM book ORDER BY titre ASC LIMIT ".$premiereEntree.", ".$messagesParPage."");
$retour_messages->execute();

		echo "<table id='dernier' align='center'>";
		
		echo "<tr><th>"; echo "Titre"; echo "</th>";
		echo "<th>"; echo "Tome"; echo "</th>";
		echo "<th>"; echo "Auteur"; echo "</th>";
		echo "<th>"; echo "NB Page"; echo "</th>";
		echo "<th>"; echo "Annnée"; echo "</th>";
		echo "<th>"; echo "Thème"; echo "</th>";
		echo "<th>"; echo "Format"; echo "</th>";
		echo "<th>"; echo "Année Lecture"; echo "</th>";
		echo "<th>"; echo "Résumé"; echo "</th>";
		echo "<th>"; echo "Modifier"; echo "</th>";
		echo "<th>"; echo "Supprimer"; echo "</th></tr>";

		while($donnees_messages=$retour_messages->fetch()){ 
		
		echo "<tr><th>"; echo stripslashes($donnees_messages['titre']); echo "</th>";
		echo "<th>"; echo stripslashes($donnees_messages['tome']); echo "</th>";
		echo "<th>"; echo stripslashes($donnees_messages['auteur']); echo "</th>";
		echo "<th>"; echo stripslashes($donnees_messages['page']); echo "</th>";
		echo "<th>"; echo stripslashes($donnees_messages['annee']);  echo "</th>";
		echo "<th>"; echo stripslashes($donnees_messages['theme']);  echo "</th>";
		echo "<th>"; echo stripslashes($donnees_messages['format']); echo "</th>";
		echo "<th>"; echo stripslashes($donnees_messages['date_lecture']); echo "</th>";
		echo "<th>"; echo (stripslashes($donnees_messages['resume'])); echo "</th>";
		echo "<th>"; echo stripslashes('<a href="ModifLivre.php?id='.$donnees_messages['id'].'"><img src="image/modifier.png"></a>'); echo "</th>";
		echo "<th>"; echo stripslashes('<a href="?id1='.$donnees_messages['id'].'"><img src="image/delete.png"></a>'); echo "</th></tr>";
		
	}
		echo "</table>";
		
echo '<p align="center">Page : '; //Pour l'affichage, on centre la liste des pages

for($i=1; $i<=$nombreDePages; $i++){ //On fait notre boucle

     //On va faire notre condition
     if($i==$pageActuelle){ //Si il s'agit de la page actuelle...
     
         echo ' [ '.$i.' ] '; 
     }	
     else{
		 echo ' <a href="livre.php?page='.$i.'">'.$i.'</a> ';
     }
}
echo '</p>';
echo '</div>';	
}
  
public function TotalLivreTheme($db){
	
	// Nombre de livre lu par thème

		$stmt = $db->prepare("select theme, COUNT(theme) from book group by theme ORDER BY COUNT(theme) DESC");
		$stmt->execute();
		
			echo "<table id='dernier' align='center'>";
				echo "<tr><th>"; echo "Total Nombre Livre par Thème"; echo "</th>";
				echo "<th>"; echo "Thème"; echo "</th>";
				echo "<th>"; echo "Liste"; echo "</th></tr>";
		
		foreach(($stmt->fetchAll()) as $toto){

				echo "<tr><th>"; echo $toto['COUNT(theme)']; echo "</th>";
				echo "<th>"; echo utf8_encode($toto['theme']); echo "</th>"; 			
				echo "<th>"; echo '<a href="?theme='.$toto['theme'].'" ><img src="image/modifier.png"></a>'; echo "</th> </tr>"; 
			
		}
			echo "</table>";
	}  
  
 public	function TotalTome($db){
	
	// Nombre de livre lu par thème

	$stmt = $db->prepare("select SUM(tome) from book");
	$stmt->execute();
		
			echo "<table id='dernier' align='center'>";
				echo "<tr><th>"; echo "Total Livre Lu"; echo "</th></tr>";
		
		foreach(($stmt->fetchAll()) as $toto){

				echo "<tr><th>"; echo $toto['SUM(tome)']; echo "</th></tr>";
		}
		echo "</table>";
	} 
  
  
 public	function MoyenneLivre($db){
		
	// Nombre de livre lu, sans trie

		$stmt = $db->prepare("select SUM(page),COUNT(tome) from book");
		$stmt->execute();
		
			foreach(($stmt->fetchAll()) as $toto){
				echo "<table id='dernier' align='center'>";
				
				echo "<tr><th>"; echo "Moyenne Page"; echo "</th></tr>";				
				echo "<tr><th>"; echo (round($toto['SUM(page)'] / $toto['COUNT(tome)'])); echo "</th></tr>";
				
				echo "</table>";
		}
	}
  
  public function TotalLivreFormat($db){
	
	// Nombre de livre lu par format

		$stmt = $db->prepare("select format, COUNT(format) from book group by format ORDER BY COUNT(format) DESC");
		$stmt->execute();
		
			echo "<table id='dernier' align='center'>";
				echo "<tr><th>"; echo "Total Nombre Livre par Format"; echo "</th>";
				echo "<th>"; echo "Format"; echo "</th></tr>";
		
		foreach(($stmt->fetchAll()) as $toto){

				echo "<tr><th>"; echo $toto['COUNT(format)']; echo "</th>";
				echo "<th>"; echo utf8_encode($toto['format']); echo "</th></tr>"; 			
			
		}
			echo "</table>";
	}
  
public function TotalAuteur($db){
	
		//$stmt = $db->prepare("select auteur, SUM(tome) from book group by auteur order by SUM(tome) DESC");
		//$stmt->execute();
                echo '<div class="pagination">';
                $messagesParPage=15;
                $retour_total=$db->prepare('SELECT COUNT(DISTINCT auteur) AS total FROM book');
                $retour_total->execute();
                $donnees_total=$retour_total->fetch(); 
                $total=$donnees_total['total'];
                $nombreDePages=ceil($total/$messagesParPage);

                if(isset($_GET['page'])){ 

                     $pageActuelle=intval($_GET['page']);

                     if($pageActuelle>$nombreDePages){

                         $pageActuelle=$nombreDePages;
                     }
                } else{
                     $pageActuelle=1;
                }

                $premiereEntree=($pageActuelle-1)*$messagesParPage; 
                                                
                $retour_messages=$db->prepare("select auteur, SUM(tome) from book group by auteur order by SUM(tome) DESC LIMIT ".$premiereEntree.", ".$messagesParPage."");
                $retour_messages->execute();
			echo "<table id='dernier' align='center'>";
                                echo "<tr><th>"; echo "Total Nombre de Livre lu par Auteur"; echo "</th>";
				echo "<th>"; echo "Auteur"; echo "</th></tr>";
		
		while($donnees_messages=$retour_messages->fetch()){ 
				echo "<tr><th>"; echo $donnees_messages['SUM(tome)']; echo "</th>";
				echo "<th>"; echo utf8_encode($donnees_messages['auteur']); echo "</th></tr>";
		
                                $num=$num + 1;
                }
		echo "</table>";


        echo '<p align="center">Page : '; //Pour l'affichage, on centre la liste des pages

        for($i=1; $i<=$nombreDePages; $i++){ //On fait notre boucle

             //On va faire notre condition
             if($i==$pageActuelle){ //Si il s'agit de la page actuelle...

                 echo ' [ '.$i.' ] '; 
             }	
             else{
                         echo ' <a href="statistiqueAuteur.php?page='.$i.'">'.$i.'</a> ';
             }
        }
        echo '</p>';
    echo '</div>';	
}   
  
 public function TotalLivreDateLecture($db){
	
		$stmt = $db->prepare("SELECT date_lecture, COUNT(date_lecture) FROM book group by date_lecture ORDER BY COUNT(date_lecture) DESC");
		$stmt->execute();
		//  page, SUM(page) est la cause
			echo "<table id='dernier' align='center'>";
				echo "<tr><th>"; echo "Total Nombre Livre par Thème"; echo "</th>";
				echo "<th>"; echo "Année de Lecture"; echo "</th></tr>";
		
		foreach(($stmt->fetchAll()) as $toto){

				echo "<tr><th>"; echo $toto['COUNT(date_lecture)']; echo "</th>";
				echo "<th>"; echo $toto['date_lecture']; echo "</th></tr>"; 			

				}
			echo "</table>";
	} 
  /*
 public	function ThemeConnu($db){
		
		$stmt = $db->prepare("SELECT theme FROM book GROUP BY theme"); 
		$stmt->execute();

		echo "<select name='themes' id='themes'>";

		while($donnees = $stmt->fetch()){
			echo "<option value='".$donnees['theme']."'>".$donnees['theme']."</option>";
			echo $donnees['theme'];
		}
		echo "</select>";
		
	} 
  */
/*	
public	function AuteurConnu($db){
		
		$stmt = $db->prepare("SELECT auteur FROM book GROUP BY auteur"); 
		$stmt->execute();

		echo "<select name='auteurs' id='auteurs'>";

		while($donnees = $stmt->fetch()){
			echo "<option value='".$donnees['auteur']."'>".$donnees['auteur']."</option>";
			echo $donnees['auteur'];
		}
		echo "</select>";
		
	}
*/	  
  	function ListeTheme($db){
		
		try {
		echo "Résultat Par Genre";
		echo "</br> </br>";
		$stmt = $db->prepare("SELECT * FROM book where theme='" .$_GET['theme']. "'"); 
		$stmt->execute();

		echo "<table id='dernier' align='center'>";
		echo "<tr><th>"; echo "Titre"; echo "</th>";
		echo "<th>"; echo "Tome"; echo "</th>";
		echo "<th>"; echo "Auteur"; echo "</th>";
		echo "<th>"; echo "NB Page"; echo "</th>";
		echo "<th>"; echo "Annnée"; echo "</th>";
		echo "<th>"; echo "Thème"; echo "</th>";
		echo "<th>"; echo "Format"; echo "</th>";
		echo "<th>"; echo "Résumé"; echo "</th></tr>";

		foreach(($stmt->fetchAll()) as $tata){
			
		echo "<tr><th>"; echo stripslashes($tata['titre']); echo "</th>";
		echo "<th>"; echo stripslashes($tata['tome']); echo "</th>";
		echo "<th>"; echo stripslashes($tata['auteur']); echo "</th>";
		echo "<th>"; echo stripslashes($tata['page']); echo "</th>";
		echo "<th>"; echo stripslashes($tata['annee']);  echo "</th>";
		echo "<th>"; echo stripslashes($tata['theme']);  echo "</th>";
		echo "<th>"; echo stripslashes($tata['format']); echo "</th>";
		echo "<th>"; echo stripslashes($tata['resume']); echo "</th></tr>";

		}

		echo "</table>";?>
		<form method="post" action="statistiqueTheme.php">
			<input type="submit" name="Retour" value="Retour">
		</form><?php
		}catch(Exception $e){			
				echo("<h1>Erreur : Base de données </h1>");
				die('Erreur : ' .$e->getMessage());
		}
	}
  
  
 public function search($db){

		if(isset($_POST['search'])) {
			$chainesearch = addslashes($_POST['search']);  
		try{
		
			$db->exec("SET CHARACTER SET utf8");
	
		}
		catch(PDOException $e){
			echo 'Erreur : '.$e->getMessage();
			echo 'N° : '.$e->getCode();
		}      
		
		$requete = "SELECT * from book WHERE titre LIKE '%". $chainesearch ."%'"; 					
		$resultat = $db->query($requete) or die(print_r($db->errorInfo()));
		$nb = 0;
							
		echo "<table id='dernier' align='center'>";
							
		echo "<tr><th>"; echo "Titre"; echo "</th>";
		echo "<th>"; echo "Tome"; echo "</th>";
		echo "<th>"; echo "Auteur"; echo "</th>";
		echo "<th>"; echo "NB Page"; echo "</th>";
		echo "<th>"; echo "Annnée"; echo "</th>";
		echo "<th>"; echo "Thème"; echo "</th>";
		echo "<th>"; echo "Résumé"; echo "</th>";
		echo "<th>"; echo "Modifier"; echo "</th>";
		echo "<th>"; echo "Supprimer"; echo "</th></tr>";
							
		while($donnees = $resultat->fetch(PDO::FETCH_ASSOC)) {       
																	
		echo "<tr><th>"; echo $donnees['titre']; echo "</th>";
		echo "<th>"; echo $donnees['tome']; echo "</th>";
		echo "<th>"; echo $donnees['auteur']; echo "</th>";
		echo "<th>"; echo $donnees['page']; echo "</th>";
		echo "<th>"; echo $donnees['annee'];  echo "</th>";
		echo "<th>"; echo $donnees['theme']; echo "</th>";
		echo "<th>"; echo $donnees['resume']; echo "</th>";
		echo "<th>"; echo '<a href="ModifLivre.php?id='.$donnees['id'].'"><img src="image/modifier.png"></a>'; echo "</th>";
		echo "<th>"; echo '<a href="?id1='.$donnees['id'].'"><img src="image/delete.png"></a>'; echo "</th></tr>"; echo "<br>";  
								
		$nb = $nb + 1;
		}
		echo "</table>";
		echo "</br>";
		echo "Il y a : ".$nb . " résultats";	
				

	} 
}
  
public function searchAuteur($db){

		if(isset($_POST['search'])) {

		$chainesearch = addslashes($_POST['search']);  

		try{
		
		$db->exec("SET CHARACTER SET utf8");
		$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
		}
		catch(PDOException $e){
		echo 'Erreur : '.$e->getMessage();
		echo 'N° : '.$e->getCode();
		}      

		$requete = "SELECT * from book WHERE auteur LIKE '%". $chainesearch ."%'"; 				
		$resultat = $db->query($requete) or die(print_r($db->errorInfo()));
		$nb = 0;
								
		echo "<table id='dernier' align='center'>";
						
		echo "<tr><th>"; echo "Titre"; echo "</th>";
		echo "<th>"; echo "Tome"; echo "</th>";
		echo "<th>"; echo "Auteur"; echo "</th>";
		echo "<th>"; echo "NB Page"; echo "</th>";
		echo "<th>"; echo "Annnée"; echo "</th>";
		echo "<th>"; echo "Thème"; echo "</th>";
		echo "<th>"; echo "Résumé"; echo "</th>";
		echo "<th>"; echo "Modifier"; echo "</th>";
		echo "<th>"; echo "Supprimer"; echo "</th></tr>";
					
		while($donnees = $resultat->fetch(PDO::FETCH_ASSOC)) {       
									
		echo "<tr><th>"; echo $donnees['titre']; echo "</th>";
		echo "<th>"; echo $donnees['tome']; echo "</th>";
		echo "<th>"; echo $donnees['auteur']; echo "</th>";
		echo "<th>"; echo $donnees['page']; echo "</th>";
		echo "<th>"; echo $donnees['annee'];  echo "</th>";
		echo "<th>"; echo $donnees['theme']; echo "</th>";
		echo "<th>"; echo $donnees['resume']; echo "</th>";
		echo "<th>"; echo '<a href="ModifLivre.php?id='.$donnees['id'].'"><img src="image/modifier.png"></a>'; echo "</th>";
		echo "<th>"; echo '<a href="?id1='.$donnees['id'].'"><img src="image/delete.png"></a>'; echo "</th></tr>"; echo "<br>";  
								
		$nb = $nb + 1;
		}
		echo "</table>";
		echo "</br>";
		echo "Il y a : ".$nb . " résultats";	
						
}
}
  
public function DeleteLivre($db){

	try {
	
		$stm = $db->prepare("delete from book where id='".$_GET['id1']."'"); 
		$stm->execute();
				
	}catch(Exception $e){
				
		echo("<h1>Erreur : Base de données </h1>");
		die('Erreur : ' .$e->getMessage());
		
	}
	echo '<meta http-equiv="refresh" content="0;URL=livre.php">';
}


  
public function modification($db){
	 				
		$stmt = $db->prepare("SELECT * FROM book where id=' " .$_GET['id']. " '"); 
		$stmt->execute();
					
		foreach(($stmt->fetchAll()) as $toto){
		?>
		<div>
		  <form method="post" action="">
		</br>
		<label for="titre">Titre</label>
		</br>
		<input type="text" id="titre" name="titre" value="<?php echo utf8_encode($toto['titre']); ?>">
		</br>
		<label for="tome">Nombre Tome</label>
		</br>
		<input type="text" id="tome" name="tome" value="<?php echo $toto['tome']; ?>">
		</br>
		<label for="page">Nombre Page</label>
		</br>
		<input type="text" id="page" name="page" value="<?php echo $toto['page']; ?>">
		</br>
		<label for="auteur">Auteur</label>
		</br>
		<input type="text" id="auteurss" name="auteurss" value="<?php echo $toto['auteur']; ?>">
		</br>
		<label for="annee">Année</label>
		</br>
		<input type="text" id="annee" name="annee" value="<?php echo $toto['annee']; ?>">
		</br>
		<label for="theme">Thème</label>
		</br>
		<input type="text" id="themess" name="themess" value="<?php echo $toto['theme']; ?>">
		</br>
		<label for="format">Format</label>
		</br>
		<select name="format" id="format">
			<option value="<?php echo $toto['format']; ?>"><?php echo $toto['format']; ?></option> <!-- format en base -->
			<option value="papier">Papier</option>
			<option value="numerique">Numérique</option> 
			<option value="papier/numerique">Papier / Numérique</option>		
		</select>
		</br>
		<label for="date_lecture">Date lecture</label>
		</br>
		<input type="text" id="date_lecture" name="date_lecture" value="<?php echo $toto['date_lecture']; ?>">
		</br>
		<label for="resume">Résumé</label>
		</br>
		<textarea name="resume" rows="6" cols="60"><?php echo $toto['resume']; ?></textarea>
						
		<input type="submit" id="Modifier" name="Modifier" value="Modifier">
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		<input type="submit" id="Annuler" name="Annuler" value="Annuler">
		</br>
	  </form>
	</div> <?php				
	}					
}
 
public function UpdateLivre($db){
	
		try {
				
				$resume = $_POST['resume'];
				$resume = str_replace("'", " ", $resume);
				$resume = str_replace("’", " ", $resume);
				
				$sql = "UPDATE book SET titre='".$_POST['titre']."',auteur='".$_POST['auteurss']."',annee='".$_POST['annee']."',theme='".$_POST['themess']."', resume='".$resume."',tome='".$_POST['tome']."',page='".$_POST['page']."',format='".$_POST['format']."',date_lecture='".$_POST['date_lecture']."' WHERE id='".$_GET['id']."'";
			
				$db->exec($sql);
				
				echo "Modification réussi";
				echo '<meta http-equiv="refresh" content="0;URL=ModifLivre.php?id='.$_GET['id'].'">';
			}
			catch(Exception $e){
				
				echo("<h1>Erreur : Base de données </h1>");
				die('Erreur : ' .$e->getMessage());
			
			}
}

 public function NombreAuteur($db){
	
		$stmt = $db->prepare("SELECT COUNT(DISTINCT auteur) FROM book");
		$stmt->execute();
		//  page, SUM(page) est la cause
			echo "<table id='dernier' align='center'>";
				echo "<tr><th>"; echo "Total Nombre Auteur"; echo "</th></tr>";
		
		foreach(($stmt->fetchAll()) as $toto){

				echo "<tr><th>"; echo $toto['COUNT(DISTINCT auteur)']; echo "</th></tr>";			

				}
			echo "</table>";
	} 

  
  public function setDb(PDO $db){
    $this->_db = $db;
  }
}
