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

$user = database::query('SELECT username, email, first_name, last_name, account_type FROM utilisateurs WHERE id=:id', array(':id'=>Login::isLoggedIn()))[0];

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
	<link rel="stylesheet" type="text/css" href="src/css/global/global_register_login.css">

	<link rel="stylesheet" type="text/css" href="src/css/login/login.css">
</head>
<body>

<div class="header" style="background: url('imgs/login.jpg') no-repeat center center fixed; background-color: #EEEEEE;
	-webkit-background-size: cover;
	-moz-background-size: cover;
	-o-background-size: cover;
	background-size: cover;">
</div>

	
<!-- Container centré et réduit par Skeleton.css et re-réduit par la classe CSS "login" -->
<div class="container login" style="border: 0px solid black">

	
	<!-- div blanche sur le site contenant la form -->
	<div class="super">

		<!-- Logo pour le site -->
		<div class="logo">
			<a href="<?php echo INDEX_PAGE ?>"><img src="imgs/logo1.png" class="img_logo"></a>
		</div>
		<center>
			<h1>Déconnexion de</h1>
			<?php
			$gravatar_email = $user["email"];
			$gravatar_default = "https://moonvillageassociation.org/wp-content/uploads/2018/06/default-profile-picture1.jpg";
			$gravatar_size = 100;
			$gravatar_url = "https://www.gravatar.com/avatar/" . md5( strtolower( trim( $gravatar_email ) ) ) . "?d=" . urlencode( $gravatar_default ) . "&s=" . $gravatar_size;
			?>
			<img src="<?php echo $gravatar_url; ?>" style="width: 150px; border-radius: 50%;" alt="" />
			<br>
			<span style="font-size: 1.5em;"><?php echo $user["first_name"] . " " . $user["last_name"]?></span>
			<hr>

			<form action="<?php echo LOGOUT_PAGE ?>" method="post">
				<input type="checkbox" name="alldevices" checked> Se déconnecter de tous les appareils?<br /><br>
				<input type="submit" name="confirm" value="Se déconnecter" class="button-primary">
			</form>
		</center>
	</div>

</div>

<?php 
	include("templates/footer.php");
?>


</body>
</html>