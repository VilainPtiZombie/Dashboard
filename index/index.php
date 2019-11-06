<?php
// On vérifie la présence des variables SESSION, elles sont créées si absentes
if(!isset($_SESSION)) {
        session_start();
}
// On s'assure de la présence de l'appel de la BDD
if(!isset($bdd)) {
	include('../back/bdd.php');
}

include('../verifs/user_verif.php');

include('../back/fonctions.php');

?>
<!DOCTYPE html>
<html lang="fr">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<link rel="stylesheet" href="../css/reset.css">
    <link rel="stylesheet" href="../css/normalize.min.css">
	<link href="https://use.fontawesome.com/releases/v5.0.8/css/all.css" rel="stylesheet">
	<link rel="stylesheet" href="../bootstrap/css/bootstrap-reboot.css">
	<link rel="stylesheet" href="../bootstrap/css/bootstrap-grid.css">
	<link rel="stylesheet" href="../bootstrap/css/bootstrap.css">
	<link rel="stylesheet" href="../css/style.css">
	<script src="../js/modernizr-2.8.3.min.js"></script>
	<title>Accueil dashboard</title>
</head>
<body>
	<section id="menu_section">
		<div class="container-fluid menu" id="menu">
			<div class="col-1">
				<h2>Dashboard <br> OWCS</h2>
				<nav>
					<ul>
						<li><a href="index.php">Accueil</a></li>
						<li><form action="" method="POST"><button name="deconnexion">Déconnexion</button></form></li>
						<?php 
						// Affichage des liens du menu de : déconnexion, backend, serveur et analytics
						include('../verifs/menu_buttons.php'); 
						?>
					</ul>
				</nav>
			</div>
		</div>
	</section>
	<div class="">
		<h1 class="tac ml12p">Bienvenue sur le dashboard client !</h1>
		<div id="mobile_menu">
			<a href="#mobile_menu"><i class="fas fa-bars fa-3x hidden" id="menu_icon"></i></a>
		</div>
	</div>
	<section id="section_1" class="infos ml12p">
		<div class="container-fluid">
			<div class="row">
				<div class="col-6">
					<p>Bonjour <?php echo $_SESSION['nom']; ?></p>
				</div>
				<div class="col-6">
					<p>Entreprise : <strong><?php echo $_SESSION['entreprise']; ?></strong></p>
				</div>
			</div>
			<div class="row">
				<div class="col-6">
					<p>Projet : <?php echo $_SESSION['projet']; ?></p>
				</div>
				<div class="col-6">
					<p>Avancement : <strong><?php echo $_SESSION['avancement']; ?></strong></p>
				</div>
			</div>
			<div class="row">
				<div class="drive_access">
					<a href="<?php echo $_SESSION['drive']; ?>" target="_blank">Accéder au drive</a>
				</div>
				<div class="drive_access">
					<a href="<?php echo $_SESSION['site']; ?>" target="_blank">Accéder au site</a>
				</div>
			</div>
		</div>
	</section>
	<section id="section_2" class="assistance mtxm ml12p reload_form">
		<div class="container-fluid">
			<div class="row">
				<div class="col-6 alerts">
					<h3>Vos alertes :</h3>
					<div class="new-alerts">
						<?php


						// Préparation puis execution de la requête (jointure entre table membres et alerts) => sélection des infos des deux tables puis jointure avec INNER JOIN et ON
						$req_alerts = $bdd->query('
							SELECT
								mbr.nom AS nom, mbr.entreprise AS entreprise,
								alrt.id AS alertID, alrt.objet_alert AS objet_alert, alrt.msg_alert AS msg_alert, alrt.forID AS forID, alrt.fromID AS fromID, alrt.date_alert AS date_alert, alrt.done AS done
							FROM
								alerts AS alrt
							INNER JOIN membres AS mbr
							ON mbr.id = alrt.forID
							WHERE alrt.forID = "'. $_SESSION['id'] .'"');

						// On execute la requête
						$req_alerts->execute();

						// Préparation puis execution d'une requête pour sortir le nom de l'expediteur
						$req_alert_sender = $bdd->query(
							'SELECT mbr.nom AS senderName, mbr.entreprise AS senderEntreprise, alrt.fromID as senderID
							FROM alerts alrt
							INNER JOIN membres AS mbr
							ON mbr.id = alrt.fromID');

						// On affiche les données avec une boucle WHILE et un FETCH
						while ($result_alerts = $req_alerts->fetch() AND $result_alert_sender = $req_alert_sender->fetch()) {

							// On sécurise les données
							$result_alerts['nom'] = htmlspecialchars($result_alerts['nom']);
							$result_alerts['entreprise'] = htmlspecialchars($result_alerts['entreprise']);
							$result_alerts['alertID'] = intval($result_alerts['alertID']);
							$result_alerts['objet_alert'] = htmlspecialchars($result_alerts['objet_alert']);
							$result_alerts['msg_alert'] = htmlspecialchars($result_alerts['msg_alert']);
							$result_alerts['forID'] = intval($result_alerts['forID']);
							$result_alerts['fromID'] = intval($result_alerts['fromID']);
							$result_alerts['done'] = htmlspecialchars($result_alerts['done']);
							$result_alert_sender['senderName'] = htmlspecialchars($result_alert_sender['senderName']);
							$result_alert_sender['senderEntreprise'] = htmlspecialchars($result_alert_sender['senderEntreprise']);

							// On stocke ces données dans des variables
							$alertID = $result_alerts['alertID'];
							$alert_object = $result_alerts['objet_alert'];
							$alert_msg = $result_alerts['msg_alert'];
							$alert_date = $result_alerts['date_alert'];
							$_SESSION['done'] = $result_alerts['done'];
							$done_alert = $result_alerts['done'];
							$for = $result_alerts['forID'];
							$fromID = $result_alerts['fromID'];
							$from = $result_alert_sender['senderName'] . ' - ' . $result_alert_sender['senderEntreprise'];


							// Si le résultat de la variable est DONE
							if ($result_alerts['done'] == 'DONE') {

								// Le bouton se tranforme en Annuler
								$btn_submit_alert = "Annuler";
							}

							// Comme au dessus avec NO, bouton devient C'est fait !
							if ($result_alerts['done'] == 'NO') {
								$btn_submit_alert = "C'est fait !";
							}
						 ?>
						 <div class="alert_box mtxm">

						 		<!-- On affiche les infos de la boucle -->
								<p class="mtxs alert_object"><strong><?php echo $alert_object . '</strong>, <i>envoyé par</i> ' . $from . ' <i>le</i> ' . $alert_date; ?></p>
								<p class="alert_msg"><?php echo $alert_msg; ?></p>
								<form action="alert_validation.php" method="POST" id="alert_validation_form" class="">
									<!-- <input type="hidden" name="alert_done_date" value="<?php echo date('Y-m-d H:i:s'); ?>"> -->
									<input type="hidden" name="validatorID" value="<?php echo $_SESSION['id']; ?>">
									<input type="hidden" name="checked" id="checked" class="checked" value="<?php echo $done_alert; ?>">
									<input type="hidden" name="alertID" value="<?php echo $alertID; ?>">
									<!-- <input type="hidden" name="priority_level" id="priority_level" class="priority_level" value="<?php echo $result_alerts['priority_level']; ?>"> -->
									<input type="checkbox" name="alert_validation" class="alert_validation"><input type="submit" value="<?php echo $btn_submit_alert; ?>" name="alert_validation_2" class="btn btn-primary alert_validation_2">
								</form>
							</div>
						<?php
						}
						// On réinisialise le curseur
						$req_alerts->closeCursor();
 						?>
					</div>
				</div>
				<div class="col-6 assistance">
					<?php

					// Préparation puis execution de la requête pour sortir les IDs des entreprises OWCS ou ADMIN
					$req_owcs_ids = $bdd->prepare('SELECT id FROM membres WHERE entreprise = "OWCS" OR type = "Administrateur"');
					$req_owcs_ids->execute();

					 ?>
					<h2>Besoin d'aide ?</h2>
					<p class="mts">Envoyez-nous votre question via le minichat, nous vous répondrons au plus vite.</p>
					<form action="" method="POST" class="mts">
						<?php include('minichat_post.php'); ?>
						<input type="hidden" name="date_msg_minichat" value="<?php echo date('d-m-Y H:i'); ?>">
						<input type="hidden" name="authorID_msg_minichat" value="<?php echo $_SESSION['id']; ?>" >
						<input type="hidden" name="author_msg_minichat" value="<?php echo $_SESSION['entreprise']; ?>" >
						<input type="hidden" name="for_user" value="OWCS" >
						<textarea name="message_minichat" placeholder="Votre message"></textarea>
						<input type="submit" value="Envoyer" name="submit_btn" class="btn btn-primary">
						<p class="msg_php mtxs"><?php if (isset($msg_minichat_post)) {echo $msg_minichat_post;} ?></p>
					</form>
					<h4 class="tac mtxm">Derniers messages :</h4>

					<div class="row	mtxm">
						<div class="col table-header"><p>Envoyé par</p></div>
						<div class="col table-header"><p>Message</p></div>
						<div class="col table-header"><p>Date du message</p></div>
					</div>
					<div class="minichat_message table table-hover" id="reload">
						<table>
							<tbody>
						<?php
						// Préparation puis execution de la requête d'affichage des messages du minichat (pour les clients)
						$req_view_minichat = $bdd->prepare('SELECT * FROM minichat_2 WHERE par = "'. $_SESSION['entreprise'] .'" AND pour = "OWCS" OR pour = "'. $_SESSION['entreprise'] .'" ORDER BY date_message DESC');
						$req_view_minichat->execute();

						// Condition : si l'entreprise ne s'appelle pas OWCS
						if ($_SESSION['entreprise'] != "OWCS") {

							// Affichage des données à l'aide d'une boucle WHILE
							while ($result_view_minichat = $req_view_minichat->fetch()) {

								// Sécurisation des données
								$result_view_minichat['par'] = htmlspecialchars($result_view_minichat['par']);
								$result_view_minichat['pour'] = htmlspecialchars($result_view_minichat['pour']);
								$result_view_minichat['message'] = htmlspecialchars($result_view_minichat['message']);
								$result_view_minichat['date_message'] = htmlspecialchars($result_view_minichat['date_message']);
							?>

								<tr>
									<td><strong><?php echo $result_view_minichat['par']; ?></strong></td>
									<td><?php echo $result_view_minichat['message']; ?></td>
									<td><?php echo $result_view_minichat['date_message']; ?></td>
								</tr>

						 <?php
							}
							// Reposionnement du curseur
							$req_view_minichat->closeCursor();
						}

							// Préparation puis execution de la requête d'affichage de tous les messages du minichat (pour OWCS)
							$req_view_all_minichat = $bdd->query('SELECT * FROM minichat_2 WHERE pour = "OWCS" OR par = "OWCS" ORDER BY date_message DESC');
							$req_view_all_minichat->execute();

							// Condition : si l'entreprise s'appelle OWCS et que c'est un ADMIN
							if ($_SESSION['entreprise'] == "OWCS" AND $_SESSION['type'] == "Administrateur") {

							// On sort puis affiche les données avec un WHILE et FETCH
							while ($result_view_all_minichat = $req_view_all_minichat->fetch()) {

							?>
								<tr>
									<td><strong><?php echo $result_view_all_minichat['par']; ?></strong></td>
									<td><?php echo $result_view_all_minichat['message']; ?></td>
									<td><?php echo $result_view_all_minichat['date_message']; ?></td>
								</tr>

						<?php
							}
							// Reposionnement du curseur
							$req_view_all_minichat->closeCursor();
						}
						// var_dump($req_view_minichat); echo $req_view_minichat;
						?>




						</tbody>
					</table>
					</div>
				</div>
			</div>
		</div>
	</section>
<script
  src="http://code.jquery.com/jquery-3.3.1.min.js"
  integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
  crossorigin="anonymous"></script>
<script
  src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"
  integrity="sha256-VazP97ZCwtekAsvgPBSUwPFKdrwD3unUfSGVYrahUqU="
  crossorigin="anonymous"></script>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
<script>window.jQuery || document.write('<script src="js/vendor/jquery-1.11.2.min.js"><\/script>')</script>
<script defer src="https://use.fontawesome.com/releases/v5.0.6/js/all.js"></script>
<script src="../js/main.js"></script>
</body>
</html>
