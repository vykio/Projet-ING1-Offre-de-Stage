<?php 

//Définition du nom de la page à afficher via le fichier templates/header.php
$pagename = "Mon Profil";
define('PAGE_NAME', $pagename);

include('templates/short_links.php');
include('database.php');
include('src/classes/CLASS_login.php');

//La fonction isLoggedIn() de la classe Login, return l'id de l'utilisateur connecté
if (!Login::isLoggedIn()) {
	
	header('Location: ' . LOGIN_PAGE);
	die(); //On arrete tout et on n'execute pas le reste (évite les erreurs)
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
	<link rel="stylesheet" type="text/css" href="src/css/profile/profile.css">
</head>
<body>


	<!-- Image Derriere le header -->
	<div class="profile_header" style="background: url('imgs/login_3.jpg') no-repeat center center fixed; background-color: #EEEEEE;
		-webkit-background-size: cover;
		-moz-background-size: cover;
		-o-background-size: cover;
		background-size: cover;">
	</div>

	<div class="profile_header2">

		<div class="header_slogan">
				<img src="imgs/logo1.png" class="img_logo">
			</div>

	</div>	

	<!-- Div pour afficher les infos en haut à droite (voir home.css pour le modifier) -->
			<div class="header_information_utilisateur">
				<a href="<?php echo LOGOUT_PAGE ?>" style="color: white; text-decoration: none"  title="Déconnexion" >Déconnexion &emsp;<i class="fas fa-sign-out-alt"></i></a>
			</div>
	

	<div class="container main_container">
	<!-- Contenus de la page -->
		<!-- Utilisé pour créer la barre de navigation -->
		<nav class="nav_menu" role="navigation">
			<!-- Liste d'éléments <li> -->
		    <ul class="menu">
	    		<li><a href="<?php echo INDEX_PAGE ?>"><i class="fas fa-home"></i>&emsp;Accueil</a></li>
	    		<li class="menu_toggle_icon" id="menu_toggle_button"><a href="javascript:void(0);" onclick="menu_toggle_fn()"><i class="fas fa-bars"></i></a></li>
	  			<li class="menu_item"><a href="#">Mon espace</a></li>
	  			<li class="menu_item"><a href="#">Créer mon CV</a></li>
		    </ul>
		</nav>

		<div class="profile_container">
			<h1 class="profile_titre">	Mon Compte	</h1>
		</div>

	</div>

	


	<?php 
		include("templates/footer.php");
	?>

	<script type="text/javascript">
		//Fonction Javascript utilisé pour afficher ou non le menu en mode mobile
		function menu_toggle_fn() {
			var menu_toggle_btn = document.getElementsByClassName("menu_item");
			for (i = 0; i < menu_toggle_btn.length; i++) {
				if (menu_toggle_btn[i].style.display != "block") {
					menu_toggle_btn[i].style.display = "block";
				} else {
					menu_toggle_btn[i].style.display = "";
				}
			}
			
		}
		
	</script>

</body>
</html>