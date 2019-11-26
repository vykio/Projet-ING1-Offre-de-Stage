<?php 

//Définition du nom de la page à afficher via le fichier templates/header.php
$pagename = "Mon Profil";
define('PAGE_NAME', $pagename);

include('templates/short_links.php');
include('database.php');
include('src/classes/CLASS_login.php');

//La fonction isLoggedIn() de la classe Login, return l'id de l'utilisateur connecté
if (Login::isLoggedIn()) {
	$user = database::query('SELECT username, email, first_name, last_name, account_type, company_name, phone, contact_mail FROM utilisateurs WHERE id=:id', array(':id'=>Login::isLoggedIn()))[0];
} else {
	header('Location: ' . LOGIN_PAGE);
	die(); 
}



if (isset($_GET['id']) && !empty($_GET['id'])) {
	$requested_id = $_GET['id'];
	$requested_id = filter_var($requested_id, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);

	if (database::query("SELECT * from utilisateurs WHERE id=:id", array(':id'=>$requested_id))) {

	 $user_all_info= database::query("SELECT * from utilisateurs WHERE id=:id", array(':id'=>$requested_id))[0];

	}
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

	$account_type = $_POST['accountType'];

	$company_name = (isset($_POST['gest_entreprise']) ? $_POST['gest_entreprise'] : NULL);
	$phone = (isset($_POST ['gest_phone']) ? $_POST ['gest_phone'] : NULL);
	$contact_mail = (isset($_POST ['gest_mail']) ? $_POST ['gest_mail'] : NULL);
		

	

		//si la taille du nom d'utilisateur est entre 3 et 32
		if (strlen($username) >= 3 && strlen($username) <= 32){
			//Si le nom d'utilisateur contient uniquement des lettres et des chiffres
			if (preg_match('/[a-zA-Z0-9_]+/', $username)){

				if((strlen($phone) == 10 && $account_type == 1) || ($account_type == 0)) {

					if((filter_var($contact_mail, FILTER_VALIDATE_EMAIL) && $account_type == 1) || ($account_type == 0)){

						
				
				
							database::query('INSERT INTO utilisateurs VALUES (:id, :username, :first_name, :last_name, :company_name, :phone, :contact_mail)', array('id'=>NULL, ':username'=>$username,':first_name'=>$first_name, 'last_name'=>$last_name, 'company_name'=>$company_name, 'phone'=>$phone, 'contact_mail'=>$contact_mail));


							//Tout fonctionne

			 				header('Location: ' . LOGIN_PAGE);
			 				exit();

			 			
		 			} else {
		 				echo 'Email de contact invalide';
		 			}
		 		} else {
		 		echo'numéro de telephone incorrect';
		 		}		
			}else{
				echo'Votre nom utilisateur ne peut contenir pas contenir des caractères spécifiques';
			}
		}else{
			echo'VOtre nom utilisateur doit contenir entre 3 et 32 caractères';
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



	<div class="profile_titre_container">
		<h1 class="profile_titre">Mon Compte</h1>
	</div>



	<div class="profile_container">
		
		<!-- <?php

		// switch($user["account_type"])
		//  {
		 	
		//  	// Si le type de compte de l'utilisateur actuel vaut 1 -> C'est un gestionnaire
		//  	case 1 :
		//  		ech"";

		//  	break;

		//  	// Si le type de compte de l'utilisateur actuel vaut 2 -> C'est un administrateur
		//  	case 2 :
		//  		echo"";
		//  	break;

		//  	// Si pas 1 ni 2 -> C'est un membre normal
		//  	default: 
		//  		echo"";
		//  	break;


		// }

 		?> -->

 		<div class="lower_profile_container">

 			<form action="<?php echo PROFILE_PAGE ?>" method="post">
 				<div class="line">
	  				<label class="six columns" for="first_nameInput">Prénom</label>
	  				<label class="six columns" for="last_nameInput">Nom de famille</label>
	  			</div>
	  		<!-- <label class='offset-by-six columns' for="last_nameInput">Nom de famille</label> -->
	  			<div class="line">
					
					<input class="six columns" type="text" name="first_name" value="<?php echo $user["first_name"]?>" style="border-radius: 50px;" autofocus required maxlength="60">
					<!-- <label for="last_nameInput">Nom de famille</label> -->
		      		<input class="six columns" type="text" name="last_name" value="<?php echo $user["last_name"]?>" style="border-radius: 50px;" required maxlength="60">
		  		</div>

		  		<div class="line">
					<label for="usernameInput">Nom d'utilisateur</label>
		      		<input class="u-full-width" type="text" name="username" value="<?php echo $user["username"]?>" style="border-radius: 50px;" required maxlength="60">
		  		</div>

		  		
		  			<!-- SI L'UTILISATEUR EST UN GESTIONNAIRE -->
		  			<!-- <div class="line">
			  			<input class="six columns" id="gest_entreprise" type="text" name="gest_entreprise" value="" placeholder="Nom de l'entreprise" style="border-radius: 50px;" required maxlength="60">
			  			<input class="six columns" id="gest_phone" type="text" name="gest_phone" value="" placeholder="Numéro de téléphone" style="border-radius: 50px;" required maxlength="10">

			  		</div>
			  		<div class="line">
			  			<input class="u-full-width" type="text" name="gest_mail" value="" placeholder="Adresse Mail de contact" style="border-radius: 50px;" required maxlength="60">
			  		</div>
		  		 -->
		  		<input type="hidden" name="accountType" id="accType" value="0">

		  		<br>
		  		
		  		
		  		<!-- button-primary créé par Skeleton.css et change la couleur du bouton par la couleur primaire (à changer par la couleur de l'école) -->
		  		<!-- type="submit" pour confirmer la form -->
		  		<input class="u-full-width button-primary" type="submit" name="modifierCompte" value="Modifier les informations" style="border-radius: 50px;">

	  		
	  			</div>
		  
			</form>
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