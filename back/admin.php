<?php

if(!isset($_SESSION)) {
session_start();
}

if (!isset($bdd)) {
	include('bdd.php');
}

// Vérification que l'utilisateur existe en BDD et soit un admin
include('../verifs/user_verif_admin.php');
 ?>
<!DOCTYPE html>
<html lang="fr">
	<head>
		<meta charset="UTF-8">
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
		<link rel="stylesheet" href="../css/reset.css">
		<link rel="stylesheet" href="../css/normalize.min.css">

		<link href="https://use.fontawesome.com/releases/v5.0.8/css/all.css" rel="stylesheet">
		<link rel="stylesheet" href="../bootstrap/css/bootstrap-reboot.css">
		<link rel="stylesheet" href="../bootstrap/css/bootstrap-grid.css">
		<link rel="stylesheet" href="../bootstrap/css/bootstrap.css">
		<link rel="stylesheet" href="../css/style.css">

		<title>Dashboard ONLYWEB / Back-end</title>
	</head>
	<body>
		<section id="menu_section">
		<div class="container-fluid menu" id="menu">
			<div class="col-1">
				<h2>Dashboard <br> OWCS</h2>
				<nav>
					<ul>
						<li><a href="../index/index.php">Accueil</a></li>
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
		<section id="section_admin_1" class="mtxm ml12p">
			<div class="container-fluid">
				<div class="row">
					<div class="col-lg-6 mtl_r">
						<h3 class="tac_r">Ajouter un nouvel utilisateur :</h3>
						<form action="" method="POST" class="mts" autocomplete="on">
							<input type="text" placeholder="Nom" name="username">
							<input type="text" placeholder="Entreprise" name="entreprise">
							<input type="text" placeholder="Adresse email" name="mail">
							<input type="tel" placeholder="Contact téléphonique" name="numero_tel">
							<input type="password" placeholder="Mot de passe" name="mdp">
							<input type="password" placeholder="Vérification du mot de passe" name="mdp_verif" autocomplete="off">
							<input type="text" placeholder="Projet" name="projet">
							<input type="text" placeholder="Avancement" name="avancement">
							<input type="url" placeholder="URL Drive" name="drive">
							<input type="url" placeholder="URL site" name="site">
							<input type="text" placeholder="IP serveur" name="serverIP">
							<select name="type">
								<option value="Client">Client</option>
								<option value="Administrateur">Administrateur</option>
							</select>
							<input type="submit" value="Ajouter" class="btn btn-primary">
							<?php include('add_user.php'); ?>
							<p class="centered_msg_php"><?php echo $message_connexion; ?></p>
						</form>
					</div>
					<div class="col-lg-6 mtl_r">
						<div class="">
						<h3 class="tac_r mbs">Liste des utilisateurs actuels :</h3><input type="text" id="userSearch" placeholder="Chercher dans la table" class="search_input col ">
						</div>
						<div class="row	mtxm">
							<div class="col table-header"><p>ID client</p></div>
							<div class="col table-header"><p>Type</p></div>
							<div class="col table-header"><p>Nom</p></div>
							<div class="col table-header"><p>Entreprise</p></div>
							<div class="col table-header"><p>Mail</p></div>
							<div class="col table-header"><p>Tel</p></div>
						</div>
						<div class="alerts_admin table table-hover server_table">
							<table id="userTable">
								<tbody>
									</tr>

							<?php
							// Préparation de la requête pour sortir tous les utilisateurs actuels
							$req_active_users = $bdd->query('SELECT id, nom, entreprise, mail, tel, type FROM membres ORDER BY ID');

							// On sort les données à l'aide d'une boucle et FETCH
							while ($donnees_active_users = $req_active_users->fetch()) {

								// On protège les données
								$donnees_active_users['id'] = intval($donnees_active_users['id']);
								$donnees_active_users['type'] = htmlspecialchars($donnees_active_users['type']);
								$donnees_active_users['nom'] = htmlspecialchars($donnees_active_users['nom']);
								$donnees_active_users['entreprise'] = htmlspecialchars($donnees_active_users['entreprise']);
								$donnees_active_users['mail'] = htmlspecialchars($donnees_active_users['mail']);
								$donnees_active_users['tel'] = htmlspecialchars($donnees_active_users['tel']);

								// On remplace "Administrateur" par ADMIN
								$donnees_active_users['type'] = preg_replace('#Administrateur#', 'ADMIN', $donnees_active_users['type']);

							 ?>

								<tr class="mts prxs">
									<td class="pts mls mrs"><?php echo $donnees_active_users['id'] ?></td>
									<td><?php echo $donnees_active_users['type'] ?></td>
									<td><?php echo $donnees_active_users['nom'] ?></td>
									<td><?php echo $donnees_active_users['entreprise'] ?></td>
									<td><?php echo $donnees_active_users['mail'] ?></td>
									<td><?php echo $donnees_active_users['tel'] ?></td>

							<?php
							}
							// On remet le curseur à zéro
							$req_active_users->closeCursor();
							?>
									</tr>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
			</section>
			<section id="section_3_admin">
				<div class="container-fluid">
					<div class="row ml12p">
						<div class="col-lg-6">
							<div class="row mtl">
								<div class="col-12 minichat_answer_form">
									<h3 class="tac_r mbs">Répondre aux questions sur le minichat :</h3>
									<form action="answer_minichat.php" method="POST" id="minichat_answer_form" class="mtxs">
										<select name="client_to_answer_minichat" class="mtxs">
											<?php $req_user_list = $bdd->query('SELECT id, nom, entreprise FROM membres');
											while ($user_list = $req_user_list->fetch()){
												$user_list['id'] = intval($user_list['id']);
												$user_list['nom'] = htmlspecialchars($user_list['nom']);
												$user_list['entreprise'] = htmlspecialchars($user_list['entreprise']);
											 ?>
											<option value="<?php echo $user_list['entreprise']; ?>"><?php echo $user_list['nom'] . ' - ' . $user_list['entreprise']; ?></option>
											<?php
											}
											$req_user_list->closeCursor();
											?>
										</select>
										<textarea name="answer_minichat" class="mtxs" placeholder="Votre message"></textarea>
										<input type="submit" value="Envoyer la réponse" class="mtxs btn btn-primary">
									</form>
								</div>

							</div>
						</div>
						<div class="col-lg-6 mtl mtl_r">
							<h3 class="tac_r">Alertes actuelles :</h3>
								<div class="row	mtxm">
									<div class="col table-header"><p>Envoyé pour</p></div>
									<div class="col table-header"><p>Objet alerte</p></div>
									<div class="col table-header"><p>Fait ?</p></div>
									<div class="col table-header"><p>Envoyé par</p></div>
									<div class="col table-header"><p>Le</p></div>
								</div>
								<div class="alerts_admin table table-hover server_table">
									<table>
										<tbody>

								<?php

								// Préparation de la jointure 1, qui sortira les données liées entre les tables membres et alerts
								$req_all_alerts = $bdd->query(
									'SELECT mbrs.nom, mbrs.entreprise,
									alts.objet_alert, alts.done, alts.fromID, alts.forID, alts.done, alts.date_alert
									FROM alerts AS alts
									INNER JOIN membres AS mbrs
									ON alts.forID = mbrs.id
									WHERE alts.id > 1');

								// Préparation de la jointure 2, qui sortira le nom lié à l'expéditeur
								$req_isFrom = $bdd->query('
									SELECT mbrs.nom AS nameFrom, mbrs.entreprise AS entrepriseFrom, alts.fromID
									FROM alerts AS alts
									INNER JOIN membres AS mbrs
									ON alts.fromID = mbrs.id');

								// On sort les données avec un WHILE et FETCH
								while ($result_all_alerts = $req_all_alerts->fetch() AND $result_isFrom = $req_isFrom->fetch()) {

									// On sécurise les données (jointure 1)
									$result_all_alerts['nom'] = htmlspecialchars($result_all_alerts['nom']);
									$result_all_alerts['entreprise'] = htmlspecialchars($result_all_alerts['entreprise']);
									$result_all_alerts['objet_alert'] = htmlspecialchars($result_all_alerts['objet_alert']);
									$result_all_alerts['done'] = htmlspecialchars($result_all_alerts['done']);
									$result_all_alerts['fromID'] = htmlspecialchars($result_all_alerts['fromID']);
									$result_all_alerts['date_alert'] = htmlspecialchars($result_all_alerts['date_alert']);

									// Jointure 2
									$result_isFrom['nameFrom'] = htmlspecialchars($result_isFrom['nameFrom']);
									$result_isFrom['entrepriseFrom'] = htmlspecialchars($result_isFrom['entrepriseFrom']);

									// On en fait des variables (celles de la jointure 1)
									$nom = $result_all_alerts['nom'];
									$entreprise = $result_all_alerts['entreprise'];
									$alert_object = $result_all_alerts['objet_alert'];
									$done = $result_all_alerts['done'];
									$date_alert = $result_all_alerts['date_alert'];

									// Constitution du receveur
									$isFor = $nom . ' - ' . $entreprise;

									// Variable jointure 2
									$nameFrom = $result_isFrom['nameFrom'];
									$entrepriseFrom = $result_isFrom['entrepriseFrom'];

									// Constitution de l'expéditeur
									$isFrom = $nameFrom . ' - ' . $entrepriseFrom;

								 ?>
								 <!-- Affichage des données dans le tableau -->
										<tr class="mts prxs">
											<td class="pts mls mrs"><?php echo $isFor; ?></td>
											<td><?php echo $alert_object; ?></td>
											<td><?php echo $done; ?></td>
											<td><?php echo $isFrom; ?></td>
											<td><?php echo $date_alert; ?></td>
											<!-- L'INPUT d'en dessous permet le fonctionnement du script Jquery pour le changement de couleurs si alerte validée -->
											<input type="hidden" name="checked_2" class="checked" value="<?php echo $done; ?>">
										<?php }
										$req_all_alerts->closeCursor(); ?>
										</tr>
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
			</section>
			<section id="section_admin_2" class="ml12p mtl_r tac">
				<div class="container-fluid">
					<div class="row">
						<div class="col-lg-12">
							<div class="row mtl">
								<div class="col update_buttons">
									<span class="span_infos"><a href="#menu1" id="btn_pass_update">Modif MDP</a></span>
								</div>
								<div class="col update_buttons">
									<span class="span_infos"><a href="#menu2" id="btn_update_user_info">Modif données</a></span>
								</div>
								<div class="col update_buttons">
									<span class="span_infos"><a href="#menu3" id="btn_alert_creator">Créer alerte</a></span>
								</div>
								<div class="col update_buttons">
									<span class="span_infos"><a href="#menu4" id="btn_update_contacts">Modif contact</a></span>
								</div>
								<div class="col update_buttons">
									<span class="span_infos"><a href="#menu5" id="btn_add_analytics">Analytics</a></span>
								</div>
							</div>
						</div>
					</div>
				</div>
			</section>
			<section id="pass_update" class="update_values tac ml12p active">
				<div class="container-fluid mtl pass_update">
					<div class="row">
						<div class="col-lg-12">
							<h3>Modification du mot de passe d'un utilisateur :</h3>
							<form action="update_mdp.php" method="POST" class="mtxs">
								<select name="client_pass_to_update" class="mtxs">
									<?php $req_user_list = $bdd->query('SELECT id, nom, entreprise FROM membres');
									while ($user_list = $req_user_list->fetch()){
										$user_list['nom'] = htmlspecialchars($user_list['nom']);
										$user_list['entreprise'] = htmlspecialchars($user_list['entreprise']);
									 ?>
									<option value="<?php echo $user_list['id']; ?>"><?php echo $user_list['nom'] . ' - ' . $user_list['entreprise']; ?></option>
									<?php
									}
									$req_user_list->closeCursor();
									?>
								</select>
								<div class="row mtxs">
									<div class="col-lg-4">
										<input type="password" placeholder="Ancien MDP" name="last_mdp">
									</div>
									<div class="col-lg-4">
										<input type="password" placeholder="Nouveau MDP" name="confirm_new_mdp">
									</div>
									<div class="col-lg-4">
										<input type="password" placeholder="Confirmation nouveau MDP" name="new_mdp">
									</div>
								</div>
								<div class="row mtxs">
									<div class="col-lg-12">
										<input type="submit" value="Modifier le mot de passe" class="btn btn-primary">
									</div>
								</div>
							</form>
						</div>
					</div>
				</div>
			</section>
			<section id="update_user_info" class="update_values tac ml12p">
				<div class="container-fluid mtl">
					<div class="row">
						<div class="col-lg-12">
							<h3>Modification des données client :</h3>
							<form action="update_user_info.php" method="POST" class="mtxs">
								<select name="clientID_to_update_user_info" class="mtxs">
									<?php $req_user_list = $bdd->query('SELECT id, nom, entreprise FROM membres');
									while ($user_list = $req_user_list->fetch()){
										$user_list['nom'] = htmlspecialchars($user_list['nom']);
										$user_list['entreprise'] = htmlspecialchars($user_list['entreprise']);
									 ?>
									<option value="<?php echo $user_list['id']; ?>">
										<?php echo $user_list['nom'] . ' - ' . $user_list['entreprise']; ?>
									</option>
									<?php
									}
									$req_user_list->closeCursor();
									?>
								</select>
								<div class="row mtxs">
									<div class="col-lg-4">
										<input type="text" placeholder="Projet" name="update_projet">
									</div>
									<div class="col-lg-4">
										<input type="text" placeholder="Avancement" name="update_avancement">
									</div>
									<div class="col-lg-4">
										<input type="text" placeholder="Drive" name="update_drive">
									</div>
								</div>
								<div class="row mtxs">
									<div class="col-lg-12">
										<input type="submit" value="Modifier les données" class="btn btn-primary">
									</div>
								</div>
							</form>
						</div>
					</div>
				</div>
			</section>
			<section id="alert_creator" class="update_values tac ml12p">
				<div class="container-fluid mtl">
					<div class="row">
						<div class="col-lg-12" id="creator_alert">
							<h3>Création d'alertes :</h3>
							<form action="alert_creator.php" method="POST" class="mtxs">
								<select name="clientID_to_alert" class="mtxs">
									<?php

									$dateStart = date('d-m-Y');
  									$dateExpired = date('d-m-Y', strtotime($dateStart. ' + 14 days'));
									$req_user_list = $bdd->query('SELECT id, nom, entreprise FROM membres');
									while ($user_list = $req_user_list->fetch()){
										$user_list['nom'] = htmlspecialchars($user_list['nom']);
										$user_list['entreprise'] = htmlspecialchars($user_list['entreprise']);
									 ?>
									<option value="<?php echo $user_list['id']; ?>"><?php echo $user_list['nom'] . ' - ' . $user_list['entreprise']; ?></option>
									<?php
									}
									$req_user_list->closeCursor();
									?>
								</select>
								<input type="text" placeholder="Objet de l'alerte" name="objet_alert" class="mtxs">
								<textarea name="msg_alert" placeholder="Alerte à envoyer à " class="mtxs col-lg-12"></textarea>
								<input type="hidden" class="expiration_date" name="expiration_date" value="<?php echo $dateExpired; ?>">
								<!-- <?php echo $dateExpired . ' ' . $dateStart; ?> -->
								<input type="submit" value="Envoyer l'alerte" class="mtxs btn btn-primary">
							</form>
						</div>
					</div>
				</div>
			</section>
			<section id="update_contacts" class="update_values tac ml12p">
				<div class="container-fluid mtl">
					<div class="row">
						<div class="col-lg-12">
							<h3>Modification des contacts d'un utilisateur :</h3>

							<form action="update_contacts.php" method="POST" class="mtxs">
								<select name="clientID_to_update_contacts" class="mtxs">
									<?php $req_user_list = $bdd->query('SELECT id, nom, entreprise FROM membres');
									while ($user_list = $req_user_list->fetch()){
										$user_list['nom'] = htmlspecialchars($user_list['nom']);
										$user_list['entreprise'] = htmlspecialchars($user_list['entreprise']);
									 ?>
									<option value="<?php echo $user_list['id']; ?>"><?php echo $user_list['nom'] . ' - ' . $user_list['entreprise']; ?></option>
											<?php
											}
											$req_user_list->closeCursor();
											?>
								</select>
								<div class="row mtxs">
									<div class="col-lg-4"><input type="text" placeholder="Modifier l'entreprise" name="update_entreprise"></div>
									<div class="col-lg-4"><input type="text" placeholder="Modifier l'adresse mail" name="update_mail"></div>
									<div class="col-lg-4"><input type="text" placeholder="Modifier le numéro de tel" name="update_tel"></div>
								</div>
								<div class="row mtxs">
									<div class="col-lg-12"><input type="submit" value="Modifier les contacts de l'entreprise" class="btn btn-primary"></div>
								</div>
							</form>
						</div>
					</div>
				</div>
			</section>
			<section id="add_analytics" class="update_values tac ml12p">
				<div class="container-fluid mtl">
					<div class="row">
						<div class="col-lg-12">
							<h3>Ajout de graphiques Google Analytics</h3>
							<p>Pour ajouter un graphique, placer le code la balise iframe du graph correspondant (sans les balises)</p>

							<form action="../analytics/add_analytics.php" method="POST" class="mtxs">
								<select name="clientID_to_add_analytics" class="mtxs">
									<?php $req_user_list = $bdd->query('SELECT id, nom, entreprise FROM membres');
									while ($user_list = $req_user_list->fetch()){
										$user_list['nom'] = htmlspecialchars($user_list['nom']);
										$user_list['entreprise'] = htmlspecialchars($user_list['entreprise']);
									 ?>
									<option value="<?php echo $user_list['id']; ?>"><?php echo $user_list['nom'] . ' - ' . $user_list['entreprise']; ?></option>
											<?php
											}
											$req_user_list->closeCursor();
											?>
								</select>
								<div class="row mtxs">
									<div class="col-lg-3"><input type="text" placeholder="Nombre de visiteurs" name="userNb"></div>
									<div class="col-lg-3"><input type="text" placeholder="Nombre de sessions" name="sessionNb"></div>
									<div class="col-lg-3"><input type="text" placeholder="Taux de rebond" name="bounceRate"></div>
									<div class="col-lg-3"><input type="text" placeholder="Durée moyenne des sessions" name="sessionDuration"></div>
								</div>
								<div class="row mtxs">
									<div class="col-lg-12"><input type="submit" value="Ajouter un/des graphiques" class="btn btn-primary"></div>
								</div>
							</form>
						</div>
					</div>
				</div>
			</section>
			<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <script>window.jQuery || document.write('<script src="js/vendor/jquery-1.11.2.min.js"><\/script>')</script>
    <script defer src="https://use.fontawesome.com/releases/v5.0.6/js/all.js"></script>
    <script
  src="http://code.jquery.com/jquery-3.3.1.min.js"
  integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
  crossorigin="anonymous"></script>
<script
  src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"
  integrity="sha256-VazP97ZCwtekAsvgPBSUwPFKdrwD3unUfSGVYrahUqU="
  crossorigin="anonymous"></script>
  <script src="//code.jquery.com/jquery-1.12.4.js"></script>
  <script src="//code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  <script src="../js/main.js"></script>
  <script src="../js/modernizr-2.8.3.min.js"></script>
		</body>
	</html>
