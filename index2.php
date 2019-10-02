<?php 

//Définition du nom de la page à afficher via le fichier templates/header.php
$pagename = "Accueil";
define('PAGE_NAME', $pagename);

?>

<?php 

/* Variables test (A SUPPRIMER) */
$username_test = "Jante Paul"; //Prénom Nom Etudiant test
$username_id_etu_test = "17003678"; //Numéro étudiant test

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
	<div class="header" style="background: url('imgs/login.jpg') no-repeat center center fixed; background-color: #EEEEEE;
		-webkit-background-size: cover;
		-moz-background-size: cover;
		-o-background-size: cover;
		background-size: cover;">
	</div>

	<!-- Header (contenant la barre de recherche et quelques boutons) -->
	<div class="home_header">
		
		<!-- Class Container de SKELETON CSS et searchContainer de src/css/home/home.css -->
		<div class="container searchContainer">
			<!-- Div pour afficher les infos en haut à droite (voir home.css pour le modifier) -->
			<div class="header_information_utilisateur">
				Bonjour, <?php echo $username_test ?> (n°<?php echo $username_id_etu_test ?>)
			</div>

			<!-- Slogan pour le site -->
			<div class="header_slogan">
				Vous recherchez un stage ?<br>Ce site est fait pour vous
			</div>

			<!-- class="row" de SKELETON CSS permet d'avoir sur la meme ligne la textbox et le bouton rechercher.
			Si l'écran est trop petit, (< 400 ou 500px) le bouton passe en dessous. Pour avoir un design plus fluide et
			beau pour les utilisateurs mobiles -->
			<div class="row">
				<!-- Dans SKELETON CSS on peut diviser les lignes en colonnes en spécifiant pour chaque élément, la place qu'il va prendre 
				sur 12. Par exemple, ici on a dit que la textbox doit prendre 8 colonnes (class "eight columns") sur 12. Et 4 / 12 pour le bouton.
				 -->
				<input type="text" name="searchBox" placeholder="Rechercher un stage par mots clés ..." class="eight columns home_header_searchbox">
				<input type="button" name="clickSearchBox" value="&#10095; Recherche" class="four columns button-primary" style="font-size: 1.2rem;">
			</div>
			
		</div>
		
	</div>
	<div class="container">
		<!-- Contenus de la page -->
		ok
	</div>

</body>
</html>