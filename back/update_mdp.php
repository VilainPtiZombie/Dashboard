		<?php
include('bdd.php');

// $client_pass_to_update(ID du client à update)	$last_mdp(dernier MDP du client) 	$new_mdp 	$confirm_new_mdp


// Condition principale : vérification de la présence du champ du dernier MDP du client
if (isset($_POST['last_mdp']) AND !empty($_POST['last_mdp'])){

	// Sécurisation des données
	$_POST['client_pass_to_update'] = intval($_POST['client_pass_to_update']);
	$_POST['last_mdp'] = htmlspecialchars($_POST['last_mdp']);

	// Création de variables avec ces données
	$client_pass_to_update = $_POST['client_pass_to_update'];
	$last_mdp = $_POST['last_mdp'];

	// Préparation puis éxécution de la requête, pour sortir le dernier MDP de l'entreprise
	$req_verif_last_mdp = $bdd->prepare('SELECT mdp, entreprise FROM membres WHERE id = "'. $client_pass_to_update .'"');
	$req_verif_last_mdp->execute();
	$result_verif_last_mdp = $req_verif_last_mdp->fetch();

	// Vérification que le dernier MDP correspond à celui saisi dans le champ du formulaire
	$last_mdp_is_correct = password_verify($last_mdp, $result_verif_last_mdp['mdp']);

	// Reposionnement du curseur
	$req_verif_last_mdp->closeCursor();

	// Condition : si le mdp est incorrect...
	if (!$last_mdp_is_correct) {

		// ... Message d'erreur
		$update_mdp_msg = 'Le mot de passe actuel est incorrect';
		header('Refresh:3; url=admin.php');
	}

	// ... sinon, si le dernier MDP est correct...
	elseif (isset($last_mdp_is_correct)) {

		// Vérification des champs du nouveau MDP
		if (isset($_POST['new_mdp'], $_POST['confirm_new_mdp']) AND !empty($_POST['new_mdp'] AND !empty($_POST['confirm_new_mdp']))) {

			// Sécurisation des données
			$_POST['confirm_new_mdp'] = htmlspecialchars($_POST['confirm_new_mdp']);
			$_POST['new_mdp'] = htmlspecialchars($_POST['new_mdp']);

			// Création de variables avec ces données
			$new_mdp = $_POST['new_mdp'];
			$confirm_new_mdp = $_POST['confirm_new_mdp'];

			// Condition : si le champ du nouveau MDP et celui de vérification du nouveau MDP correspondent
			if ($new_mdp == $confirm_new_mdp) {

				// Hashage (cryptage) du nouveau MDP
				$hashed_new_mdp = password_hash($new_mdp, PASSWORD_DEFAULT);

				// Préparation puis éxécution de la requête pour update le MDP
				$req_new_mdp = $bdd->prepare('UPDATE membres SET mdp = "'. $hashed_new_mdp .'" WHERE id = "'. $client_pass_to_update .'"');
				$req_new_mdp->execute();

				// Message de réussite puis redirection
				$update_mdp_msg = 'Le mot de passe a bien été modifié.';
				header('Refresh:3; admin.php');
			}
			else {
				$update_mdp_msg = 'Les nouveaux MDP ne correspondent pas.';
				header('Refresh:3; admin.php');
			}
		}
		else {
			$update_mdp_msg = 'Un champ nouveau MDP est manquant.';
			header('Refresh:3; admin.php');
		}
	}
}
else{
	$update_mdp_msg = 'Des champs sont manquants.';
	header('Refresh:3; admin.php');
}
 ?>
<!DOCTYPE html>
<html lang="fr">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<link rel="stylesheet" href="../css/reset.css">
    <link rel="stylesheet" href="../css/normalize.min.css">
	<link href="https://use.fontawesome.com/releases/v5.0.8/css/all.css" rel="stylesheet">
	<link rel="stylesheet" href="../bootstrap/css/bootstrap-reboot.css">
	<link rel="stylesheet" href="../bootstrap/css/bootstrap-grid.css">
	<link rel="stylesheet" href="../bootstrap/css/bootstrap.css">
	<link rel="stylesheet" href="../css/style.css">
	<title>Modification mot de passe</title>
</head>
<body>
	<section id="traitements">
		<h1 class="tac">Dashboard ONLYWEB</h1>
		<p class="centered_msg_php mtl"><?php echo $update_mdp_msg; ?></p>
		<p class="centered_msg_php mtxm">Redirection en cours...</p>
	</section>
</body>
</html>