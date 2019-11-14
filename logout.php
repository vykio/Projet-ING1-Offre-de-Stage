<?php 

//Définition du nom de la page à afficher via le fichier templates/header.php
$pagename = "Déconnexion";
define('PAGE_NAME', $pagename);

include('templates/short_links.php');
include('database.php');
include('src/classes/CLASS_login.php');

//La fonction isLoggedIn() de la classe Login, return l'id de l'utilisateur connecté
if (!Login::isLoggedIn()) {
	
	header('Location: ' . LOGIN_PAGE);
	die(); //On arrete tout et on n'execute pas le reste (évite les erreurs)
}

if (isset($_POST['confirm'])) {
	if (isset($_POST['alldevices'])){
		database::query('DELETE FROM login_tokens WHERE user_id=:userid', array(':userid'=>Login::isLoggedIn()));
	} else {
		if (isset($_COOKIE['ppwid'])){ 
			database::query('DELETE FROM login_tokens WHERE token=:token', array(':token'=>hash('sha256', $_COOKIE['SFID'])));
		}
	}
	setcookie("SFID", '1', time()-3600, '/', NULL, NULL, TRUE);
	setcookie("SFID_verif", '1', time()-3600, '/', NULL, NULL, TRUE);
	//echo "<meta http-equiv='refresh' content='0'>";
	header('Location: ' . LOGIN_PAGE);
}
?>

<!DOCTYPE html>
<html>
<head>
	<?php
	//Import de header.php qui contient tous les codes de liens CSS, et le titre de la page défini par la variable PAGE_NAME
	include('templates/header.php');
	?>


	<!-- Fichier uniquement importé pour la page d'accueil donc pas dans le fichier générique -->
	<link rel="stylesheet" type="text/css" href="src/css/home/home.css">
</head>
<body>

	<!-- Image Derriere le header -->
	<div class="header" style="background: url('imgs/login_3.jpg') no-repeat center center fixed; background-color: #EEEEEE;
		-webkit-background-size: cover;
		-moz-background-size: cover;
		-o-background-size: cover;
		background-size: cover;">
	</div>

<div class="container main_container">
	<center>
	<h1>Déconnexion</h1>
	<p>Voulez-vous vous déconnecter ?</p>

	<form action="logout.php" method="post">
		<input type="checkbox" name="alldevices" checked> Se déconnecter de tous les appareils?<br /><br>
		<input type="submit" name="confirm" value="Confirmer" class="button-primary">
	</form>
	</center>
</div>

<?php 
	include("templates/footer.php");
?>


</body>
</html>