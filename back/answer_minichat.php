<?php
if (!isset($_SESSION)) {
	session_start();
}
if (!isset($bdd)) {
	include('bdd.php');
}

// Vérification que le champ soit présent et non vide
if (isset($_POST['answer_minichat']) AND !empty($_POST['answer_minichat'])) {

	// Sécurisation des données
	$_POST['client_to_answer_minichat'] = htmlspecialchars($_POST['client_to_answer_minichat']);
	$_POST['answer_minichat'] = htmlspecialchars($_POST['answer_minichat']);

	// Requête pour vérifier que l'entreprise existe bien dans la BDD et pour sortir son mail et nom de l'entreprise, puis execution et sécurisation de l'info
	$req_client_info = $bdd->prepare('SELECT id, mail FROM membres WHERE entreprise = "'. $_POST['client_to_answer_minichat'] .'"');
	$req_client_info->execute();
	// $result_client_info['id'] = intval($result_client_info['id']);


	// Si l'ID existe dans la BDDD
	if ($result_client_info = $req_client_info->fetch()) 
	{

		// Sécurisation des données
		$result_client_info['id'] = intval($result_client_info['id']);
		$result_client_info['mail'] = htmlspecialchars($result_client_info['mail']);

		// Création d'une variable avec l'entreprise et le mail du client
		$clientID = $result_client_info['id'];
		$mail_entreprise = $result_client_info['mail'];
		$entreprise_to_answer = $_POST['client_to_answer_minichat'];

		// Préparation puis execution de la requête pour mettre à jour la table minichat_2
		$req_answer_minichat = $bdd->prepare('INSERT INTO minichat_2(par, pour, message, date_message) VALUES( "'. $_SESSION['entreprise'] .'", "'. $_POST['client_to_answer_minichat'] .'", "'. $_POST['answer_minichat'] .'", CURRENT_TIMESTAMP())');
		$req_answer_minichat->execute();
		
		// Message de réussite d'envoi du message
		echo $msg_answer_minichat = 'Message envoyé avec succès. Redirection en cours...';
		header('Refresh:3; url=admin.php');
		
		
		// Déclaration des adresses mail de destination ($mail_entreprise étant le mail du client sorti de la BDD)
		$mail_to = $mail_entreprise;
		
		// Déclaration du header "From"
		$header_from = '<m.boutet@owcs.fr>, <j2c@owcs.fr>';  
		
		// Déclaration des adresses "Reply-to"
		$reply_to = '<m.boutet@owcs.fr>, <j2c@owcs.fr>';
		
		// Déclaration du lien de la page d'acceuil
		$accueil_link = '<a href="http://v2.owcs.fr/dashboard/index/index.php">la page d\'accueil du dashboard</a>';
		
		// Filtrage des serveurs présentants des bugs et adaptation de $line_break selon les serveurs mails
		if (!preg_match("#^[a-z0-9._-]+@(hotmail|live|msn).[a-z]{2,4}$#", $mail_to)) 
		{
		  $line_break = "\r\n";
		}
		else 
		{
		  $line_break = "\n";
		}
		
		// Déclaration des messages au format texte et au format HTML
		$text_message = 'Vous avez reçu le message suivant, via le minichat du dashboard ONLYWEB : ' . $line_break . $line_break . $_POST['answer_minichat'] . $line_break . $line_break . 'Vous pouvez le voir et y répondre sur la page d\'accueil du dashboard.';
		
		$html_message = '<html><head></head><body style="font-size:110%;">Vous avez reçu le message suivant, via le minichat du dashboard ONLYWEB : <br /><br /> <strong style="margin-left:20px;">' . $_POST['answer_minichat'] . '</strong><br /><br />Vous pouvez le voir et y répondre sur ' . $accueil_link . '.</body></html>';
		
		
		// Création de la boundary
		$boundary = "-----=".md5(rand());
		
		// Définition du sujet du mail
		$mail_subject = 'Vous avez reçu un message de la part d\'ONLYWEB, via son minichat.';
		
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
		  echo '<br>Mail envoyé avec succès à <strong>' . $entreprise_to_answer . '</strong><br>';
		
		// Insertion du mail dans la BDD
		  $req_create_mail = $bdd->prepare('INSERT INTO mails (forID, mail_subject, mail_message, date_mail) VALUES ("'. $clientID .'", "'. $mail_subject .'", "'. $mail_message .'", CURDATE())');
		  $req_create_mail->execute();
		
		  echo '<br>Alerte et mail envoyés avec succès. Redirection en cours...';
		  header('Refresh:3s; url=admin.php');
		  }
		  else 
		  {
		    echo "<br><strong>Erreur lors de l'envoi du mail.</strong> Redirection en cours...";
		    header('Refresh:3s; url=admin.php');
		  }
	}
	else {echo $msg_answer_minichat = "L'ID de l'utilisateur ne figure pas dans la BDD";}
}
 ?>
