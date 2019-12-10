<?php 

$pagename = "Creation d'annonce";
define('PAGE_NAME', $pagename);

include('templates/short_links.php');
include('database.php');
include('src/classes/CLASS_login.php');

if (Login::isLoggedIn()) {
	$user = database::query('SELECT username, email, first_name, last_name, company_name FROM utilisateurs WHERE id=:id', array(':id'=>Login::isLoggedIn()))[0];
} else {
	header('Location: ' . LOGIN_PAGE);
	die(); 
}

if (isset($_POST["btnConfirmer"])) {
	$titre = $_POST["titre"];
	$ville = $_POST["ville"];
	$duree = $_POST["nbMois"];
	$description = $_POST["description"];
	$dateDebut = $_POST["dateDebut"];
	$categorie = $_POST["categorie"];
	$categorie = database::query("SELECT id FROM categorie_annonce WHERE Nom_url=:param", array(":param"=>$categorie))[0]["id"];

	// FAIRE VERIFICATION !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!

	database::query("INSERT INTO annonces VALUES (null, :titre, :description, :ville, :user_id, :entreprise, :duree, :numCategorie, 0, :dateDebut)", array(
		":titre"=>$titre,
		":description"=>$description,
		":ville"=>$ville,
		":user_id"=>Login::isLoggedIn(),
		":entreprise"=>$user["company_name"],
		":duree"=>$duree,
		":numCategorie"=>$categorie,
		":dateDebut"=>$dateDebut
	));

	header('Location: ' . INDEX_PAGE);
	exit();

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

	<link rel="stylesheet" type="text/css" href="src/css/creerannonce/creerannonce.css">

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
				<a href="<?php echo INDEX_PAGE ?>"><img src="imgs/logo1.png" class="img_logo"></a>
			</div>

			<?php include('templates/top.php'); ?>

		</div>

		<!-- Div pour afficher les infos en haut à droite (voir home.css pour le modifier) -->
			<div class="header_information_utilisateur">
				<div class="row">
					<?php echo $user['username'] ?> (<?php echo $user['email'] ?>)
				</div>
				
				<a href="<?php echo LOGOUT_PAGE ?>" style="color: white; text-decoration: none" title="Déconnexion" >Déconnexion &emsp;<i class="fas fa-sign-out-alt"></i></a>
			</div>

	</div>

<div class="container">
	
	<div class="main_container">
			<!-- Contenus de la page -->

			<!-- Utilisé pour créer la barre de navigation -->
			<nav class="nav_menu" role="navigation">
				<!-- Liste d'éléments <li> -->
			    <ul class="menu">
	  		  		<li><a href="<?php echo INDEX_PAGE ?>"><i class="fas fa-home"></i>&emsp;Accueil</a></li>
	    			<li class="menu_toggle_icon" id="menu_toggle_button"><a href="javascript:void(0);" onclick="menu_toggle_fn()"><i class="fas fa-bars"></i></a></li>
	  				<li class="menu_item"><a href="#">Catégories</a></li>
		      	  <li class="menu_item"><a href="<?php echo MYSPACE_PAGE ?>">Mon espace</a></li>
		      	  <li class="menu_item"><a href="#"><i class="far fa-user"></i>&emsp;Mon profil</a></li>
		  	  </ul>
			</nav>
	</div>



<div class= "postuler_buttom">

		<div class="annonce_titre">
			<h3> Création d'annonce</h3>
		</div>
		<form action="<?php echo CREERANNONCE_PAGE ?>" method="POST">
		
			<div class="row">
				<div class="u-full-width">
				  <label>Titre</label>
				  <input class="u-full-width" type="text" placeholder="Titre de l'annonce" name="titre">
				</div>	

			</div>

			<div class="row">
				<div class=" three columns">
				  <label>Lieux</label>
				  <input class="u-full-width" type="text" placeholder="Ville" name="ville">
				</div>	

				<div class=" three columns">
					<label>Date début</label>
					<input class="u-full-width" type="text" placeholder="AAAA-MM-JJ" name="dateDebut">
				</div>

				<div class=" three columns">
				  <label>Durée</label>
				  <input class="u-full-width" type="text" placeholder="Nombre de mois" name="nbMois">
				</div>

					<label style="">Catégorie</label>
					
					<select name="categorie" class="three columns">

					 		<?php 
					 			$categ = database::query("SELECT * FROM categorie_annonce");
					 			foreach ($categ as $categorie) {

					 				echo "<option value=\"".$categorie["Nom_url"]."\">".$categorie["Nom"]."</option>";
						 		
					 			}
					 		?>
					 	</select>
				

			</div>

					 <label>Description de l'annonce</label>
					 <textarea class="u-full-width" placeholder="Veuillez détailler un maximum l'annonce..." name="description" ></textarea>
					
					<input class="button-primary" type="submit" value="Envoyer" name="btnConfirmer">
			</form>
		
	
		
		</div>
			

		</div>
</div>
</html>