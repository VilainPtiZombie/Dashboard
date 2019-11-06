<?php
// VOIR SI METTRE MAIL EN SESSION EST DANGEREUX ?
// MODIFIER $client_to_alert LORS INSERTION BDD (tout en bas), modifier par l'ID OWCS = 184

// Appel des variables de sessions si celles-ci ne sont pas lancées
if(!isset($_SESSION)) {
        session_start();
}

// Appel de la BDD si celle-ci n'est pas déjà appelée
if (!isset($bdd)) {
	include('../back/bdd.php');
}

// Vérification de la présence du message et qu'il ne soit pas vide
if (isset($_POST['message_minichat']) AND !empty($_POST['message_minichat'])) 
{

	// Sécurisation des données
	$_POST['date_msg_minichat'] = htmlspecialchars($_POST['date_msg_minichat']);
	$_POST['for_user'] = htmlspecialchars($_POST['for_user']);
	$_POST['authorID_msg_minichat'] = intval($_POST['authorID_msg_minichat']);
	$_POST['author_msg_minichat'] = htmlspecialchars($_POST['author_msg_minichat']);
	$_POST['message_minichat'] = htmlspecialchars($_POST['message_minichat']);


	// Préparation puis execution de la requête pour ajouter le message dans la table "minichat_2"
	$req_post_message = $bdd->prepare('INSERT INTO minichat_2 (par, pour, message, date_message) VALUES ("' . $_SESSION['entreprise'] . '", "' . $_POST['for_user'] . '", "' . $_POST['message_minichat'] . '", CURRENT_TIMESTAMP())');
	$req_post_message->execute();

	// var_dump($req_post_message); echo $req_post_message;

	// Message de réussite
	$msg_minichat_post = 'Votre message a bien été envoyé';
	//header('Refresh:2; index.php');






	// Si pas de date next_mail provenant du meme clientID
	$req_verif_next_mail = $bdd->prepare('SELECT date_mail, date_next_mail FROM mails WHERE forID = "'. $_POST['authorID_msg_minichat'] .'"')
	if ()








	// Préparation puis execution de la requête pour sortir les infos pour l'envoi du mail
	$req_mail_infos = $bdd->prepare('SELECT mail FROM membres WHERE id = "'. $_POST['authorID_msg_minichat'] .'"');
	$req_mail_infos->execute();

	// On sort puis sécurise la donnée
	$res_mail_infos = $req_mail_infos->fetch();
	$res_mail_infos['mail'] = htmlspecialchars($res_mail_infos['mail']);

	// On en fait une variable plus lisible
	$mail_entreprise = $res_mail_infos['mail'];

	$req_mail_infos->closeCursor();


// Déclaration des adresses mail de destination
$mail_to = 'm.boutet@owcs.fr, j2c@owcs.fr';

// Déclaration du header "From"
$header_from = $_POST['author_msg_minichat'] . '<' . $mail_entreprise . '>';

// Déclaration des adresses "Reply-to"
$reply_to = $_POST['author_msg_minichat'] . '<' . $mail_entreprise . '>';

// Déclaration des liens page acceuil et page backend du dashboard
$accueil_link = '<a href="http://v2.owcs.fr/dashboard/index/index.php">la page d\'accueil du dashboard</a>';
$backend_link = '<a href="http://v2.owcs.fr/dashboard/back/admin.php">via la partie "backend"</a>';


// Filtrage des serveurs présentants des bugs et adaptation de $line_break selon les serveurs mails
if (!preg_match("#^[a-z0-9._-]+@(hotmail|live|msn).[a-z]{2,4}$#", $mail_to)) {
  $line_break = "\r\n";
}
else {
  $line_break = "\n";
}

// Déclaration des messages au format texte et au format HTML
$text_message = 'Vous avez reçu le message suivant, de la part de ' . $_POST['author_msg_minichat'] . ', via le minichat du dashboard ONLYWEB : ' . $line_break . $line_break . $_POST['message_minichat'] . $line_break . $line_break . 'Vous pouvez le voir sur la page d\'accueil du dashboard et y répondre via la partie "backend" de ce dernier.';

$html_message = '<html><head></head><body style="font-size:110%;">Vous avez reçu le message suivant, de la part de <strong>' . $_POST['author_msg_minichat'] . '</strong>, via le minichat du dashboard ONLYWEB : <br /><br /> <strong style="margin-left:20px;">' . $_POST['message_minichat'] . '</strong><br /><br />Vous pouvez le voir sur ' . $accueil_link . ' et y répondre ' . $backend_link . ' de ce dernier.</body></html>';

// Création de la boundary
$boundary = "-----=".md5(rand());

// Définition du sujet du mail
$mail_subject = 'Vous avez reçu un message de ' . $_POST['author_msg_minichat'] .', via le minichat ONLYWEB';

// Création du header du mail
$header = "From:" . $header_from . $line_break;
$header .= "Reply-to:" . $reply_to . $line_break;
$header .= "MIME-Version: 1.0" . $line_break;
$header .= "Content-Type: multipart/alternative;" . $line_break . " boundary=\"$boundary\"" . $line_break;


// Création du message
$mail_message = $line_break . "--" . $boundary . $line_break;

// Ajout du message au format texte
$mail_message .= "Content-Type: text/plain; charset=\"ISO-8859-1\"" . $line_break;
$mail_message .= "Content-Transfer-Encoding: 8bit" . $line_break;
$mail_message .= $line_break . $text_message . $line_break;
// ==
$mail_message .= $line_break . "--" . $boundary . $line_break;

// Ajout du message au format HTML
$mail_message .= "Content-Type: text/html; charset=\"ISO-8859-1\"" . $line_break;
$mail_message .= "Content-Transfer-Encoding: 8bit" . $line_break;
$mail_message .= $line_break . $html_message . $line_break;
//==
$mail_message .= $line_break . "--" . $boundary . "--" . $line_break;
$mail_message .= $line_break . "--" . $boundary . "--" . $line_break;


// Envoi du mail
if (mail($mail_to, $mail_subject, $mail_message, $header)) {
  //echo '<br>Mail envoyé avec succès à <strong>ONLYWEB</strong><br>';

// Insertion du mail dans la BDD
  $req_create_mail = $bdd->prepare('INSERT INTO mails (forID, mail_subject, mail_message, date_mail, date_next_mail) VALUES ("'. $_POST['authorID_msg_minichat'] .'", "'. $mail_subject .'", "'. $mail_message .'", CURRENT_TIMESTAMP(), (CURRENT_TIMESTAMP() + (7 * 3600)))');
  $req_create_mail->execute();

  echo '<br>Message et mail envoyés avec succès à '. $_POST['author_msg_minichat'] .'. Redirection en cours...';
  header('Refresh:3s; url=index.php');
  }
  else
  {
    echo "<br><strong>Erreur lors de l'envoi du mail.</strong> Redirection en cours...";
    header('Refresh:3s; url=index.php');
  }
}
// Message d'erreur
else {$msg_minichat_post = 'Veuillez saisir un message';}
 ?>
