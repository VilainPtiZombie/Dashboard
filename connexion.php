<?php
if (!isset($_SESSION)) {
        session_start();
}
if (!isset($bdd)) {
	include('back/bdd.php');
}
 ?>
<!DOCTYPE html>
<html lang="fr">
<head>
	<meta charset="UTF-8">
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<link rel="stylesheet" href="css/reset.css">
	<link rel="stylesheet" href="css/normalize.min.css">
	<link href="https://use.fontawesome.com/releases/v5.0.8/css/all.css" rel="stylesheet">
	<link rel="stylesheet" href="bootstrap/css/bootstrap-reboot.css">
	<link rel="stylesheet" href="bootstrap/css/bootstrap-grid.css">
	<link rel="stylesheet" href="bootstrap/css/bootstrap.css">
	<link rel="stylesheet" href="css/style.css">
	<title>Page de connexion dashboard ONLYWEB</title>
</head>
<body>
	<section id="connexion">
		<h1 class="tac">Dashboard ONLYWEB</h1>
		<div class="container-fluid">
			<div class="row">
				<div class="col-lg-12 tac">
					<form action="" method="POST" class="form">
						<input type="text" placeholder="Votre login" name="username">
						<input type="password" placeholder="Votre mot de passe" name="mdp">
						<input type="submit" value="Se connecter" class="btn btn-primary mtxs">
					</form>
					<?php include('traitement_connexion.php'); ?>
					<p class="msg_php mtmx"><?php echo $connexion_msg; ?></p>
				</div>
			</div>
		</div>
	</section>
</body>
</html>
