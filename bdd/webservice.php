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
			
            echo "<tr><th>"; echo "Couverture"; echo "</th>";
			echo "<th>"; echo "Titre"; echo "</th>";
			echo "<th>"; echo "Tome"; echo "</th>";
			echo "<th>"; echo "Auteur"; echo "</th>";
			echo "<th>"; echo "Nb Page"; echo "</th>";
			echo "<th>"; echo "Année"; echo "</th>";
			echo "<th>"; echo "Thème"; echo "</th>";
			echo "<th>"; echo "Editeur"; echo "</th>";
			echo "<th>"; echo "Résumé"; echo "</th>";
			echo "<th>"; echo "Format"; echo "</th></tr>";
			
            echo "<tr><th>"; echo "<img src='image/couverture/".$donnees['image']."'>"; echo "</th>";
			echo "<th>"; echo $donnees['titre']; echo "</th>";
			echo "<th>"; echo $donnees['tome']; echo "</th>";
			echo "<th>"; echo $donnees['auteur']; echo "</th>";
			echo "<th>"; echo $donnees['page']; echo "</th>";
			echo "<th>"; echo $donnees['annee'];  echo "</th>";
			echo "<th>"; echo $donnees['theme'];  echo "</th>";
			echo "<th>"; echo $donnees['editeur'];  echo "</th>";
			echo "<th>"; echo $donnees['resume']; echo "</th>";
			echo "<th>"; echo $donnees['format']; echo "</th></tr>";
						
			echo "</table>";
		}
	}   
   
 
  public function SaisieLivre($db,$titre,$tome,$page,$auteur,$annee,$theme,$format,$date_lecture,$image,$editeur){
		
		try {	
			
            $titre = $_POST['titre'];
            $titre = str_replace("'", "\'", $titre);
			$titre = str_replace("’", " ", $titre);           
                        
			$resume = $_POST['resume'];
			$resume = str_replace("'", "\'", $resume);
			$resume = str_replace("’", " ", $resume);
			
			$sql = "Insert INTO book (titre, auteur, annee, theme, resume, tome, page, format, date_lecture, image,editeur) VALUES ('$titre','$auteur','$annee','$theme',' ".$resume."','$tome','$page','$format','$date_lecture','$image','$editeur')";
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
		
                echo "<tr><th>"; echo "Couverture"; echo "</th>";
		echo "<th>"; echo "Titre"; echo "</th>";
		echo "<th>"; echo "Tome"; echo "</th>";
		echo "<th>"; echo "Auteur"; echo "</th>";
		echo "<th>"; echo "NB Page"; echo "</th>";
		echo "<th>"; echo "Annnée"; echo "</th>";
		echo "<th>"; echo "Thème"; echo "</th>";
		echo "<th>"; echo "Format"; echo "</th>";
		echo "<th>"; echo "Année Lecture"; echo "</th>";
		echo "<th>"; echo "Editeur"; echo "</th>";
		echo "<th>"; echo "Résumé"; echo "</th>";
		echo "<th>"; echo "Modifier"; echo "</th>";
		echo "<th>"; echo "Supprimer"; echo "</th></tr>";

		while($donnees_messages=$retour_messages->fetch()){ 
		
                echo "<tr><th>"; echo stripslashes("<img src='image/couverture/".$donnees_messages['image']."'>"); echo "</th>";
		echo "<th>"; echo stripslashes($donnees_messages['titre']); echo "</th>";
		echo "<th>"; echo stripslashes($donnees_messages['tome']); echo "</th>";
		echo "<th>"; echo stripslashes($donnees_messages['auteur']); echo "</th>";
		echo "<th>"; echo stripslashes($donnees_messages['page']); echo "</th>";
		echo "<th>"; echo stripslashes($donnees_messages['annee']);  echo "</th>";
		echo "<th>"; echo stripslashes($donnees_messages['theme']);  echo "</th>";
		echo "<th>"; echo stripslashes($donnees_messages['format']); echo "</th>";
		echo "<th>"; echo stripslashes($donnees_messages['date_lecture']); echo "</th>";
		echo "<th>"; echo stripslashes($donnees_messages['editeur']); echo "</th>";
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
				echo "<th>"; echo '<a href="DetailTheme.php?theme='.$toto['theme'].'" ><img src="image/modifier.png"></a>'; echo "</th></tr>"; 
			
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
		
			echo "<table id='dernier' align='center'>";				
				echo "<tr><th>"; echo "Moyenne Page"; echo "</th></tr>";
		
		foreach(($stmt->fetchAll()) as $toto){
				
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
				echo "<th>"; echo "Format"; echo "</th>";
				echo "<th>"; echo "Liste"; echo "</th></tr>";
		
		foreach(($stmt->fetchAll()) as $toto){

				echo "<tr><th>"; echo $toto['COUNT(format)']; echo "</th>";
				echo "<th>"; echo utf8_encode($toto['format']); echo "</th>";
				echo "<th>"; echo '<a href="DetailFormat.php?format='.$toto['format'].'" ><img src="image/modifier.png"></a>'; echo "</th></tr>"; 				
			
		}
			echo "</table>";
	}
  
public function TotalAuteur($db){
	
                echo '<div class="pagination">';
                $messagesParPage=80;
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
                                                
                $retour_messages=$db->prepare("select auteur, SUM(tome),round(sum(page)/sum(tome)) from book group by auteur order by SUM(tome) DESC LIMIT ".$premiereEntree.", ".$messagesParPage."");
                $retour_messages->execute();
			echo "<table id='dernier' align='center'>";
                                echo "<tr><th>"; echo "Classement"; echo "</th>";
                                echo "<th>"; echo "Total Nombre de Livre lu par Auteur"; echo "</th>";
								echo "<th>"; echo "Auteur"; echo "</th>";
								echo "<th>"; echo "Moyenne Pages"; echo "</th></tr>";

                                
                $nombre_de_lignes = 1;
  
                while($donnees_messages=$retour_messages->fetch()){ 
                             echo "<tr><th>"; echo "$nombre_de_lignes"; echo "</th>";
				echo "<th>"; echo $donnees_messages['SUM(tome)']; echo "</th>";
				echo "<th>"; echo utf8_encode($donnees_messages['auteur']); echo "</th>";
				echo "<th>"; echo $donnees_messages['round(sum(page)/sum(tome))']; echo "</th></tr>";
		
                               
                                $nombre_de_lignes = $nombre_de_lignes + 1;
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

public function TotalEditeur($db){
	
                echo '<div class="pagination">';
                $messagesParPage=80;
                $retour_total=$db->prepare('SELECT COUNT(DISTINCT editeur) AS total FROM book');
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
                                                
                $retour_messages=$db->prepare("select editeur, SUM(tome),round(sum(page)/sum(tome)) from book group by editeur order by SUM(tome) DESC LIMIT ".$premiereEntree.", ".$messagesParPage."");
                $retour_messages->execute();
			echo "<table id='dernier' align='center'>";
                                echo "<tr><th>"; echo "Classement"; echo "</th>";
                                echo "<th>"; echo "Total Nombre de Livre lu par Editeur"; echo "</th>";
								echo "<th>"; echo "Editeur"; echo "</th></tr>";

                                
                $nombre_de_lignes = 1;
  
                while($donnees_messages=$retour_messages->fetch()){ 
                             echo "<tr><th>"; echo "$nombre_de_lignes"; echo "</th>";
				echo "<th>"; echo $donnees_messages['SUM(tome)']; echo "</th>";
				echo "<th>"; echo utf8_encode($donnees_messages['editeur']); echo "</th></tr>";
		
                               
                                $nombre_de_lignes = $nombre_de_lignes + 1;
                }
                
            
                        echo "</table>";


        echo '<p align="center">Page : '; //Pour l'affichage, on centre la liste des pages

        for($i=1; $i<=$nombreDePages; $i++){ //On fait notre boucle

             //On va faire notre condition
             if($i==$pageActuelle){ //Si il s'agit de la page actuelle...
                   
                 echo ' [ '.$i.' ] '; 
             }	
             else{
                         echo ' <a href="statistiqueEditeur.php?page='.$i.'">'.$i.'</a> ';
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
		
                echo "<tr><th>"; echo "Couverture"; echo "</th>"; 
                echo "<th>"; echo "Titre"; echo "</th>";
		echo "<th>"; echo "Tome"; echo "</th>";
		echo "<th>"; echo "Auteur"; echo "</th>";
		echo "<th>"; echo "NB Page"; echo "</th>";
		echo "<th>"; echo "Annnée"; echo "</th>";
		echo "<th>"; echo "Thème"; echo "</th>";
		echo "<th>"; echo "Format"; echo "</th>";
		echo "<th>"; echo "Résumé"; echo "</th></tr>";

		foreach(($stmt->fetchAll()) as $tata){
		
                echo "<tr><th>"; echo stripslashes("<img src='image/couverture/".$tata['image']."'>"); echo "</th>";
		echo "<th>"; echo stripslashes($tata['titre']); echo "</th>";
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
	
	function ListeFormat($db){
		
		try {
		echo "Résultat Par Genre";
		echo "</br> </br>";
		$stmt = $db->prepare("SELECT * FROM book where format='" .$_GET['format']. "'"); 
		$stmt->execute();

		echo "<table id='dernier' align='center'>";
		
        echo "<tr><th>"; echo "Couverture"; echo "</th>"; 
        echo "<th>"; echo "Titre"; echo "</th>";
		echo "<th>"; echo "Tome"; echo "</th>";
		echo "<th>"; echo "Auteur"; echo "</th>";
		echo "<th>"; echo "NB Page"; echo "</th>";
		echo "<th>"; echo "Annnée"; echo "</th>";
		echo "<th>"; echo "Thème"; echo "</th>";
		echo "<th>"; echo "Format"; echo "</th>";
		echo "<th>"; echo "Résumé"; echo "</th></tr>";

		foreach(($stmt->fetchAll()) as $tata){
		
        echo "<tr><th>"; echo stripslashes("<img src='image/couverture/".$tata['image']."'>"); echo "</th>";
		echo "<th>"; echo stripslashes($tata['titre']); echo "</th>";
		echo "<th>"; echo stripslashes($tata['tome']); echo "</th>";
		echo "<th>"; echo stripslashes($tata['auteur']); echo "</th>";
		echo "<th>"; echo stripslashes($tata['page']); echo "</th>";
		echo "<th>"; echo stripslashes($tata['annee']);  echo "</th>";
		echo "<th>"; echo stripslashes($tata['theme']);  echo "</th>";
		echo "<th>"; echo stripslashes($tata['format']); echo "</th>";
		echo "<th>"; echo stripslashes($tata['resume']); echo "</th></tr>";

		}

		echo "</table>";?>
		<form method="post" action="statistique.php">
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
			
                echo "<tr><th>"; echo "Couverture"; echo "</th>";
		echo "<th>"; echo "Titre"; echo "</th>";
		echo "<th>"; echo "Tome"; echo "</th>";
		echo "<th>"; echo "Auteur"; echo "</th>";
		echo "<th>"; echo "NB Page"; echo "</th>";
		echo "<th>"; echo "Annnée"; echo "</th>";
		echo "<th>"; echo "Thème"; echo "</th>";
		echo "<th>"; echo "Editeur"; echo "</th>";
		echo "<th>"; echo "Résumé"; echo "</th>";
		echo "<th>"; echo "Modifier"; echo "</th>";
		echo "<th>"; echo "Supprimer"; echo "</th></tr>";
							
		while($donnees = $resultat->fetch(PDO::FETCH_ASSOC)) {       
				
                echo "<tr><th>"; echo stripslashes("<img src='image/couverture/".$donnees['image']."'>"); echo "</th>";    
		echo "<th>"; echo $donnees['titre']; echo "</th>";
		echo "<th>"; echo $donnees['tome']; echo "</th>";
		echo "<th>"; echo $donnees['auteur']; echo "</th>";
		echo "<th>"; echo $donnees['page']; echo "</th>";
		echo "<th>"; echo $donnees['annee'];  echo "</th>";
		echo "<th>"; echo $donnees['theme']; echo "</th>";
		echo "<th>"; echo $donnees['editeur']; echo "</th>";
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
		
                echo "<tr><th>"; echo "Couverture"; echo "</th>";
		echo "<th>"; echo "Titre"; echo "</th>";
		echo "<th>"; echo "Tome"; echo "</th>";
		echo "<th>"; echo "Auteur"; echo "</th>";
		echo "<th>"; echo "NB Page"; echo "</th>";
		echo "<th>"; echo "Annnée"; echo "</th>";
		echo "<th>"; echo "Thème"; echo "</th>";
		echo "<th>"; echo "Editeur"; echo "</th>";
		echo "<th>"; echo "Résumé"; echo "</th>";
		echo "<th>"; echo "Modifier"; echo "</th>";
		echo "<th>"; echo "Supprimer"; echo "</th></tr>";
					
		while($donnees = $resultat->fetch(PDO::FETCH_ASSOC)) {     
                    
		echo "<tr><th>"; echo stripslashes("<img src='image/couverture/".$donnees['image']."'>"); echo "</th>";							
		echo "<th>"; echo $donnees['titre']; echo "</th>";
		echo "<th>"; echo $donnees['tome']; echo "</th>";
		echo "<th>"; echo $donnees['auteur']; echo "</th>";
		echo "<th>"; echo $donnees['page']; echo "</th>";
		echo "<th>"; echo $donnees['annee'];  echo "</th>";
		echo "<th>"; echo $donnees['theme']; echo "</th>";
		echo "<th>"; echo $donnees['editeur']; echo "</th>";
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
		<input type="text" id="titre" name="titre" value="<?php echo $toto['titre']; ?>">
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
			<option value="numerique amazon">Numérique Amazon</option>				
			<option value="papier/numerique">Papier / Numérique</option>		
		</select>
		</br>
		<label for="date_lecture">Date lecture</label>
		</br>
		<input type="text" id="date_lecture" name="date_lecture" value="<?php echo $toto['date_lecture']; ?>">
		</br>
		<label for="editeur">Editeur</label>
		</br>
		<input type="text" id="editeur" name="editeur" value="<?php echo $toto['editeur']; ?>">&nbsp;
		</br>
		<label for="resume">Résumé</label>
		</br>
		<textarea name="resume" rows="6" cols="60"><?php echo $toto['resume']; ?></textarea>
                </br>
                <label for="image">Image</label>
		</br>
		<input type="text" id="image" name="image" value="<?php echo $toto['image']; ?>">
		</br>
		<input type="submit" id="Modifier" name="Modifier" value="Modifier">
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		<input type="submit" id="Annuler" name="Annuler" value="Annuler">
		</br>
		<input type="submit" id="cadre" name="cadre" value="Redimensionner l'image">
		</br>
	  </form>
	</div> <?php				
	}
	
}
 
public function UpdateLivre($db){
	
		try {
				
				$resume = $_POST['resume'];
                                $resume = str_replace("'", "\'", $resume);
                                $resume = str_replace("’", " ", $resume);
                                                  
				
				$sql = "UPDATE book SET titre='".$_POST['titre']."',auteur='".$_POST['auteurss']."',annee='".$_POST['annee']."',theme='".$_POST['themess']."', resume='".$resume."',tome='".$_POST['tome']."',page='".$_POST['page']."',format='".$_POST['format']."',date_lecture='".$_POST['date_lecture']."',image='" .$_POST['image']. "',editeur='" .$_POST['editeur']. "' WHERE id='".$_GET['id']."'";
			
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

        
          public function CadreImage(){
		
		//$test = $_POST['file'];
		//var_dump($test);
		
		$source = imagecreatefromjpeg('image/couverture/'.$_POST['file'].''); // La photo est la source
		$destination = imagecreatetruecolor(111, 177); // On crée la miniature vide
		// Les fonctions imagesx et imagesy renvoient la largeur et la hauteur d une image
		$largeur_source = imagesx($source);
		$hauteur_source = imagesy($source);
		$largeur_destination = imagesx($destination);
		$hauteur_destination = imagesy($destination);
		// On crée la nouvelle image
		imagecopyresampled($destination, $source, 0, 0, 0, 0, $largeur_destination, $hauteur_destination, $largeur_source, $hauteur_source);
		// On enregistre l'image avec la nouvelle taille
		//imagejpeg($destination, $test);
		imagejpeg($destination, 'image/couverture/'.$_POST['file'].'');
		
	}
	
		public function ModifCadre(){
	 
		//$test = '/var/www/html/book/image/couverture/'.$_POST['image'].'';
        //chmod("$test", 0777);
                                
        /* modification de la taille de la couverture */
                                
        $source = imagecreatefromjpeg('image/couverture/'.$_POST['image'].''); // La photo est la source
        $destination = imagecreatetruecolor(111, 177); // On crée la miniature vide
        // Les fonctions imagesx et imagesy renvoient la largeur et la hauteur d une image
        $largeur_source = imagesx($source);
        $hauteur_source = imagesy($source);
        $largeur_destination = imagesx($destination);
        $hauteur_destination = imagesy($destination);
        // On crée la nouvelle image
        imagecopyresampled($destination, $source, 0, 0, 0, 0, $largeur_destination, $hauteur_destination, $largeur_source, $hauteur_source);
        // On enregistre l'image avec la nouvelle taille
        //imagejpeg($destination, $test);
        imagejpeg($destination, 'image/couverture/'.$_POST['image'].'');   
	
	}	
        /*   Requete sur Collection Azur  */
        
        public function ListeLivreAzur($db){ 
            
            echo '<div class="pagination">';
           $messagesParPage=12;
           $retour_total=$db->prepare('SELECT COUNT(*) AS total FROM azur');
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

            $retour_messages=$db->prepare("SELECT * FROM azur ORDER BY titre ASC LIMIT ".$premiereEntree.", ".$messagesParPage."");
            $retour_messages->execute();

                       echo "<table id='dernier' align='center'>";

                       echo "<tr><th>"; echo "Titre"; echo "</th>";
                       echo "<th>"; echo "Auteur"; echo "</th>";
                       echo "<th>"; echo "Nb Page"; echo "</th>";
                       echo "<th>"; echo "Année"; echo "</th>";
					   echo "<th>"; echo "Statut"; echo "</th>";
                       echo "<th>"; echo "Résumé"; echo "</th>";
                       echo "<th>"; echo "Modifier"; echo "</th>";
                       echo "<th>"; echo "Supprimer"; echo "</th></tr>";

                       while($donnees_messages=$retour_messages->fetch()){ 

                       echo "<tr><th>"; echo stripslashes($donnees_messages['titre']); echo "</th>";
                       echo "<th>"; echo stripslashes($donnees_messages['auteur']); echo "</th>";
                       echo "<th>"; echo stripslashes($donnees_messages['page']); echo "</th>";
                       echo "<th>"; echo stripslashes($donnees_messages['annee']); echo "</th>";
					   echo "<th>"; echo stripslashes($donnees_messages['statut']); echo "</th>";
                       echo "<th>"; echo stripslashes($donnees_messages['resume']);  echo "</th>";
                       echo "<th>"; echo stripslashes('<a href="ModifLivreAzur.php?id='.$donnees_messages['id'].'"><img src="image/modifier.png"></a>'); echo "</th>";
                       echo "<th>"; echo stripslashes('<a href="?id2='.$donnees_messages['id'].'"><img src="image/delete.png"></a>'); echo "</th></tr>";

               }
                       echo "</table>";

       echo '<p align="center">Page : '; //Pour l'affichage, on centre la liste des pages

       for($i=1; $i<=$nombreDePages; $i++){ //On fait notre boucle

            //On va faire notre condition
            if($i==$pageActuelle){ //Si il s'agit de la page actuelle...

                echo ' [ '.$i.' ] '; 
            }	
            else{
                        echo ' <a href="azur.php?page='.$i.'">'.$i.'</a> ';
            }
       }
       echo '</p>';
       echo '</div>';	
    }
        
    public function DeleteLivreAzur($db){

	try {
	
		$stm = $db->prepare("delete from azur where id='".$_GET['id2']."'"); 
		$stm->execute();
				
	}catch(Exception $e){
				
		echo("<h1>Erreur : Base de données </h1>");
		die('Erreur : ' .$e->getMessage());
		
	}
	echo '<meta http-equiv="refresh" content="0;URL=azur.php">';
}

 public function SaisieLivreAzur($db,$titre,$auteur,$page,$annee,$statut,$resume){
		
		try {	
			
                        $titre = $_POST['titre'];
                        $titre = str_replace("'", "\'", $titre);
			$titre = str_replace("’", " ", $titre);           
                        
			$resume = $_POST['resume'];
			$resume = str_replace("'", "\'", $resume);
			$resume = str_replace("’", " ", $resume);
			
			$sql = "Insert INTO azur (titre, auteur, page, annee, resume,statut) VALUES ('$titre','$auteur','$page','$annee',' ".$resume." ','$statut')";
			$db->exec($sql);
			echo "Insertion réussi";

			}
			catch(Exception $e){
				
				echo("<h1>Erreur : Base de données </h1>");
				die('Erreur : ' .$e->getMessage());
			
			}
  } 

  public function modification_azur($db){
	 				
		$stmt = $db->prepare("SELECT * FROM azur where id=' " .$_GET['id']. " '"); 
		$stmt->execute();
					
		foreach(($stmt->fetchAll()) as $toto){
		?>
		<div>
		  <form method="post" action="">
		</br>
		<label for="titre">Titre</label>
		</br>
		<input type="text" id="titre" name="titre" value="<?php echo $toto['titre']; ?>">
		</br>
		<label for="auteur">Auteur</label>
		</br>
		<input type="text" id="auteur" name="auteur" value="<?php echo $toto['auteur']; ?>">
		</br>
		<label for="page">Nombre Page</label>
		</br>
		<input type="text" id="page" name="page" value="<?php echo $toto['page']; ?>">
		</br>
		<label for="annee">Année</label>
		</br>
		<input type="text" id="annee" name="annee" value="<?php echo $toto['annee']; ?>">
		</br>
		<label for="statut">Statut</label>
		</br>
		<select name="statut" id="statut">
			<option value="<?php echo $toto['statut']; ?>"><?php echo $toto['statut']; ?></option> <!-- statut en base -->
			<option value="acheter google">Acheter Google</option>
			<option value="acheter amazon">Acheter Amazon</option>
			<option value="télécharger">Télécharger</option>			
		</select>
		</br>
		<label for="resume">Résumé</label>
		</br>
		<textarea name="resume" rows="6" cols="60"><?php echo $toto['resume']; ?></textarea>
		</br>
		<input type="submit" id="Modifier" name="Modifier" value="Modifier">
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		<input type="submit" id="Annuler" name="Annuler" value="Annuler">
		</br>
	  </form>
	</div> <?php				
	}					
}
        
public function UpdateLivreAzur($db){
	
		try {
				
			$resume = $_POST['resume'];
                        $resume = str_replace("'", "\'", $resume);
                        $resume = str_replace("’", " ", $resume);                              
                                             
				
			$sql = "UPDATE azur SET titre='".$_POST['titre']."',auteur='".$_POST['auteur']."',page='".$_POST['page']."',annee='".$_POST['annee']."', resume='".$resume. "',statut='".$_POST['statut']."' WHERE id='".$_GET['id']."'";
			
			$db->exec($sql);
				
			echo "Modification réussi";
			echo '<meta http-equiv="refresh" content="0;URL=ModifLivreAzur.php?id='.$_GET['id'].'">';
			}
			catch(Exception $e){
				
				echo("<h1>Erreur : Base de données </h1>");
				die('Erreur : ' .$e->getMessage());
			
			}
}

 public	function TotalAzur($db){

	$stmt = $db->prepare("select COUNT(id) from azur");
	$stmt->execute();
	
		echo "<table id='dernier' align='center'>";
			echo "<tr><th>"; echo "Total Livre Lu"; echo "</th></tr>";	
	
		foreach(($stmt->fetchAll()) as $toto){

			echo "</tr><th>"; echo $toto['COUNT(id)']; echo "</th></tr>";
			echo "</table>";
		}
	
	}

public function DernierAzur($db){
						
			// Afficher dernier livre rentrer
					
			$stmt = $db->prepare("SELECT * FROM azur ORDER BY id DESC LIMIT 2"); 
			$stmt->execute();
					
			echo "<table id='dernier' align='center'>";
			
            echo "<tr><th>"; echo "Titre"; echo "</th>";
			echo "<th>"; echo "Auteur"; echo "</th>";
			echo "<th>"; echo "Page"; echo "</th>";
			echo "<th>"; echo "Année"; echo "</th>";
			echo "<th>"; echo "Statut"; echo "</th>";
			echo "<th>"; echo "Résumé"; echo "</th></tr>";	
					
			foreach(($stmt->fetchAll()) as $donnees){

			echo "<tr><th>"; echo $donnees['titre']; echo "</th>";
			echo "<th>"; echo $donnees['auteur']; echo "</th>";
			echo "<th>"; echo $donnees['page']; echo "</th>";
			echo "<th>"; echo $donnees['annee'];  echo "</th>";
			echo "<th>"; echo $donnees['statut'];  echo "</th>";
			echo "<th>"; echo $donnees['resume']; echo "</th></tr>";
						

		}
		echo "</table>";
		echo "</br>";
	}  	
  


        
        
  
  public function setDb(PDO $db){
    $this->_db = $db;
  }
}
