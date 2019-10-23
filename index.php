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
				Recherche de stages étudiants
			</div>

			<!-- class="row" de SKELETON CSS permet d'avoir sur la meme ligne la textbox et le bouton rechercher.
			Si l'écran est trop petit, (< 400 ou 500px) le bouton passe en dessous. Pour avoir un design plus fluide et
			beau pour les utilisateurs mobiles -->
			<div class="row" >
				<!-- Dans SKELETON CSS on peut diviser les lignes en colonnes en spécifiant pour chaque élément, la place qu'il va prendre 
				sur 12. Par exemple, ici on a dit que la textbox doit prendre 8 colonnes (class "eight columns") sur 12. Et 4 / 12 pour le bouton.
				 -->
				 <form action="index2.php" method="GET">
				 	<div class="row" >
					 	<select class="three columns" style="padding-left: 15px" >
					 		<option value="1">Categorie 1</option>
					 		<option value="2">Categorie 2</option>
					 	</select>
					 	<input type="text" name="search" placeholder="Rechercher un stage par mots clés ..." class="six columns home_header_searchbox" maxlength="60" style="padding-left: 20px; padding-right: 20px">
						<input type="text" name="position" placeholder="Ville" maxlength="20" class="three columns home_header_searchbox" style="padding-left: 20px; padding-right: 20px">
					</div>
					<div class="row" >
						<button type="submit" class="u-full-width button-primary" style="font-size: 1.2rem;"><i class="fas fa-search"></i>&emsp;Recherche</button>
					</div>
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

		<!-- Utilisé pour créer la barre de navigation -->
		<nav class="nav_menu" role="navigation">
			<!-- Liste d'éléments <li> -->
		    <ul class="menu">
	    		<li><a href="#"><i class="fas fa-home"></i>&emsp;Accueil</a></li>
	    		<li class="menu_toggle_icon" id="menu_toggle_button"><a href="javascript:void(0);" onclick="menu_toggle_fn()"><i class="fas fa-bars"></i></a></li>
	  			<li class="menu_item"><a href="#">Catégories</a></li>
		        <li class="menu_item"><a href="#">À Propos</a></li>
		        <li class="menu_item"><a href="#"><i class="far fa-user"></i>&emsp;Mon profil</a></li>
		    </ul>
		</nav>
		

		<?php 



		if(isset($_GET['search']) && isset($_GET['position']) && !empty($_GET['search']) && !empty($_GET['position']) ){

			$searchValue = $_GET['search'];
			$searchValue_Ville = $_GET['position'];

			$searchValue = filter_var($searchValue, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
			$searchValue_Ville = filter_var($searchValue_Ville, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);

			$annonces = database::query("SELECT * FROM annonces WHERE titre LIKE '%{$searchValue}%' AND ville LIKE '%{$searchValue_Ville}%'");

			echo "<a href='" . INDEX_PAGE . "'>Supprimer filtres</a><h5>Résultat(s) des stages contenant <b>'" . $searchValue . "'</b>, à <b>'" . $searchValue_Ville . "'</b></h5>";


		} else if (isset($_GET['search']) && !empty($_GET['search'])) {

			$searchValue = $_GET['search'];

			$searchValue = filter_var($searchValue, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
			
			$annonces = database::query("SELECT * FROM annonces WHERE titre LIKE '%{$searchValue}%'");

			echo "<a href='" . INDEX_PAGE . "'>Supprimer filtres</a><h5>Résultat(s) des stages pour <b>'" . $searchValue . "'</b></h5>";

		} else if (isset($_GET['position']) && !empty($_GET['position'])) {

			$searchValue_Ville = $_GET['position'];

			$searchValue_Ville = filter_var($searchValue_Ville, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);

			$annonces = database::query("SELECT * FROM annonces WHERE ville LIKE '%{$searchValue_Ville}%'");

			echo "<a href='" . INDEX_PAGE . "'>Supprimer filtres</a><h5>Résultat(s) des stages à <b>'" . $searchValue_Ville . "'</b></h5>";

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