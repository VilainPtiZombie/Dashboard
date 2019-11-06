s<?php
// On vérifie la présence des variables SESSION, elles sont créées si absentes
if(!isset($_SESSION)) {
        session_start();
}
// On s'assure de la présence de l'appel de la BDD
if(!isset($bdd)) {
  include('../back/bdd.php');
}


// On vérifie la présence des variables

if (!empty($_POST['user_to_add_to_server']) AND !empty($_POST['server_to_update'])) {

  // On sécurise les infos
  $_POST['user_to_add_to_server'] = htmlspecialchars($_POST['user_to_add_to_server']);

    // Préparation et execution de la requête pour update le serveur du client
    $req_update_serverID = $bdd->prepare('UPDATE membres SET serverIP = "'.$_POST['server_to_update'].'"  WHERE entreprise = "'.$_POST['user_to_add_to_server'].'"');
    $req_update_serverID->execute();

    // Message de succès puis redirection
    $success_serverID_update = "L'ID du serveur a été ajouté avec succès";
    header('Location: server_managment.php?success_serv_update');
}
else {
  // Message d'erreur puis redirection
  $success_serverID_update = "Erreur lors de l'ajout de l'IP de : <strong>" . $_POST['user_to_add_to_server'] . ".</strong> Merci de réessayer.";
  header('Location: server_managment.php?fail_serv_update');
}
?>
