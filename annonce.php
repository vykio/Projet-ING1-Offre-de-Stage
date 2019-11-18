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
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<?php
	//Import de header.php qui contient tous les codes de liens CSS, et le titre de la page défini par la variable PAGE_NAME
	include('templates/header.php');
	?>
	<!-- CSS custom pour la page login (non utilisé par les autres pages -->
	<link rel="stylesheet" type="text/css" href="src/css/annonce/annonce.css">

</head>

<body>
	<div class="header" style="background: url('imgs/login_3.jpg') no-repeat center left fixed; background-color: #EEEEEE;
		-webkit-background-size: cover;
		-moz-background-size: cover;
		-o-background-size: cover;
		background-size: cover;">
	</div>

	
</body>

<div class="home_header">
		


		<!-- Class Container de SKELETON CSS et searchContainer de src/css/home/home.css -->
		<div class="container searchContainer">
			
			<!-- Slogan pour le site -->
			<div class="header_slogan">
				<img src="imgs/logo1.png" class="img_logo">
			</div>

			<?php include('templates/find.php'); ?>

		</div>

		<!-- Div pour afficher les infos en haut à droite (voir home.css pour le modifier) -->
			<div class="header_information_utilisateur">
				<div class="row">
					<?php echo $user['username'] ?> (<?php echo $user['email'] ?>)
				</div>
				
				<a href="<?php echo LOGOUT_PAGE ?>" style="color: white; text-decoration: none" title="Déconnexion" >Déconnexion &emsp;<i class="fas fa-sign-out-alt"></i></a>
			</div>

		
	</div>

		<div class="container main_container">
			<!-- Contenus de la page -->

			<!-- Utilisé pour créer la barre de navigation -->
			<nav class="nav_menu" role="navigation">
				<!-- Liste d'éléments <li> -->
			    <ul class="menu">
	  		  		<li><a href="<?php echo INDEX_PAGE ?>"><i class="fas fa-home"></i>&emsp;Accueil</a></li>
	    			<li class="menu_toggle_icon" id="menu_toggle_button"><a href="javascript:void(0);" onclick="menu_toggle_fn()"><i class="fas fa-bars"></i></a></li>
	  				<li class="menu_item"><a href="#">Catégories</a></li>
		      	  <li class="menu_item"><a href="#">À Propos</a></li>
		      	  <li class="menu_item"><a href="#"><i class="far fa-user"></i>&emsp;Mon profil</a></li>
		  	  </ul>
			</nav>
	



		<div class="annonce_container" onclick="location.href='<?php echo ANNONCE_PAGE . "?id=" . $annonce["id"] ?>'">
						<div class="annonce_inner_container">
							<div class="annonce_titre">
								<a href="<?php echo ANNONCE_PAGE . "?id=" . $annonce["id"] ?>"> <!-- LIEN OFFRE référencé par l'id de l'annonce -->
								<?php echo $annonce["titre"] ?>
								</a>
							
							</div>
							<div class="row">
								<div class="annonce_entreprise four columns"><?php echo $annonce["entreprise"] ?></div>
								<div class="annonce_location three columns"><span>&#128204 </span><?php echo $annonce["ville"] ?></div>
								<div class="annonce_duree five columns"><?php echo $annonce["duree"] ?> mois</div>
							</div>
						
							<div class="annonce_description">
								<!-- La requete SQL doit nous donner que les 100 premiers caractères de la description, et nous n'afficerons que les 100 premiers caractères -->
								<span style="white-space: pre-line;"><?php
									echo $annonce["description"];
								?></span>
							
							</div>
						</div>
		</div>
	</div>


</html>



