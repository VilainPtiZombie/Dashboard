<?php
if(!isset($_SESSION)) {
        session_start();
}

// Si les variables de sessions nom et entreprise existent, l'utilisateur est déjà connecté
if(isset($_SESSION['nom'], $_SESSION['entreprise']))
{
	// Message de redirection puis redirection
	$connexion_msg = 'Vous êtes déjà connecté, redirection vers le dashboard en cours...';
	header('Refresh:2; url=index/index.php');
}
else 
{
  	// Message erreur
	$connexion_msg = 'Merci de saisir votre identifiant ainsi que mot de passe.';
}

// Vérification de la présence des variables POST ainsi qu'elles ne soient pas vides
if(isset($_POST['username']) AND isset($_POST['mdp']) AND !empty($_POST['username']) AND !empty($_POST['mdp']))
{

// Sécurisation des données et création de variables
$_POST['username'] = htmlspecialchars(htmlspecialchars($_POST['username']));

$nom = htmlspecialchars($_POST['username']);
$mdp = htmlspecialchars($_POST['mdp']);

// Préparation puis execution de la requête pour sortir les infos dont le nom correspond à celui dans la BDD
$req = $bdd->prepare('SELECT * FROM membres WHERE nom = "'. $nom .'"');
$req->execute();

// On sort les résultats avec un FETCH
$resultat = $req->fetch();
$req->closeCursor();

// Vérification par déhashage du MDP de la BDD et comparaison avec celui saisi dans le champ mdp
$mdp_conforme = password_verify($mdp, $resultat['mdp']);

	// Si pas de comparaison dans la BDD, message d'erreur
	if(!$resultat)
	{
		$connexion_msg = 'Mauvais identifiant ou mot de passe, merci de réessayer.';
	}

	// Sinon, si le nouveau MDP est identique à celui saisi :
	elseif($mdp_conforme)
	{
	  // Sécurisation des données
		$resultat['id'] = intval($resultat['id']);
		$resultat['entreprise'] = htmlspecialchars($resultat['entreprise']);
		$resultat['projet'] = htmlspecialchars($resultat['projet']);
		$resultat['avancement'] = htmlspecialchars($resultat['avancement']);
		$resultat['drive'] = htmlspecialchars($resultat['drive']);
		$resultat['site'] = htmlspecialchars($resultat['site']);
		$resultat['type'] = htmlspecialchars($resultat['type']);
		//$resultat['mail'] = htmlspecialchars($resultat['mail']);

	  // Création des variables SESSION avec les infos de l'utilisateur venants de la BDD
		$_SESSION['id'] = $resultat['id'];
		$_SESSION['nom'] = $nom;
	 	$_SESSION['entreprise'] = $resultat['entreprise'];
	 	$_SESSION['projet'] = $resultat['projet'];
	 	$_SESSION['avancement'] = $resultat['avancement'];
	 	$_SESSION['drive'] = $resultat['drive'];
	 	$_SESSION['site'] = $resultat['site'];
	 	$_SESSION['type'] = $resultat['type'];
	 	//$_SESSION['mail'] = $resultat['mail'];
	
	    // Message de réussite et redirection
		$connexion_msg = 'Connexion réussie ! Redirection vers le dashboard en cours...';
		header('Refresh:1; url=index/index.php');
	}
	else
	{
    // Message d'echec (volontairement vague)
		$connexion_msg = 'Mauvais identifiant ou mot de passe, merci de réessayer.';
	}
}
 ?>
