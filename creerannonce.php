<?php 

$pagename = "Creation d'annonce";
define('PAGE_NAME', $pagename);

include('templates/short_links.php');
include('database.php');
include('src/classes/CLASS_login.php');

if (Login::isLoggedIn()) {
	$user = database::query('SELECT username, email, first_name, last_name, account_type FROM utilisateurs WHERE id=:id', array(':id'=>Login::isLoggedIn()))[0];
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

	database::query("INSERT INTO annonces VALUES (null, :titre, :description, :ville, :user_id, :duree, :numCategorie, 0, :dateDebut)", array(
		":titre"=>$titre,
		":description"=>$description,
		":ville"=>$ville,
		":user_id"=>Login::isLoggedIn(),
		":duree"=>$duree,
		":numCategorie"=>$categorie,
		":dateDebut"=>$dateDebut
	));

	header('Location: ' . MYSPACE_PAGE . "?from=creer_annonce");
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
			<?php 
			include('templates/menu.php');
			?>
	</div>



<div class= "creerAnnonce_div">

		<div class="annonce_titre">
			<h3> Création d'annonce</h3>
		</div>
		<form action="<?php echo CREERANNONCE_PAGE ?>" method="POST">
		
			<div class="row">
				<div class="u-full-width">
				  <label>Titre</label>
				  <div class="date_div">
				  	<input class="u-full-width" type="text" placeholder="Titre de l'annonce" name="titre" minlength="10" maxlength="64" required>
				  	<span class="validity"></span>
				  </div>
				</div>	

			</div>

			<div class="row">
				<div class=" three columns">
				  <label>Lieux</label>
				  <div class="date_div">
				  	<input class="u-full-width" type="text" placeholder="Ville" name="ville" minlength="2" maxlength="40" required>
				  	<span class="validity"></span>
				  </div>
				</div>	

				<div class="three columns">
					<label>Date début</label>
					<!--<input class="u-full-width" type="text" placeholder="AAAA-MM-JJ" name="dateDebut" value="<?php echo $annonce["dateDebut"]?>">-->
					<div class="date_div">
						<input type="date" name="dateDebut" id="date" min="<?php echo date("Y-m-j"); ?>" max="2025-01-01" required>
						<span class="validity"></span>
					</div>
					
				</div>

				<div class=" three columns">
				  <label>Durée</label>
				  <div class="date_div">
				  		<input class="u-full-width" type="text" placeholder="Nombre de mois" name="nbMois" maxlength="4" required>
				  		<span class="validity"></span>
					</div>
				</div>

				<div class=" three columns">
					<label>Catégorie</label>
					
					<select name="categorie" style="width: 100%"><?php 
				 			$categ = database::query("SELECT * FROM categorie_annonce");
				 			foreach ($categ as $categorie) {

				 				echo "<option value=\"".$categorie["Nom_url"]."\">".($categorie["Nom"] == "Toutes" ? "Non Définie" : $categorie["Nom"])."</option>";
					 		
				 			}
				 		?>
				 	</select>
				 </div>
				

			</div>

					 <label>Description de l'annonce</label>
					 <div class="date_div">
					 <textarea class="u-full-width annonce_description" placeholder="Veuillez détailler un maximum l'annonce..." name="description" minlength="20" maxlength="50000" required ></textarea>
					 <span class="validity"></span>
					</div>
					<input class="button-primary" type="submit" value="Envoyer" name="btnConfirmer">
			</form>
		
	
		
		</div>
			

		</div>
</div>

<script type="text/javascript">
	//Code JQUERY pour changer le type de l'élement d'id "date" en datePicker 
	//Pour SAFARI
	if ( $('#date')[0].type != 'date' ) $('#date').datepicker({
		format: 'dd/mm/yyyy',
		changeYear: true,
        minDate: 'D',
        maxDate: '+2Y'
	});
</script>

<br>
<br>
<br>
<br>
<?php 
include("templates/footer.php");
?>
</body>
</html>