<?php 

//Définition du nom de la page à afficher via le fichier templates/header.php
$pagename = "Mon Profil";
define('PAGE_NAME', $pagename);

include('templates/short_links.php');
include('database.php');
include('src/classes/CLASS_login.php');

//La fonction isLoggedIn() de la classe Login, return l'id de l'utilisateur connecté
if (Login::isLoggedIn()) {
	$user = database::query('SELECT id, username, email, first_name, last_name, account_type, company_name, phone, contact_mail FROM utilisateurs WHERE id=:id', array(':id'=>Login::isLoggedIn()))[0];
} else {
	header('Location: ' . LOGIN_PAGE);
	die(); 
}




// 	 {
 	
//  	// Si le type de compte de l'utilisateur actuel vaut 1 -> C'est un gestionnaire
//  	case 1 :
//  		echo 'Je suis gestionnaire';

//  	break;

//  	// Si le type de compte de l'utilisateur actuel vaut 2 -> C'est un administrateur
//  	case 2 :
//  		echo"Je suis admin";
//  	break;

//  	// Si pas 1 ni 2 -> C'est un membre normal
//  	default: 
//  		echo"Je cherche un stage";
//  	break;


//  	}


//  	} else {

// 		header('Location: ' . LOGIN_PAGE);
// 		die(); 
// }



if(isset($_POST['modifierCompte'])){

	$username = $_POST['username'];
	$first_name = $_POST['first_name'];
	$last_name = $_POST['last_name'];

	$email = $_POST['email'];
	$account_type = $user["account_type"];

	$company_name = ((isset($_POST['gest_entreprise']) && ($user["account_type"]== 1)) ? $_POST['gest_entreprise'] : NULL);
	$phone = ((isset($_POST ['gest_phone']) && ($user["account_type"]== 1)) ? $_POST ['gest_phone'] : NULL);
	$contact_mail = ((isset($_POST ['gest_mail']) && ($user["account_type"]== 1)) ? $_POST ['gest_mail'] : NULL);

	if (!database::query('SELECT username FROM utilisateurs WHERE username=:username AND id<>:id', array(':username'=>$username, ':id'=>Login::isLoggedIn()))) {


		//si la taille du nom d'utilisateur est entre 3 et 32
		if (strlen($username) >= 3 && strlen($username) <= 32){

			if (strlen($first_name) >= 2 && strlen($first_name) <= 32){

				if (strlen($last_name) >= 2 && strlen($last_name) <= 32){
					//Si le nom d'utilisateur contient uniquement des lettres et des chiffres
					if (preg_match('/[a-zA-Z0-9_]+/', $username)){

						//Si l'email est sous la forme d'une vraie email
						if (filter_var($email, FILTER_VALIDATE_EMAIL)){

							if((strlen($phone) == 10 && $account_type == 1) || ($account_type != 1)) {

								if((filter_var($contact_mail, FILTER_VALIDATE_EMAIL) && $account_type == 1) || ($account_type != 1)){

									if(!database::query('SELECT email FROM utilisateurs WHERE email=:email AND id<>:id', array(':email'=>$email, ':id'=>Login::isLoggedIn()))) {
				
				
										database::query("UPDATE utilisateurs SET username=:username, first_name=:first_name, last_name=:last_name, email=:email, phone=:phone, contact_mail=:contact_mail, company_name=:company_name WHERE id=:id", array(':id'=>Login::isLoggedIn(),':username'=>$username,':first_name'=>$first_name, ':last_name'=>$last_name, ':email'=>$email, ':phone'=>$phone, ':contact_mail'=>$contact_mail, ':company_name'=>$company_name));


										//Tout fonctionne

			 							header('Location: ' . PROFILE_PAGE . "?id=" . Login::isLoggedIn() . "&from=modif_profile");
			 							exit();

			 						} else {
			 							echo 'Email deja utilisée';
		 							}
		 						} else {
		 							echo 'Email de contact invalide';
		 						}
		 					} else {
		 						echo'numéro de telephone incorrect';
		 					}

						}else{
							echo'Votre adresse mail ressemble a R';
						}
					}else{
						echo'Votre nom utilisateur ne peut contenir pas contenir des caractères spécifiques';
					}
				}else{
					echo'Votre nom doit contenir entre 2 et 32 caractères';
				}
			}else{
		 		echo'Votre prenom doit contenir entre 2 et 32 caractères ';
			}
		}else{
			echo'VOtre nom utilisateur doit contenir entre 3 et 32 caractères';
		}	
	}else{
		echo'Nom utilisateur déjà utilisé';
	}
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

<?php

if (isset($_GET["from"])) {
	if ($_GET["from"] == "modif_profile") {
		echo "<script type=\"text/javascript\">showNotification('info', 'Vos informations ont été modifiées avec succès', '');</script>";
	}
}

?>


<body>


	<!-- Image Derriere le header -->
	<div class="header" style="background: url('imgs/login_3.jpg') no-repeat center center fixed; background-color: #EEEEEE;
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

			<!-- class="row" de SKELETON CSS permet d'avoir sur la meme ligne la textbox et le bouton rechercher.
			Si l'écran est trop petit, (< 400 ou 500px) le bouton passe en dessous. Pour avoir un design plus fluide et
			beau pour les utilisateurs mobiles -->
			<div class="row" >
				<!-- Dans SKELETON CSS on peut diviser les lignes en colonnes en spécifiant pour chaque élément, la place qu'il va prendre 
				sur 12. Par exemple, ici on a dit que la textbox doit prendre 8 colonnes (class "eight columns") sur 12. Et 4 / 12 pour le bouton.
				 -->
				 <form action="<?php echo INDEX_PAGE ?>" method="GET">
				 	<div class="row" >
					 	<select class="three columns" name="categorie" style="padding-left: 15px" >
					 		<?php 
					 			$categ = database::query("SELECT * FROM categorie_annonce");
					 			foreach ($categ as $categorie) {

					 				echo "<option value=\"".$categorie["Nom_url"]."\">".$categorie["Nom"]."</option>";
						 		
					 			}
					 		?>
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
					<a href="<?php echo PROFILE_PAGE ?>" style="color: white; text-decoration: none" title ="Profil" ><?php echo $user['username'] ?> (<?php echo $user['email'] ?>)</a>

				</div>
				
				<a href="<?php echo LOGOUT_PAGE ?>" style="color: white; text-decoration: none"  title="Déconnexion" >Déconnexion &emsp;<i class="fas fa-sign-out-alt"></i></a> </br>
			</div>
	</div>	

	<div class="container main_container">
	<!-- Contenus de la page -->
		<!-- Utilisé pour créer la barre de navigation -->
		<?php 
		include('templates/menu.php');
		?>

	<br>

	<?php
	$differentProfil = false;
	if (isset($_GET['id']) && !empty($_GET['id'])) {
		$requested_id = $_GET['id'];
		$requested_id = filter_var($requested_id, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);

		if (database::query("SELECT * from utilisateurs WHERE id=:id", array(':id'=>$requested_id))) {

			if ($requested_id != Login::isLoggedIn()) {
				//Utilisateur connecté différent de celui demandé
				$differentProfil = true;
				$user_all_info = database::query("SELECT * from utilisateurs WHERE id=:id", array(':id'=>$requested_id))[0];

				
			} else {
				//Utilisateur connecté égale à l'utilisateur demandé
				$user_all_info = $user;
				$differentProfil = true;

			}
		} else {
			$user_all_info = $user;
		}
	} else {
		$user_all_info = $user;
	}


	if (!$differentProfil) {


	?>

			<div class="annonce_container">

				<br>

		 		<div class="lower_profile_container">

		 			<form action="<?php echo PROFILE_PAGE ?>" method="post">
		 				<div class="row">
			  				<label class="six columns" for="first_nameInput">Etat Civil</label>
			  			</div>
			  		<!-- <label class='offset-by-six columns' for="last_nameInput">Nom de famille</label> -->
			  			<div class="row">
							
							<input class="six columns" type="text" placeholder="Prénom" name="first_name" value="<?php echo $user["first_name"]?>" style="border-radius: 50px;" autofocus required maxlength="60">
							<!-- <label for="last_nameInput">Nom de famille</label> -->
				      		<input class="six columns" type="text" name="last_name" placeholder="Nom" value="<?php echo $user["last_name"]?>" style="border-radius: 50px;" required maxlength="60">
				  		</div>

				  		<div class="row">
							<label for="usernameInput">Nom d'utilisateur</label>
				      		<input class="u-full-width" type="text" placeholder="Nom d'utilisateur" name="username" value="<?php echo $user["username"]?>" style="border-radius: 50px;" required maxlength="60">
				  		</div>
						<div class="row">
							<label>Adresse électronique</label>
				  		<input class="u-full-width" type="text" name="email" placeholder="Adresse mail de connexion" value="<?php echo $user["email"]?>" style="border-radius: 50px;" required maxlength="60">
				  		</div>
						<!-- SI L'UTILISATEUR EST UN GESTIONNAIRE -->
						<?php if($user["account_type"]==1){ ?>

							<br>

							<div class="row">
				  				<label>Entreprise | Telephone de contact</label>
				  			</div>

				  			<div class="row">
					  			<input class="six columns" id="gest_entreprise" type="text" placeholder="Nom de l'entreprise" name="gest_entreprise" value="<?php echo $user["company_name"]?>" style="border-radius: 50px;" required maxlength="60">
					  			<input class="six columns" id="gest_phone" type="text" name="gest_phone" placeholder="Numéro de téléphone de contact" value="<?php echo $user["phone"]?>"  style="border-radius: 50px;" required maxlength="10">

					  		</div>
					  		<div class="row">
					  			<label>Adresse électronique de contact</label>
					  			<input class="u-full-width" type="text" name="gest_mail" placeholder="Adresse mail de contact" value="<?php echo $user["contact_mail"]?>"  style="border-radius: 50px;" required maxlength="60">
					  		</div>



					  	<?php } ?>
				  		
				  

				  		<br>

				  		
				  		<!-- button-primary créé par Skeleton.css et change la couleur du bouton par la couleur primaire (à changer par la couleur de l'école) -->
				  		<!-- type="submit" pour confirmer la form -->
					  		
					  		<center>
					  			<input class="button-primary" type="submit" name="modifierCompte" value="Modifier les informations" style="max-width :500px ;border-radius: 50px;">
							</center>


				  	
			  			</div>
				  
					</form>
		 		</div>

			</div>
	<?php

	} else {

		$gravatar_email = $user_all_info["email"];
		$gravatar_default = "https://moonvillageassociation.org/wp-content/uploads/2018/06/default-profile-picture1.jpg";
		$gravatar_size = 100;
		$gravatar_url = "https://www.gravatar.com/avatar/" . md5( strtolower( trim( $gravatar_email ) ) ) . "?d=" . urlencode( $gravatar_default ) . "&s=" . $gravatar_size;

		?>

				<div class="row">
						<center>
		 					<img src="<?php echo $gravatar_url; ?>" style="width: 150px; border-radius: 50%" alt="" />
		 					<br>
		 					<?php

		 					if ($user_all_info["account_type"] == 1) {

		 						?>
		 						<h1 class="profile_titre"><i class="far fa-building"></i> <?php echo $user_all_info["company_name"] ?></h1>
		 						<h1 class="profile_titre" style="font-size: 1.5em;"><i class="fas fa-at"></i> <?php echo $user_all_info["username"] ?></h1>
		 						<?php

		 					} else {

		 						?>
		 						<h1 class="profile_titre"><i class="fas fa-at"></i> <?php echo $user_all_info["username"] ?></h1>
		 						<?php

		 					}

		 					?>
		 					
		 					<div class="statut"><?php
		 						switch ($user_all_info["account_type"]) {
		 							case '0':
		 								echo "<i class='fas fa-user'></i> Utilisateur";
		 								break;

		 							case '1':
		 								echo "<i class='fas fa-user-tie'></i> Gestionnaire";
		 								break;

		 							case '2':
		 								echo "<span class='fa-stack' style='vertical-align: top;'><i class='fas fa-circle fa-stack-2x'></i><i class='fas fa-check fa-stack-1x fa-inverse'></i></span> <span style='font-weight: bold'>Administrateur</span>";
		 								break;
		 							
		 							default:
		 								echo "Utilisateur non vérifié";
		 								break;
		 						}
		 					?></div>
		 				</center>



		 			</div>
		 			<br>
			<div class="annonce_container">



				<!--<div class="profile_titre_container">

					
				</div>-->

				

		 		<div class="lower_profile_container">

		 			<div class="row">
		 				<div class="six columns">
		 					<center>
		 						<?php echo $user_all_info["first_name"] ?>
		 					</center>
		 				</div>
		 				<div class="six columns">
		 					<center>
		 						<?php echo $user_all_info["last_name"] ?>
		 					</center>
		 				</div>
		 			</div>

		 			

		 				<?php

		 					if ($user_all_info["account_type"] == 1) {

		 						?>
		 						<div class="row">
		 							<center>
		 						Contact: <?php echo $user_all_info["contact_mail"]; ?>
		 						</center>
		 						</div>
		 						<?php

		 					}

		 					?>
		 				
		 			<?php
	 					if ($user_all_info["id"] == Login::isLoggedIn()) {
	 				
	 				?>
	 				<div class="row">
	 					<br>
			  			<center><input type="button" name="modifier" class="button-primary" value="Modifier le profil" onclick="document.location.href='<?php echo PROFILE_PAGE ?>'"></center>
			  		</div>
			  		<?php
			  			}
			  		?>
		 				

		 			
		 		</div>

			</div>




		<?php


	}

	?>

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