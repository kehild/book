<?php
class Webservice_Azur{
  private $_db; // Instance de PDO

  public function __construct($db){
    $this->setDb($db);
  }
   
  public function setDb(PDO $db){
    $this->_db = $db;
  }     
		
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
					
			$stmt = $db->prepare("SELECT * FROM azur ORDER BY id DESC LIMIT 4"); 
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
  
  public function TotalAuteur($db){
	
                echo '<div class="pagination">';
                $messagesParPage=80;
                $retour_total=$db->prepare('SELECT COUNT(DISTINCT auteur) AS total FROM azur');
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
                                                
                $retour_messages=$db->prepare("select auteur, COUNT(auteur) from azur group by auteur DESC ORDER BY COUNT(auteur) DESC  LIMIT ".$premiereEntree.", ".$messagesParPage."");
                $retour_messages->execute();
			echo "<table id='dernier' align='center'>";
                                echo "<tr><th>"; echo "Classement"; echo "</th>";
                                echo "<th>"; echo "Total Nombre de Livre lu par Auteur"; echo "</th>";
								echo "<th>"; echo "Auteur"; echo "</th></tr>";

                                
                $nombre_de_lignes = 1;
  
                while($donnees_messages=$retour_messages->fetch()){ 
                             echo "<tr><th>"; echo "$nombre_de_lignes"; echo "</th>";
				echo "<th>"; echo $donnees_messages['COUNT(auteur)']; echo "</th>";
				echo "<th>"; echo utf8_encode($donnees_messages['auteur']); echo "</th></tr>";
		
                               
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


  public function TotalAzurStatut($db){
	
	// Nombre de livre lu par format

		$stmt = $db->prepare("select statut, COUNT(statut) from azur group by statut ORDER BY COUNT(statut) DESC");
		$stmt->execute();
		
			echo "<table id='dernier' align='center'>";
				echo "<tr><th>"; echo "Total Nombre Livre par Statut"; echo "</th>";
				echo "<th>"; echo "Statut"; echo "</th></tr>";
		
		foreach(($stmt->fetchAll()) as $toto){

				echo "<tr><th>"; echo $toto['COUNT(statut)']; echo "</th>";
				echo "<th>"; echo $toto['statut']; echo "</th></tr>";
		
			
		}
			echo "</table>";
	}
  


}
