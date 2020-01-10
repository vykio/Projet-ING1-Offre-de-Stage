<?php 

$pagename = "Modifier une annonce";
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


if (isset($_GET['id']) && !empty($_GET['id'])) {
	$requested_id = $_GET['id'];
	$requested_id = filter_var($requested_id, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);

	//L'annonce existe et l'utilisateur connecté correspond à celui qui a créé l'annonce
	if (database::query("SELECT * from annonces WHERE id=:id AND user_id=:user_id", array(':id'=>$requested_id, ':user_id'=>Login::isLoggedIn()))) {

		//Récupére l'annonce
		$annonce = database::query("SELECT * from annonces WHERE id=:id", array(':id'=>$requested_id))[0];

			
		
		//Si il a cliqué sur le bouton de modification d'annonce
		if(isset($_POST['modifierAnnonce'])){

			$titre= $_POST['titre'];
			$ville= $_POST['ville'];
			$duree= $_POST['duree'];
			$dateDebut = $_POST['dateDebut'];
			$dateDebut = date('Y-m-d', strtotime($dateDebut));
			$description= $_POST['description'];
			$categorie = $_POST["categorie"];

			//Selectionne l'id de la categorie
			$categorie = database::query("SELECT id FROM categorie_annonce WHERE Nom_url=:param", array(":param"=>$categorie))[0]["id"];

			
			if (strlen($titre) >= 3 && strlen($titre) <= 64){

				if (strlen($ville) >= 2 && strlen($ville) <= 32){

					if(strlen($duree) > 0 && strlen($duree) <= 2){

						if(strlen($description) >= 8 && strlen($description) <= 50000){


								if (preg_match('/[0-9_]+/', $duree)){

										

									database::query("UPDATE annonces SET titre=:titre, ville=:ville, duree=:duree, description=:description, numCategorie=:categorie, dateDebut=:dateDebut WHERE id=:id", array(':id'=>$annonce["id"],':titre'=>$titre,':ville'=>$ville, ':duree'=>$duree, ':description'=>$description, ':categorie'=>$categorie, ':dateDebut'=>$dateDebut));


										header('Location: '.MYSPACE_PAGE . "?from=modif_annonce");
										exit();

									
								} else{
									echo'Caractere invalide duree (chiffre)';
								}
							
							
						} else{
							echo'Nombre de caratere invalide (min 8 max 5000)';
						}
					} else{
						echo'Nombre de caratere duree invalide (min 0 max 24)';
					}
				} else{
					echo'Nombre de caratere invalide ville (min 2 max 32)';
				}
			} else{
				echo'Nombre de caratere invalide titre (min 3 max 64)';
			}
			
		}

		if(isset($_POST['retour'])){
			header("Location:".MYSPACE_PAGE);
			die();
		}




	} else {
		header("Location:".INDEX_PAGE);
		die();
	}

} else {
	header("Location:".INDEX_PAGE);
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

	<link rel="stylesheet" type="text/css" href="src/css/modifannonce/modifannonce.css">

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
			<?php
			include('templates/menu.php');
			?>
	</div>




<div class= "modifAnnonce_div">

		<div class="annonce_titre">
			<h3> Modification d'annonce</h3>
		</div>
		<form action="<?php echo MODIFANNONCE_PAGE . "?id=" . $annonce["id"] ?>" method="POST">
		
			<div class="row">
				<div class="u-full-width">
				  <label>Titre</label>
				  <div class="date_div">
					  <input class="u-full-width" type="text" placeholder="Titre de l'annonce" name="titre"value="<?php echo $annonce["titre"]?>" minlength="10" maxlength="64" required>
					  <span class="validity"></span>
					</div>
				</div>	

			</div>

			<div class="row">
				<div class=" three columns">
				  <label>Lieux</label>
				  <div class="date_div">
					  	<input class="u-full-width" type="text" placeholder="Ville" name="ville" value="<?php echo $annonce["ville"]?>"  minlength="2" maxlength="40" required>
					  	<span class="validity"></span>
					</div>
				</div>	

				<div class="three columns">
					<label>Date début</label>
					<!--<input class="u-full-width" type="text" placeholder="AAAA-MM-JJ" name="dateDebut" value="<?php echo $annonce["dateDebut"]?>">-->
					<div class="date_div">
						<input type="date" name="dateDebut" id="date" value="<?php echo $annonce["dateDebut"];?>" min="<?php echo date("Y-m-j"); ?>" max="2025-01-01" required>
						<span class="validity"></span>
					</div>
					
				</div>

				<div class=" three columns">
				  <label>Durée</label>
				  	<div class="date_div">
					  <input class="u-full-width" type="text" placeholder="Nombre de mois" name="duree" value="<?php echo $annonce["duree"]?>" maxlength="4" required>
					  <span class="validity"></span>
					</div>
				</div>

				<div class=" three columns">
					<label style="">Catégorie</label>
					
					<select name="categorie" style="width: 100%">

					 		<?php 
					 			$categ = database::query("SELECT * FROM categorie_annonce");
					 			foreach ($categ as $categorie) {


					 				echo "<option value=\"".$categorie["Nom_url"]."\"" . (($annonce["numCategorie"] == $categorie["id"] ) ? "selected" : "") . ">".($categorie["Nom"] == "Toutes" ? "Non Définie" : $categorie["Nom"])."</option>";
						 		
					 			}
					 		?>
					 </select>	
				</div>

				</div>

					 <label>Description de l'annonce</label>
					 	<textarea class="u-full-width annonce_description" placeholder="Veuillez détailler un maximum l'annonce..." id="description" name="description" minlength="20" maxlength="50000" required ><?php echo $annonce["description"]?></textarea>
					<div class="row">
					<input class="button-primary six columns" type="submit" value="Modifier" name="modifierAnnonce">
					<input class="button six columns" type="submit" value="Retour" name="retour">
					</div>
		</form>
		
	
		
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




