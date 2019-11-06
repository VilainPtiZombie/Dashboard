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
<html lang="en">
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
	<title>Document</title>
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
	<section class="ml12p">
		<div class="container-fluid">
			<h3 class="tac mtxm mbm">Tous les graphiques sont mis à jour tous les soirs, entre 23h et minuit.</h3>
			<div class="row">
				<div class="graph col-xl-6 tac mtxm">
<?php 
// Affichage du graph 'Nombre de visiteurs'
$req_analytics_userNb = $bdd->prepare('SELECT userNb FROM analytics WHERE clientsID = "'. $_SESSION['id'] .'"');
$req_analytics_userNb->execute();
$userNb_graph = $req_analytics_userNb->fetch();
echo $userNb_graph['userNb'];
?>
				</div>
				<div class="graph col-xl-6 tac mtxm">
<?php 
// Affichage du graph 'Nombre de sessions'
$req_analytics_sessionNb = $bdd->prepare('SELECT sessionNb FROM analytics WHERE clientsID = "'. $_SESSION['id'] .'"');
$req_analytics_sessionNb->execute();
$sessionNb_graph = $req_analytics_sessionNb->fetch();
echo $sessionNb_graph['sessionNb'];
?>
				</div>
			</div>
			<div class="row">
				<div class="graph col-xl-6 tac mtxm">
<?php 
// Affichage du graph 'Taux de rebond'
$req_analytics_bounceRate = $bdd->prepare('SELECT bounceRate FROM analytics WHERE clientsID = "'. $_SESSION['id'] .'"');
$req_analytics_bounceRate->execute();
$bounceRate_graph = $req_analytics_bounceRate->fetch();
echo $bounceRate_graph['bounceRate'];

?>
					<p>Le taux de rebond correspond au pourcentage d'utilisateurs qui viennent sur le site et le quitte directement.</p>
				</div>
				<div class="graph col-xl-6 tac mtxm">
<?php 
// Affichage du graph 'Durée moyenne des sessions'
$req_analytics_sessionDuration = $bdd->prepare('SELECT sessionDuration FROM analytics WHERE clientsID = "'. $_SESSION['id'] .'"');
$req_analytics_sessionDuration->execute();
$sessionDuration_graph = $req_analytics_sessionDuration->fetch();
echo $sessionDuration_graph['sessionDuration'];

?>
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


<!-- 
Créer table analytics (1 champ par graph)
	-> chaque champ contenant le code à l'intérieur de l'iframe
	-> liée à table membres par ID

Créer formulaire pour ajouter les codes des graphs (partie admin)
	-> placer le code situé à l'intérieur des balises iframe (sans les balises)
	-> ficher 'add_analytics.php' fera l'ajout en BDD (en prenant l'ID du client sélectionné par le select)

A l'ajout d'un client dans la BDD, ajouter aussi son ID dans clientsID (table analytics)
Utiliser UPDATE pour ajouter les valeurs (NULL par défaut) de la table analytics
	-> les valeurs doivent êtres sécurisées avec htmlspecialchars lors de l'ajout en BDD, mais pas pour l'affichage ?????

Affichage des graphs par jointure avec table membres


Créer SESSIONS contenant le code des graphs

Table analytics :
	-> id
	-> clientsID
	-> userNb
	-> sessionNb
	-> reboundRate (quand un user se connecte et se déco directement -> haut taux de rebond)
	-> sessionDuration

 -->