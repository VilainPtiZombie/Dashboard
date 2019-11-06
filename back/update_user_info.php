<?php
include('bdd.php');

// Sécurisation du nom du clientID à update puis création d'une variable le contenant
$_POST['clientID_to_update_user_info'] = htmlspecialchars($_POST['clientID_to_update_user_info']);
$clientID_to_update_user_info = $_POST['clientID_to_update_user_info'];

// Condition principale pour update le projet du clientID
if (isset($_POST['update_projet']) AND $_POST['update_projet'] != NULL) {

	// Sécurisation des données puis création d'une variable
	$_POST['update_projet'] = htmlspecialchars($_POST['update_projet']);
	$update_projet = $_POST['update_projet'];

	// Préparation puis éxécution de la requête pour update le nom du projet du clientID
	$req_update_projet = $bdd->prepare('UPDATE membres SET projet = "' . $update_projet . '" WHERE id = "' . $clientID_to_update_user_info . '"');
	$req_update_projet->execute();

	// Message de réussite puis redirection
	echo 'Le projet a bien été modifié. pour <strong>' . $clientID_to_update_user_info . '</strong>. Redirection en cours...';
 	header('Refresh:2; admin.php');
}

// Condition principale pour update l'avancement du projet du clientID
if (isset($_POST['update_avancement']) AND $_POST['update_avancement'] != NULL) {

	// Sécurisation des données puis création d'une variable
	$_POST['update_avancement'] = htmlspecialchars($_POST['update_avancement']);
	$update_avancement = $_POST['update_avancement'];

	// Préparation puis éxécution de la requête pour update l'avancement du projet du clientID
	$req_update_avancement = $bdd->prepare('UPDATE membres SET avancement = "' . $update_avancement . '" WHERE id = "' . $clientID_to_update_user_info . '"');
	$req_update_avancement->execute();

	// Message de réussite puis redirection
	echo "L'avancement a bien été modifié. pour <strong>' . $clientID_to_update_user_info . '</strong>. Redirection en cours...";
 	header('Refresh:2; admin.php');
}

// Condition principale pour update le lien du drive du clientID
if (isset($_POST['update_drive']) AND $_POST['update_drive'] != NULL) {

	// Sécurisation des données puis création d'une variable
	$_POST['update_drive'] = htmlspecialchars($_POST['update_drive']);
	$update_drive = $_POST['update_drive'];

	// Vérification du format de l'URL (doit comment par http://)
	if(preg_match("#^http://#", $update_drive) OR preg_match("#^https://#", $update_drive)) {

	// Préparation puis éxécution de la requête pour update le lien du drive du clientID
	$req_update_drive = $bdd->prepare('UPDATE membres SET drive = "' . $update_drive . '" WHERE id = "' . $clientID_to_update_user_info . '"');
	$req_update_drive->execute();

	// Message de réussite puis redirection
	echo 'Le drive a bien été modifié. pour <strong>' . $clientID_to_update_user_info . '</strong>. Redirection en cours...';
 	header('Refresh:2; admin.php');
 	}
 	else {
 		// Message d'erreur si format du lien du drive incorrect
 		echo 'Le format du drive doit commencer par http:// ou https://';
 		header('Refresh:2; admin.php');
 	}
}
else {
	// Message d'erreur générique
	echo 'Veuillez remplir au moins un champ';
	header('Refresh:2; admin.php');
}





 ?>
