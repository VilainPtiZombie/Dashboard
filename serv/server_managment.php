<?php
// On vérifie la présence des variables SESSION, elles sont créées si absentes
if(!isset($_SESSION)) {
        session_start();
}
// On s'assure de la présence de l'appel de la BDD
if(!isset($bdd)) {
	include('../back/bdd.php');
}

// Vérification que l'utilisateur existe en BDD et soit un admin
include('../verifs/user_verif_admin.php');

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
	<title>Gestion des serveurs</title>
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
	<section id="title_serv_managment" class="infos ml12p">
		<div class="col owcs_bg_color">
			<h2 class="ptxm pbxm tac">Gestion des serveurs</h2>
		</div>
	</section>
	<section id="serv_managment" class="ml12p">
		<div class="container-fluid">
			<div class="row mtl">
				<div class="col-lg-6">
				<h3 class="tac">Liste des serveurs en activité :</h3>
				<div class="row	mtm">
					<div class="col table-header"><p>ID serveur</p></div>
					<div class="col table-header"><p>Adresse IP</p></div>
					<div class="col table-header"><p>Dernière action</p></div>
				</div>
					<div class="serv_managment">
						<table class="table table-hover server_table" id="servers_table">
							<tbody>
		<?php
		// Préparation de la requête pour sortir les infos serveurs de la table membres
		$req_view_servers = $bdd->query('SELECT * FROM servers ORDER BY id');
		while ($result_view_servers = $req_view_servers->fetch()) {

			// On sécurise les données
			$result_view_servers['id'] = intval($result_view_servers['id']);
			$result_view_servers['ip'] = htmlspecialchars($result_view_servers['ip']);
			?>

								<tr>
									<td><?php echo $result_view_servers['id']; ?></td>
									<td><?php echo $result_view_servers['ip']; ?></td>
									<td><?php echo $result_view_servers['date_last_action']; ?></td>

		<?php
		}
		// On repositionne le curseur
		$req_view_servers->closeCursor();
		 ?>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
				<div class="col-lg-6">
				<h3 class="tac">Liste des clients et leurs serveurs respectifs :</h3>
				<div class="row	mtm">
					<div class="col table-header"><p>ID client</p></div>
					<div class="col table-header"><p>Entreprise</p></div>
					<div class="col table-header"><p>IP serveur</p></div>
				</div>
						<div class="ip_managment">
							<table id="servTable" class="table table-hover">
							<tbody>
		<?php
		// Préparation de la requête pour sortir les infos serveurs de la table membres
		$req_view_serv = $bdd->query('SELECT id, entreprise, serverIP FROM membres GROUP BY entreprise ORDER BY id');


		// On sort puis affiche les données avec une boucle WHILE et un FETCH
		while ($result_view_serv = $req_view_serv->fetch()) {

			
			// Sécurisation des données
			$result_view_serv['id'] = intval($result_view_serv['id']);
			$result_view_serv['entreprise'] = htmlspecialchars($result_view_serv['entreprise']);
			$result_view_serv['serverIP'] = htmlspecialchars($result_view_serv['serverIP']);
			?>

								<tr>
									<td><?php echo $result_view_serv['id']; ?></td>
									<td><?php echo $result_view_serv['entreprise']; ?></td>
									<td><?php echo $result_view_serv['serverIP']; ?></td>

		<?php
		}
		// Repositionnement du curseur
		$req_view_serv->closeCursor();
		
	//}
		 ?>
								</tr>
							</tbody>
						</table>
					</div>
					<input type="text" id="servSearch" onkeyup="searchServ()" placeholder="Chercher dans la table" class="col search_input">
				</div>
			</div>
		</div>
	</section>
	<section id="server_managment_1" class="mtl ml12p">
		<div class="container-fluid">
			<div class="row">
				<div class="col-lg-6">
					<h3 class="tac">Ajouter un serveur à la BDD :</h3>
						<form action="add_server.php" method="POST" id="add_server_form" class="server_form mts">
							<input type="text" placeholder="Adresse IP du serveur" name="server_ip">
							<input type="text" placeholder="Login du serveur" name="server_login">
							<input type="password" placeholder="Mot de passe du serveur" name="server_pass">
							<input type="password" placeholder="Vérification du mot de passe" name="verif_server_pass">
							<input type="submit" name="btn_add_server" value="Ajouter le serveur" class="btn btn-primary">
						</form>
						<?php
							if (isset($_GET['success'])) {htmlspecialchars($_GET['success']); echo '<p class="centered_msg_php">Le serveur a été ajouté avec succès à la BDD.</p>';}
							if (isset($_GET['pass_error'])) {htmlspecialchars($_GET['pass_error']); echo '<p class="centered_msg_php">Les MDP ne correspondent pas</p>';}
							if (isset($_GET['empty'])) {htmlspecialchars($_GET['empty']); echo '<p class="centered_msg_php">Inscription du serveur effectuée avec succès.</p>';}
							if (isset($_GET['doubled'])) {htmlspecialchars($_GET['doubled']); echo "<p class='centered_msg_php'>Ce serveur est déjà enregistré dans la BDD.</p>";}
							if (isset($_GET['falseIP'])) {htmlspecialchars($_GET['falseIP']); echo "<p class='centered_msg_php'>L'adresse IP n'est pas au bon format.</p>";}
						 ?>
				</div>
				<div class="col-lg-6 serv_managment mtl_r1000">
					<h3 class="tac">Ajouter son serveur au client :</h3>
					<form action="add_user_server.php" method="POST" class="mts">
						<select name="user_to_add_to_server" class="col-lg-12">
						<?php
						// On prépare une requête pour sortir les noms et entreprises de tous les utilisateurs
						$req_view_users = $bdd->query('SELECT nom, entreprise FROM membres GROUP BY entreprise');

						// On fait une boucle WHILE pour sortir les infos
						while ($user_list = $req_view_users->fetch()) {

							// On sécurise les infos
							$user_list['nom'] = htmlspecialchars($user_list['nom']);
							$user_list['entreprise'] = htmlspecialchars($user_list['entreprise']);
						?>
							<option value="<?php echo $user_list['entreprise']; ?>">
								<?php echo $user_list['nom'] . ' - ' . $user_list['entreprise']; ?>
							</option>

						<?php
						}
						$req_view_users->closeCursor();
			 			?>
			 			</select>
			 			<select name="server_to_update" id="" class="col-lg-12">
			 		<?php
					// On prépare une requête pour sortir les serveurs
					$req_view_servers = $bdd->query('SELECT ip FROM servers');

					// On fait une boucle WHILE pour sortir les infos
					while ($result_view_servers = $req_view_servers->fetch()) {

						// On sécurise les infos
						// ERREUR $result_view_servers['ip'] = htmlspecialchars($req_view_servers['ip']);
						echo '<p class="centered_msg_php">' . $result_view_servers['ip'] . '</p>';
			 		 ?>

			 		 	<option value="<?php echo $result_view_servers['ip']; ?>">
			 		 		<?php echo $result_view_servers['ip']; ?>
			 		 	</option>
			 		<?php
					}
					$req_view_servers->closeCursor();
			 		?>
			 	</select>
			 	<input type="submit" value="Ajouter le client au serveur" class="btn btn-primary">
			</form>
			<?php
			if (isset($_GET['success_serv_update'])) {htmlspecialchars($_GET['success_serv_update']); echo '<p class="centered_msg_php">L\'adresse IP a bien été liée au client.</p>';}
			if (isset($_GET['fail_serv_update'])) {htmlspecialchars($_GET['fail_serv_update']); echo '<p class="centered_msg_php">Les MDP ne correspondent pas</p>';}
			 ?>
				</div>
				<?php echo $result_view_servers['ip']; ?>
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
</body>
</html>

