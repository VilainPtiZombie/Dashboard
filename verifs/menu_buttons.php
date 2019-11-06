<?php
// Affichage du bouton de déconnexion
// Obligé d'ajouter AND $_POST = 1 sinon autorefresh toutes les secondes de la page index.php sous IOS
if(isset($_POST['deconnexion']) AND $_POST['deconnexion'] = 1)
{
	// Destruction des variables de session
	$_SESSION = array();
	session_destroy();

	// Message de réussite
	echo 'Déconnexion réussie.';
	header('Location: ../connexion.php');
}

// Script d'affichage des boutons "Backend" et "Serveurs"
// Condition : si l'utilisateur connecté est un ADMIN
if ($_SESSION['type'] == 'Administrateur')
{
	// On affiche les boutons "backend" et "serveurs"
 	echo '<li><a href="../back/admin.php">Backend</a></li>';
	echo '<li><a href="../serv/server_managment.php">Serveurs</a></li>';
}

// Affichage du bouton "Analytics", condition : si l'utilisateur est connecté et est un ADMIN ou CLIENT
if ($_SESSION['type'] == 'Administrateur' || $_SESSION['type'] == 'Client')
{
	// On affiche le bouton analytics
 	echo '<li><a href="../analytics/analytics.php">Analytics</a></li>';
}
?>