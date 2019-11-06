<?php
if (!isset($_SESSION)) {
	session_start();
}
if (!isset($bdd)) {
	include('bdd.php');
}

// On sécurise le nom à update
$_POST['clientID_to_update_contacts'] = intval($_POST['clientID_to_update_contacts']);

// Condition principale pour update adresse mail
if (isset($_POST['update_mail']) AND !empty($_POST['update_mail'])) {

	// On sécurise l'adresse mail à update
	$_POST['update_mail'] = htmlspecialchars($_POST['update_mail']);

	// On prépare puis éxécute la requête pour update le mail de l'utilisateur
	$req_update_mail = $bdd->prepare('UPDATE membres SET mail = "' . $_POST['update_mail'] . '" WHERE id = "' . $_POST['clientID_to_update_contacts'] . '"');
	$req_update_mail->execute();

	// Message de réussite puis redirection
	echo $message = 'L\'adresse mail a été modifié.';
	header('Refresh:3; url=admin.php');
}
else {
	echo "Erreur lors de la modification de l'adresse mail. Merci de réessayer.
	<br> Redirection en cours...";
	header('Refresh:3; url=admin.php');
}

// Condition principale pour update numéro de tel
if (isset($_POST['update_tel']) AND !empty($_POST['update_tel'])) {

	// On sécurise le numéro de tel à update
	$_POST['update_tel'] = htmlspecialchars($_POST['update_tel']);

	// On prépare puis éxécute la requête pour update le numéro de tel de l'utilisateur
	$req_update_tel = $bdd->prepare('UPDATE membres SET tel = "' . $_POST['update_tel'] . '" WHERE id = "' . $_POST['clientID_to_update_contacts'] . '"');
	$req_update_tel->execute();

	// Message de réussite puis redirection
	echo $message = '<br>Le numéro de téléphone a été modifié.';
	header('Refresh:3; url=admin.php');
}
else {
	echo "<br><br> Erreur lors de la modification du numéro de téléphone. Merci de réessayer.
	<br> Redirection en cours...";
	header('Refresh:3; url=admin.php');
}

// Condition principale pour update le nom de l'entreprise
if (isset($_POST['update_entreprise']) AND !empty($_POST['update_entreprise'])) {

	// On sécurise le nom d'entreprise à update
	$_POST['update_entreprise'] = htmlspecialchars($_POST['update_entreprise']);

	// On prépare puis éxécute la requête pour update le nom d'entreprise de tel de l'utilisateur
	$req_update_entreprise = $bdd->prepare('UPDATE membres SET entreprise = "' . $_POST['update_entreprise'] . '" WHERE id = "' . $_POST['clientID_to_update_contacts'] . '"');
	$req_update_entreprise->execute();

	// Message de réussite puis redirection
	echo $message = '<br>Le nom de l\'entreprise a été modifié.';
	header('Refresh:3; url=admin.php');

}
else {
	echo $message = "<br><br> Erreur lors de la modification du nom de l'entreprise. Merci de réessayer.
	<br> Redirection en cours...";
	header('Refresh:3; url=admin.php');
}
 ?>
