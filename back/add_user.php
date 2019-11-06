<?php
// $nom $entreprise $mail $tel $mdp $projet $avancement $drive $type
// $message_connexion

// On vérifie la présence des variables SESSION
if (!isset($_SESSION)) {
        session_start();
}

// On vérifie la présence de la BDD
if (!isset($bdd)) {
  include('bdd.php');
}

include('fonctions.php');

// Vérificartion que les variables POST username, entreprise, mail, mdp et mdp_verif ne sont pas vides
if(!empty($_POST['username']) AND !empty($_POST['entreprise']) AND !empty($_POST['mail']) AND !empty($_POST['mdp']) AND !empty($_POST['mdp_verif'])) {

  // On sécurise les données envoyées (failles XSS)
  $_POST['username'] = htmlspecialchars($_POST['username']);
  $_POST['entreprise'] = htmlspecialchars($_POST['entreprise']);
  $_POST['mail'] = htmlspecialchars($_POST['mail']);
  $_POST['numero_tel'] = htmlspecialchars($_POST['numero_tel']);
  $_POST['mdp'] = htmlspecialchars($_POST['mdp']);
  $_POST['mdp_verif'] = htmlspecialchars($_POST['mdp_verif']);
  $_POST['projet'] = htmlspecialchars($_POST['projet']);
  $_POST['avancement'] = htmlspecialchars($_POST['avancement']);
  $_POST['drive'] = htmlspecialchars($_POST['drive']);
  $_POST['site'] = htmlspecialchars($_POST['site']);
  $_POST['serverIP'] = htmlspecialchars($_POST['serverIP']);
  $_POST['type'] = htmlspecialchars($_POST['type']);

  // On en fait des variables plus lisibles. Noter que "type" est incorrect, utiliser à l'avenir "priority_lvl" (entier de 0 ou 1 à 3) par exemple
  $username = $_POST['username'];
  $entreprise = $_POST['entreprise'];
  $mail = $_POST['mail'];
  $tel = $_POST['numero_tel'];
  $mdp = $_POST['mdp_verif'];
  $projet = $_POST['projet'];
  $avancement = $_POST['avancement'];
  $drive = $_POST['drive'];
  $site = $_POST['site'];
  $serverIP = $_POST['serverIP'];
  $type = $_POST['type'];

  // Liste des entreprise
  $entreprise_exeptions = 'OWCS';

  // On vérifie que le login n'est pas déjà présent dans la BDD
  if (!usernameVerif($username)) {

    // On vérifie que l'entreprise n'est pas déjà présente dans la BDD
    if (!entrepriseVerif2($entreprise) || $entreprise == "OWCS" || $entreprise == 'owcs') {

      // On retire tous les caractères illégaux de l'adresse mail
      $mail = filter_var($mail, FILTER_SANITIZE_EMAIL);

      // On valide l'adresse mail (caractères illégaux, format)
      if (filter_var($mail, FILTER_VALIDATE_EMAIL)) {

        // On vérifie que l'adresse mail n'est pas déjà présente dans la BDD
        if (!emailVerif($mail)) {

          // On vérifie que le MDP et sa vérification correspondent
          if($mdp == $_POST['mdp']){

            // On sécurise le MDP en le hashant
            $hashed_mdp = password_hash($mdp, PASSWORD_DEFAULT);

            // Préparation puis execution de la requête pour insérer les infos du client dans la BDD
            $req_mdp = $bdd->prepare('INSERT INTO membres(nom, entreprise, mail, tel, mdp, projet, avancement, drive, site, serverIP, type, date_ajout) VALUES("'. $username .'", "'. $entreprise .'", "'. $mail .'",  "'. $tel .'", "'. $hashed_mdp .'", "'. $projet .'", "'. $avancement .'", "'. $drive .'", "'. $site .'", "'. $serverIP .'", "'. $type .'", CURDATE())');
            $req_mdp->execute();
            // Repositionnement du curseur
            $req_mdp->closeCursor();

            // Préparation de la requête pour sortir l'ID du client ainsi ajouté
            $req_see_userID = $bdd->prepare('SELECT id FROM membres WHERE nom = "'. $username .'"');
            $req_see_userID->execute();
            $clientsID = $req_see_userID->fetch();
            // Repositionnement du curseur
            $req_see_userID->closeCursor();

            // Préparation puis execution de la requête pour ajouter l'ID du client dans le champ 'clientsID' table 'analytics'
            $req_insert_clientsID_analytics = $bdd->prepare('INSERT INTO analytics (clientsID) VALUES ("'. $clientsID['id'] .'")');
            $req_insert_clientsID_analytics->execute();
            // Repositionnement du curseur
            $req_insert_clientsID_analytics->closeCursor();

            // Message de réussite
            $message_connexion = 'Inscription de <strong>' . $username . ' - ' . $entreprise . '</strong> effectuée.';
            }

  // Les messages suivants sont les différents messages d'erreur
          else{$message_connexion = 'Les mots de passe ne correspondent pas. Merci de rééssayer.';}
          }
        else {$message_connexion = 'L\'adresse mail est déjà enregistrée.';}
       }
      else {$message_connexion = "L'adresse mail saisie est incorrecte.";}
      }
    else {$message_connexion = 'L\'entreprise est déjà enregistrée.';}
    }
  else {$message_connexion = 'Le nom d\'utilisateur est déjà pris.';}
}
// Message par défaut
else{$message_connexion = 'Les champs suivants sont obligatoires : nom, entreprise, mail et tel.';}
 ?>
