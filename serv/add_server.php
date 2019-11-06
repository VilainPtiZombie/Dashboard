<?php
// On vérifie la présence des variables SESSION, elles sont créées si absentes
if(!isset($_SESSION)) {
        session_start();
}
// On s'assure de la présence de l'appel de la BDD
if(!isset($bdd)) {
	include('../back/bdd.php');
}

//   $serverIP

include ('../back/fonctions.php');

if (!empty($_POST['server_ip']) AND !empty($_POST['server_login']) AND !empty($_POST['server_pass']) AND !empty($_POST['verif_server_pass'])) {

	// On sécurise les infos
	$_POST['server_ip'] = htmlspecialchars($_POST['server_ip']);
	$_POST['server_login'] = htmlspecialchars($_POST['server_login']);
	$_POST['server_pass'] = htmlspecialchars($_POST['server_pass']);
	$_POST['verif_server_pass'] = htmlspecialchars($_POST['verif_server_pass']);
	$serverIP = $_POST['server_ip'];

	// On vérifie que c'est une adresse IP valide
	if(filter_var($serverIP, FILTER_VALIDATE_IP) !== false) { // Validation d'une adresse IP.

		// On vérifie que le serveur n'est pas déjà inscrit dans la BDD
		if (!serverVerif($serverIP)) {
	
			// On vérifie que le mdp et sa vérification correspondent
			if ($_POST['server_pass'] == $_POST['verif_server_pass']) {
	
				// On hash (crypte) le mdp
				$hashed_server_pass = password_hash($_POST['verif_server_pass'], PASSWORD_DEFAULT);
	
				// On prépare la requête d'insertion des données dans la table "servers"
				$req_add_server = $bdd->prepare('INSERT INTO servers (ip, login, mdp) VALUES ("' . $_POST['server_ip'] . '", "' . $_POST['	server_login'] . '", "' . $hashed_server_pass . '")');
	
				// On éxécute la requête
				$req_add_server->execute();
	
				// Pas sur de sa nécessité
				$req_add_server->closeCursor();
	
				// On créer le message de réussite
				$add_server_msg = 'Serveur enregistré avec succès.';
	
				// On redirige l'utilisateur avec affichage du message
				header('Location: server_managment.php?success');
			}
			else {
				// Message si erreur MDP
				$add_server_msg = 'Les MDP ne correspondent pas.';
		
				// On redirige l'utilisateur avec affichage du message
				header('Location: server_managment.php?pass_error');
			}
		}
		else {
			// Message si doublons d'IP puis redirection avec affichage du message
			$add_server_msg = "L'adresse IP est déjà enregistrée dans la BDD.";
			header('Location: server_managment.php?doubled');
		}
	}
	else {
		// Message si IP au mauvais format
		$add_server_msg = "L'adresse IP n'est pas au bon format.";
		header('Location: server_managment.php?falseIP');
	}
}
else {
	// Message d'erreur remplir champs puis redirection avec affichage du message
	$add_server_msg = 'Veuillez remplir tous les champs.';
	header('Location: server_managment.php?empty');
}


 ?>

