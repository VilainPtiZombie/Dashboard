<?php
if (!isset($_SESSION)) {
    session_start();
}
if (!isset($bdd)) {
    include '../back/bdd.php';
}

// Le but ici est de changer la valeur du champ "done" de la table "alerts", pour signaler que le client a bien fait ce qu'il lui était demandé ou l'inverse

// On vérifie que la checkbox est checked et que sa valeur est NO
if ($_POST['checked'] == 'NO' and !empty($_POST['alert_validation'])) {

// On prépare la requête pour update les infos de l'alerte cochée
    $req_update_done_alert = $bdd->prepare('UPDATE alerts SET done = "DONE" WHERE id = "' . $_POST['alertID'] . '"');

// On execute la requête
    $req_update_done_alert->execute();

// Redirection
    header('Location: index.php');

// header('Location: index.php');
}

if ($_POST['checked'] == 'DONE' and !empty($_POST['alert_validation'])) {
    // On prépare la requête pour update les infos de l'alerte cochée
    $req_update_done_alert = $bdd->prepare('UPDATE alerts SET done = "NO" WHERE id = "' . $_POST['alertID'] . '"');

// On execute la requête
    $req_update_done_alert->execute();

// Préparation puis execution de la requête pour sortir les infos du client pour l'envoi du mail à OWCS, comme quoi l'alerte a été faite
    $req_mail_infos = $bdd->prepare('SELECT mail, entreprise FROM membres WHERE id = "' . $_SESSION['id'] . '"');
    $req_mail_infos->execute();

    // On sort puis sécurise la donnée
    $res_mail_infos = $req_mail_infos->fetch();
    $res_mail_infos['mail'] = htmlspecialchars($res_mail_infos['mail']);
    $res_mail_infos['entreprise'] = htmlspecialchars($res_mail_infos['entreprise']);

    // On en fait une variable plus lisible
    $mail_entreprise = $res_mail_infos['mail'];
    $entreprise_from = $res_mail_infos['entreprise'];

    // Repositionnement du curseur
    $req_mail_infos->closeCursor();

    // Préparation puis execution de la requête pour sortir l'objet de l'alerte confirmée
    $req_alert_object = $bdd->prepare('SELECT objet_alert FROM alerts WHERE id = "' . $_POST['alertID'] . '"');
    $req_alert_object->execute();

    // On sort puis sécurise la donnée
    $res_alert_object = $req_alert_object->fetch();
    $res_alert_object['objet_alert'] = $req_alert_object['objet_alert'];

    // On en fait un variable plus lisible
    $alert_object = $res_alert_object['objet_alert'];

    // Repositionnement du curseur
    $req_alert_object->closeCursor();

// Déclaration des adresses mail de destination
    $mail_to = 'm.boutet@owcs.fr, j2c@owcs.fr';

// Déclaration du header "From"
    $header_from = $entreprise_from . '<' . $mail_entreprise . '>';

// Déclaration des adresses "Reply-to"
    $reply_to = $entreprise_from . '<' . $mail_entreprise . '>';

// Déclaration des liens page acceuil et page backend du dashboard
    $accueil_link = '<a href="http://v2.owcs.fr/dashboard/index/index.php">la page d\'accueil du dashboard</a>';
    $backend_link = '<a href="http://v2.owcs.fr/dashboard/back/admin.php">la partie "backend"</a>';

// Filtrage des serveurs présentants des bugs et adaptation de $line_break selon les serveurs mails
    if (!preg_match("#^[a-z0-9._-]+@(hotmail|live|msn).[a-z]{2,4}$#", $mail_to)) {
        $line_break = "\r\n";
    } else {
        $line_break = "\n";
    }

// Déclaration des messages au format texte et au format HTML
    $text_message = $entreprise_from . ' a confirmé avoir validé l\'alerte suivante : ' . $alert_object . ', via le dashboard ONLYWEB.' . $line_break . $line_break . 'Vous pouvez le voir sur la page d\'accueil ou page "backend" de ce dernier.';

    $html_message = '<html><head></head><body style="font-size:110%;"><strong>' . $entreprise_from . '</strong> a confirmé avoir validé l\'alerte suivante : ' . $alert_object . ', via le dashboard ONLYWEB.<br /><br />Vous pouvez le voir sur ' . $accueil_link . ' ou encore ' . $backend_link . ' de ce dernier.</body></html>';

// Création de la boundary
    $boundary = "-----=" . md5(rand());

// Définition du sujet du mail
    $mail_subject = $entreprise_from . ' a confirmé une alerte sur le dashboard ONLYWEB';

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
        $req_create_mail = $bdd->prepare('INSERT INTO mails (forID, mail_subject, mail_message, date_mail) VALUES (184, "' . $mail_subject . '", "' . $mail_message . '", CURDATE())');
        $req_create_mail->execute();

        echo '<br>La confirmation de l\'alerte et un mail ont été envoyés avec succès à ONLYWEB. Redirection en cours...';
        header('Refresh:3s; url=index.php');
    } else {
        echo "<br><strong>Erreur lors de l'envoi du mail.</strong> Redirection en cours...";
        header('Refresh:3s; url=index.php');
    }

// Redirection
    header('Location: index.php');
} else {
    echo 'Merci de bien cocher la case et cliquer sur le bouton. Redirection en cours...';
    header('Refresh:2; url=index.php');
}
