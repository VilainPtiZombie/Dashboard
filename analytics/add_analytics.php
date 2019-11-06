<?php 
// On vérifie la présence des variables SESSION
if (!isset($_SESSION)) {
        session_start();
}

// On vérifie la présence de la BDD
if (!isset($bdd)) {
  include('../back/bdd.php');
}

// On sécurise le nom à update
$_POST['clientID_to_add_analytics'] = intval($_POST['clientID_to_add_analytics']);

// Vérification que le champ 'Nombre de visiteurs' ne soit pas vide
if (isset($_POST['userNb']) AND !empty($_POST['userNb']))
{
	// Utilisation de addslashes() pour insérer correctement le code HTML dans la BDD
	$_POST['userNb'] = addslashes($_POST['userNb']);

	// Préparation puis éxécution de la requête pour ajouter le graph 'Nombre de visiteurs' du site de l'utilisateur
	$req_add_userNb = $bdd->prepare('UPDATE analytics SET userNb = "'. $_POST['userNb'] .'" WHERE  clientsID = "'. $_POST['clientID_to_add_analytics'] .'"');
	$req_add_userNb->execute();

	// Repositionnement du curseur
	$req_add_userNb->closeCursor();

	// Message de réussite puis redirection
	echo "<br> Le code du graph <strong>'Nombre de visiteurs'</strong> a bien été ajouté à la BDD, pour : <strong>" . $_POST['clientID_to_add_analytics'] . "</strong>";
	header('Refresh:4; url=../back/admin.php');
}
else
{
	echo "<br> Une erreur s'est produite lors de l'ajout du code du graph 'Nombre de visiteurs', merci de réessayer.";
}


// Vérification que le champ 'Nombre de sessions' ne soit pas vide
if (isset($_POST['sessionNb']) AND !empty($_POST['sessionNb']))
{
	// Utilisation de addslashes() pour insérer correctement le code HTML dans la BDD
	$_POST['sessionNb'] = addslashes($_POST['sessionNb']);

	// Préparation puis éxécution de la requête pour ajouter le graph 'Nombre de sessions' du site de l'utilisateur
	$req_add_sessionNb = $bdd->prepare('UPDATE analytics SET sessionNb = "'. $_POST['sessionNb'] .'" WHERE  clientsID = "'. $_POST['clientID_to_add_analytics'] .'"');
	$req_add_sessionNb->execute();

	// Repositionnement du curseur
	$req_add_sessionNb->closeCursor();

	// Message de réussite puis redirection
	echo "<br> Le code du graph <strong>'Nombre de sessions'</strong> a bien été ajouté à la BDD, pour : <strong>" . $_POST['clientID_to_add_analytics'] . "</strong>";
	header('Refresh:4; url=../back/admin.php');
}
else
{
	echo "<br> Une erreur s'est produite lors de l'ajout du code du graph 'Nombre de sessions', merci de réessayer.";
}


// Vérification que le champ 'Taux de rebond' ne soit pas vide
if (isset($_POST['bounceRate']) AND !empty($_POST['bounceRate']))
{
	// Utilisation de addslashes() pour insérer correctement le code HTML dans la BDD
	$_POST['bounceRate'] = addslashes($_POST['bounceRate']);

	// Préparation puis éxécution de la requête pour ajouter le graph 'Taux de rebond' du site de l'utilisateur
	$req_add_bounceRate = $bdd->prepare('UPDATE analytics SET bounceRate = "'. $_POST['bounceRate'] .'" WHERE  clientsID = "'. $_POST['clientID_to_add_analytics'] .'"');
	$req_add_bounceRate->execute();

	// Repositionnement du curseur
	$req_add_bounceRate->closeCursor();

	// Message de réussite puis redirection
	echo "<br> Le code du graph <strong>'Taux de rebond'</strong> a bien été ajouté à la BDD, pour : <strong>" . $_POST['clientID_to_add_analytics'] . "</strong>";
	header('Refresh:4; url=../back/admin.php');
}
else
{
	echo "<br> Une erreur s'est produite lors de l'ajout du code du graph 'Taux de rebond', merci de réessayer.";
}

// Vérification que le champ 'Durée moyenne des sessions' ne soit pas vide
if (isset($_POST['sessionDuration']) AND !empty($_POST['sessionDuration']))
{
	// Utilisation de addslashes() pour insérer correctement le code HTML dans la BDD
	$_POST['sessionDuration'] = addslashes($_POST['sessionDuration']);

	// Préparation puis éxécution de la requête pour ajouter le graph 'Durée moyenne des sessions' du site de l'utilisateur
	$req_add_sessionDuration = $bdd->prepare('UPDATE analytics SET sessionDuration = "'. $_POST['sessionDuration'] .'" WHERE  clientsID = "'. $_POST['clientID_to_add_analytics'] .'"');
	$req_add_sessionDuration->execute();

	// Repositionnement du curseur
	$req_add_sessionDuration->closeCursor();

	// Message de réussite puis redirection
	echo "<br> Le code du graph <strong>'Durée moyenne des sessions'</strong> a bien été ajouté à la BDD, pour : <strong>" . $_POST['clientID_to_add_analytics'] . "</strong>";
	header('Refresh:4; url=../back/admin.php');
}
else
{
	echo "<br> Une erreur s'est produite lors de l'ajout du code du graph 'Durée moyenne des sessions', merci de réessayer.";
}

 ?>