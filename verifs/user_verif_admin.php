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

// Préparation puis execution d'une requête pour vérifier que l'ID de l'user est bien présent dans la BDD et que ça soit un ADMIN
$req_verif_id_admin = $bdd->prepare('SELECT id, type FROM membres WHERE id = "'. $_SESSION['id'] .'" AND type = "Administrateur"');
$req_verif_id_admin->execute();

// Si l'ID existe mais que ce n'est pas un admin, on redirige sur la page index
if(!$result_verif_id_admin = $req_verif_id_admin->fetch()) {
	header('Location: ../index/index.php');
	$req_verif_id_admin->closeCursor();
	die;
}
 ?>