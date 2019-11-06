<?php 
// Préparation puis execution d'une requête pour vérifier que l'ID de l'user est bien présent dans la BDD
$req_verif_id = $bdd->prepare('SELECT id FROM membres WHERE id = "'. $_SESSION['id'] .'"');
$req_verif_id->execute();

// Si l'ID n'existe pas, on redirige sur la page de connexion
if(!$result_verif_id = $req_verif_id->fetch()) {
	header('Location: ../connexion.php');
	$req_verif_id->closeCursor();
	die;
}
 ?>