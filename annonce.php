<?php 

$pagename = "Annonce";
define('PAGE_NAME', $pagename);

include('templates/short_links.php');
include('database.php');
include('src/classes/CLASS_login.php');

if (Login::isLoggedIn()) {
	$user = database::query('SELECT username, email, first_name, last_name FROM utilisateurs WHERE id=:id', array(':id'=>Login::isLoggedIn()))[0];
} else {
	header('Location: ' . LOGIN_PAGE);
	die(); 
}



if (isset($_GET['id']) && !empty($_GET['id'])) {
	$requested_id = $_GET['id'];
	$requested_id = filter_var($requested_id, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);

	if (database::query("SELECT * from annonces WHERE id=:id", array(':id'=>$requested_id))) {

		$annonce = database::query("SELECT * from annonces WHERE id=:id", array(':id'=>$requested_id))[0];

		// echo "<span style=\"white-space: pre-line;\">" . $annonce["description"] ."</span>";

	} else {

		header('Location: ' . LOGIN_PAGE);
		die(); 


	}

} else {

	header('Location: ' . LOGIN_PAGE);
	die(); 

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
	<link rel="stylesheet" type="text/css" href="src/css/annonce/annonce.css">
	
</head>

<body>


	<!-- Image Derriere le header -->
	<div class="header" style="background: url('imgs/login.jpg') no-repeat center center fixed; background-color: #EEEEEE;
		-webkit-background-size: cover;
		-moz-background-size: cover;
		-o-background-size: cover;
		background-size: cover;">
	</div>

	<div class="container main_container">
		<!-- Contenus de la page -->

		<!-- Utilisé pour créer la barre de navigation -->
		<nav class="nav_menu" role="navigation">
			<!-- Liste d'éléments <li> -->
		    <ul class="menu">
	    		<li><a href="<?php echo INDEX_PAGE ?>"><i class="fas fa-home"></i>&emsp;Accueil</a></li>
	    		<li class="menu_toggle_icon" id="menu_toggle_button"><a href="javascript:void(0);" onclick="menu_toggle_fn()"><i class="fas fa-bars"></i></a></li>
		        <li class="menu_item"><a href="#">À Propos</a></li>
		        <li class="menu_item"><a href="#"><i class="far fa-user"></i>&emsp;Mon profil</a></li>
		    </ul>
		</nav>

		<!-- Div pour afficher les infos en haut à droite (voir home.css pour le modifier) -->
		<!-- 	<div class="header_information_utilisateur">
				<div class="row">
					<?php echo $user['username'] ?> (<?php echo $user['email'] ?>)
				</div>
				
				<a href="<?php echo LOGOUT_PAGE ?>" style="color: white; text-decoration: none" title="Déconnexion" >Déconnexion &emsp;<i class="fas fa-sign-out-alt"></i></a>
			</div> -->
 


	<!-- <div class="annonce_titre"> 
		 <span class= six columns> <b> <?php echo $annonce["titre"] ?> </b> </span>
	</div>
	<div class ="annonce_description">
		 <?php echo "<span class=\"six columns;\" style=\"white-space: pre-line;\"> <b>" . $annonce["description"] . "</b> </span>";?>
	</div> -->
</body>
</html>
