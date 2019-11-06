<?php
if (!isset($_SESSION)) {
    session_start();
}
if (!isset($bdd)) {
    include 'bdd.php';
}

// $clientID_to_alert     $objet_alert      $msg_alert

// Variables pour l'envoi de mail ci-dessous
// $mail_to        $ligne_break(saut de ligne)    $text_message      $html_message    $boundary      $mail_subject    $header        $mail_message

// On vérifie que les variables récupérées du formulaire existent et qu'elles ne sont pas vides
if (isset($_POST['clientID_to_alert']) and isset($_POST['objet_alert']) and isset($_POST['msg_alert']) and !empty($_POST['objet_alert']) and !empty($_POST['msg_alert'])) {

    // Sécurisation des infos
    $_POST['clientID_to_alert'] = intval($_POST['clientID_to_alert']);
    $_POST['objet_alert'] = htmlspecialchars($_POST['objet_alert']);
    $_POST['msg_alert'] = htmlspecialchars($_POST['msg_alert']);

    // On créer quelques variables avec les infos issues du formulaire
    $clientID_to_alert = $_POST['clientID_to_alert'];
    $objet_alert = $_POST['objet_alert'];
    $msg_alert = $_POST['msg_alert'];

    // Préparation puis éxécution de la requête pour sélectionner les infos du client qui recevra l'alerte
    $req_verif_entreprise = $bdd->prepare('SELECT entreprise, mail FROM membres WHERE id = "' . $clientID_to_alert . '"');
    $req_verif_entreprise->execute();

    // On sort puis sécurise les données
    $result_verif_entreprise = $req_verif_entreprise->fetch();
    $result_verif_entreprise['entreprise'] = htmlspecialchars($result_verif_entreprise['entreprise']);
    $result_verif_entreprise['mail'] = htmlspecialchars($result_verif_entreprise['mail']);

    // Création de variables
    $entreprise_to_alert = $result_verif_entreprise['entreprise'];
    $mail_entreprise = $result_verif_entreprise['mail'];

    $req_verif_entreprise->closeCursor();

    // Préparation puis éxécution de la requête pour créer l'alerte
    $req_create_alert = $bdd->prepare('INSERT INTO alerts(forID, objet_alert, msg_alert, fromID, date_alert) VALUES("' . $clientID_to_alert . '", "' . $objet_alert . '", "' . $msg_alert . '", "' . $_SESSION['id'] . '", CURRENT_TIMESTAMP())');
    $req_create_alert->execute();

// Déclaration des adresses mail de destination ($mail_entreprise étant le mail du client sorti de la BDD)
    $mail_to = $mail_entreprise;

// Déclaration du header "From"
    $header_from = $entreprise_to_alert . '<' . $mail_entreprise . '>';

// Déclaration des adresses "Reply-to"
    $reply_to = '<m.boutet@owcs.fr>, <j2c@owcs.fr>';

// Filtrage des serveurs présentants des bugs et adaptation de $line_break selon les serveurs mails
    if (!preg_match("#^[a-z0-9._-]+@(hotmail|live|msn).[a-z]{2,4}$#", $mail_to)) {
        $line_break = "\r\n";
    } else {
        $line_break = "\n";
    }

// Déclaration des messages au format texte et au format HTML
    $text_message = 'Bonjour ' . $entreprise_to_alert . ', vous avez reçu l`\'alerte suivante : ' . $line_break . $objet_alert . $line_break . $msg_alert . '. Elle est visible sur le dashboard ONLYWEB';

    $html_message = '<html><head></head><body style="font-size:110%;">Bonjour <strong>' . $entreprise_to_alert . '</strong>, vous avez reçu l\'alerte suivante : <br /><br /><strong style="margin-left:20px; font-size:110%;">' . $objet_alert . '</strong><br /><i style="margin-left:20px; font-style: normal;">' . $msg_alert . '</i><br /><br /> Elle est visible sur le dashboard ONLYWEB. <a href="http://localhost/travaux/dashboard/connexion.php">Cliquez ici pour y accéder et signaler de sa validation.</a></body></html>';

// Création de la boundary
    $boundary = "-----=" . md5(rand());

// Définition du sujet du mail
    $mail_subject = 'Vous avez reçu une alerte de la part d\'ONLYWEB';

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
        echo '<br>Mail envoyé avec succès à <strong>' . $entreprise_to_alert . '</strong><br>';

// Insertion du mail dans la BDD
        $req_create_mail = $bdd->prepare('INSERT INTO mails (forID, mail_subject, mail_message, date_mail) VALUES ("' . $clientID_to_alert . '", "' . $mail_subject . '", "' . $mail_message . '", CURDATE())');
        $req_create_mail->execute();

        echo '<br>Alerte et mail envoyés avec succès. Redirection en cours...';
        header('Refresh:3s; url=admin.php');
    } else {
        echo "<br><strong>Erreur lors de l'envoi du mail.</strong> Redirection en cours...";
        header('Refresh:3s; url=admin.php');
    }
} else {
    echo 'Veillez remplir tous les champs. Redirection en cours...';
    header('Refresh:3s; url=admin.php');
}
