<?php
    function getInfos($var1, $var2, $var3, $id)
    {
        global $bdd;

        $req_infos = $bdd->prepare('SELECT "'. $var1 .'", "'. $var2 .'", "'. $var3 .'" WHERE id = "'. $id .'"');
        $req_infos->execute();
        $res = $req_infos->fetch();
        
            $res['var1'] = htmlspecialchars($res['var1']);
            $res['var2'] = htmlspecialchars($res['var2']);
            $res['var3'] = htmlspecialchars($res['var3']);

        $req_infos->closeCursor();
        
    }

    function entrepriseVerif2($entreprise)
{
    global $bdd;

    $req_verif_entreprise = $bdd->query("SELECT 1 FROM membres WHERE entreprise = '$entreprise'");

    $result_verif_entreprise = $req_verif_entreprise->fetch();

    return !empty($result_verif_entreprise);
}


    // Vérification de l'id
    function IDverif($id)
{
    global $bdd;

    $req_verif_id = $bdd->query("SELECT 1 FROM membres WHERE id = '$id'");

    $result_verif_id = $req_verif_id->fetch();

    return !empty($result_verif_id);
}


    // Vérification de doublons du nom de l'entreprise dans la BDD (version 2, plus efficace? Pas vraiment de raisons si ce n'est la lisibilité (noms des variables claires))
    function entrepriseVerif3($entreprise)
{
    global $bdd;

    $req_verif_entreprise = $bdd->query("SELECT 1 FROM membres WHERE entreprise = '$entreprise'");

    $result_verif_entreprise = $req_verif_entreprise->fetch();

    return $result_verif_entreprise;

    $req_verif_entreprise->closeCursor();
}


    // Vérification de doublons du nom du client dans la BDD
    function usernameVerif($username)
{
    global $bdd;

    $req_verif_username = $bdd->query("SELECT 1 FROM membres WHERE nom = '$username'");

    $result_verif_username = $req_verif_username->fetch();

    return !empty($result_verif_username);
}


    // Vérification de doublons de l'adresse mail dans la BDD
    function emailVerif($mail)
{
    global $bdd;

    $req_verif_mail = $bdd->query("SELECT 1 FROM membres WHERE mail = '$mail'");

    $result_verif_mail = $req_verif_mail->fetch();

    return !empty($result_verif_mail);
}


    //// Vérification de doublons de l'IP du serveur dans la BDD (table "servers")
    function serverVerif($serverIP)
{
    // Vérification de l'IP
    global $bdd;

    $req_verif_serverIP = $bdd->query("SELECT 1 FROM servers WHERE ip = '$serverIP'");

    $result_verif_serverIP = $req_verif_serverIP->fetch();

    return !empty($result_verif_serverIP);
}


    // Vérification de doublons du login du serveur dans la BDD (table "servers", utile?)
    function serverVerifLogin($serverLogin)
{
    // Vérification du login du serveur
    global $bdd;

    $req_verif_serverLogin = $bdd->query("SELECT 1 FROM servers WHERE login = 'login'");

    $result_verif_serverLogin = $req_verif_serverLogin->fetch();

    return !empty($result_verif_serverLogin);
}


// Avoir une date au format français, avec les jours, mois et années

// // Définir la date et l'heure de Paris :
// setlocale (LC_TIME, 'fr_FR.utf8','fra');
// date_default_timezone_set("Europe/Brussels");

// // Méthode pour avoir tous les jours et mois en français :
// $jour = array("Dimanche","Lundi","Mardi","Mercredi","Jeudi","Vendredi","Samedi");

// $mois = array("Janvier","Février","Mars","Avril","Mai","Juin","Juillet","Août","Septembre","Octobre","Novembre","Décembre");

// $dateFR = $jour[date("w")]." ".date("d")." ".$mois[date("n")]." ".date("Y");

// exemple d'utilisation :  $datefr . ' à ' . date('h:i:s')
 ?>
