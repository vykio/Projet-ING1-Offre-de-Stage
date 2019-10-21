<?php 

//Définition du nom de la page à afficher via le fichier templates/header.php
$pagename = "Accueil";
define('PAGE_NAME', $pagename);

include('templates/short_links.php');
include('database.php');
include('src/classes/CLASS_login.php');

//La fonction isLoggedIn() de la classe Login, return l'id de l'utilisateur connecté
if (Login::isLoggedIn()) {
	$user = database::query('SELECT username, email, first_name, last_name FROM utilisateurs WHERE id=:id', array(':id'=>Login::isLoggedIn()))[0]; //[0] premier résultat, car il est unique donc pas de pb
	//$user contient les champs username, email, first_name et last_name
} else {
	echo 'Not logged in';
	
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

	<!-- Header (contenant la barre de recherche et quelques boutons) -->
	<div class="home_header">
		


		<!-- Class Container de SKELETON CSS et searchContainer de src/css/home/home.css -->
		<div class="container searchContainer">
			
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
				 <form action="index2.php" method="POST">
				 	<input type="text" name="searchBox" placeholder="Rechercher un stage par mots clés ..." class="five columns home_header_searchbox">
					<input type="text" name="searchBox_Ville" placeholder="Ville" class="three columns home_header_searchbox">
					<input type="submit" name="clickSearchBox" value="&#10095; Recherche" class="four columns button-primary" style="font-size: 1.2rem;">
				 </form>
				</div>
			
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

		<?php 
		if(isset($_POST['searchBox']) && isset($_POST['searchBox_Ville']) && !empty($_POST['searchBox']) && !empty($_POST['searchBox_Ville']) ){

			$searchValue = $_POST['searchBox'];
			$searchValue_Ville = $_POST['searchBox_Ville'];

			$annonces = database::query("SELECT * FROM annonces WHERE titre LIKE '%{$searchValue}%' AND ville LIKE '%{$searchValue_Ville}%'");


		} else if (isset($_POST['searchBox']) && !empty($_POST['searchBox'])) {

			$searchValue = $_POST['searchBox'];

			$annonces = database::query("SELECT * FROM annonces WHERE titre LIKE '%{$searchValue}%'");

		} else if (isset($_POST['searchBox_Ville']) && !empty($_POST['searchBox_Ville'])) {

			$searchValue_Ville = $_POST['searchBox_Ville'];

			$annonces = database::query("SELECT * FROM annonces WHERE ville LIKE '%{$searchValue_Ville}%'");


		} else {

			$annonces = database::query("SELECT * FROM annonces");

		}


			

			foreach ($annonces as $annonce) {
				$annonce["titre"] = filter_var($annonce["titre"], FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
				//Supprime les balises et les char ASCII > 127
				$annonce["entreprise"] = filter_var($annonce["entreprise"], FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
				$annonce["ville"] = filter_var($annonce["ville"], FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
				$annonce["duree"] = filter_var($annonce["duree"], FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
				?>

				<div class="annonce_container">
					<div class="annonce_inner_container">
						<div class="annonce_titre">
							<a href="login.php">
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

				<?php
			
			}
		?>
		

		
		</div>

		
	</div>

	<div class="footer">
		Projet informatique - 1ère année Ecole d'Ingénieurs du Littoral Côte d'Opale - Groupe TP12
	</div>

</body>
</html>