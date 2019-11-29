<?php 

$pagename = "Authentification";
define('PAGE_NAME', $pagename);

include('templates/short_links.php');
include('database.php');
include('src/classes/CLASS_login.php');
include('src/classes/CLASS_url.php');

if (!Login::isLoggedIn()) {


	if(isset($_POST['login'])){

		/* Ne pas oublier de donner les ttributs, name="login", name="username" et name="password" aux input dans le html */
	$username = $_POST['username'];
	$password = $_POST['password'];

		if(database::query('SELECT username FROM utilisateurs WHERE username=:username', array(':username'=>$username))){
		
		    
			//echo database::query('SELECT password FROM utilisateurs WHERE username=:username', array(':username'=>$username))[0]['password'];
			
			/* Utiliser password_verify seulement quand on aura "hash" le mot de passe, pour l'instant utiliser que la simple égalité (pas du tout sécurisé) */
			/* PS: Je vais m'occuper du hash (cryptage du mdp) */

			/*if(password_verify($password, database::query('SELECT password FROM utilisateurs WHERE username=:username', array(':username'=>$username))[0]['password'])) {*/
			if (password_verify($password, database::query('SELECT password FROM utilisateurs WHERE username=:username', array(':username'=>$username))[0]['password'])) {
				//génération d'un token de longueur 64
				$cstrong = True;
				$token = bin2hex(openssl_random_pseudo_bytes(64, $cstrong));

				//Récupération de l'id de l'utilisateur avec ce nom
				$user_id = database::query('SELECT id FROM utilisateurs WHERE username=:username', array(':username'=>$username))[0]['id'];

				//Insertion du token codé en sha256 dans la BDD dans la table login_tokens
				database::query('INSERT INTO login_tokens VALUES (null, :token, :user_id)', array(':token' => hash('sha256', $token), ':user_id' => $user_id));


				//Définition des cookies
				//Le premier (7 jours) contient le token non codé
				setcookie("SFID", $token, time() + 60* 60 * 24 * 7, '/', NULL, NULL, TRUE);
				// 		1er NULL : Domain cookie's valid on
				//		2me NULL : Pour que le cookie soit accessible en HTTP et HTTPS
								//METTRE A TRUE
				//		3me NULL : Prevent Javascript from accessing the cookie!

				//Le deuxième (3 jours) contient nimporte quoi et nous sert à regénérer le token de connection au dela de 3 jours sans connexion
				setcookie("SFID_verif", '1', time() + 60* 60 * 24 * 2, '/', NULL, NULL, TRUE);
				header('Location: ' . INDEX_PAGE);
				exit();

			} else {

				echo'<center><b>Utilisateur ou mot de passe incorrect!</b></center>';

			}


		} else {
			echo'<center><b>Utilisateur ou mot de passe incorrect!</b></center>';

		}

	}

} else {
	header('Location: ' . INDEX_PAGE);
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
	<link rel="stylesheet" type="text/css" href="src/css/login/login.css">

</head>

<body>


<!-- Image de fond pour tous les navigateurs -->
<div class="header" style="background: url('imgs/login.jpg') no-repeat center center fixed; background-color: #EEEEEE;
	-webkit-background-size: cover;
	-moz-background-size: cover;
	-o-background-size: cover;
	background-size: cover;">
</div>

	
<!-- Container centré et réduit par Skeleton.css et re-réduit par la classe CSS "login" -->
<div class="container login" style="border: 0px solid black">

	
	<!-- div blanche sur le site contenant la form -->
	<div class="super">

	  	<form action="login.php" method="post">
	  		
	  		<!-- Contenu dans la form pour mettre un padding left et right sur le contenu de la forme -->
	  		<div class="lower">

	  			<h2><strong>Connexion au service en ligne</strong></h2>

	  			<!-- Message à afficher quand erreur connexion -->
	  			<div id="message_erreur_login" class="erreur_login" style="display: none">Erreur, le nom d'utilisateur ou le mot de passe est incorrect</div>

	  			<!-- class = "row" créé par Skeleton CSS pour faire une "ligne" -->
	  			<div class="row">
					<label for="usernameInput">Nom d'utilisateur</label>
					<!-- Classe u-full-width créée par Skeleton.css et permet de mettre la longueur (width) au maximum de la div dans lequel il est contenu -->
					<input class="u-full-width" type="text" placeholder="Utilisateur" id="usernameInput" style="border-radius: 50px;" name="username" autofocus required>
				</div>

		  		<div class="row">
					<label for="passwordInput">Mot de passe</label>
		      		<input class="u-full-width" type="password" placeholder="Mot de passe" id="passwordInput" name="password" style="border-radius: 50px;" required >
		  		</div>
		  		<br>
		  		<!-- button-primary créé par Skeleton.css et change la couleur du bouton par la couleur primaire (à changer par la couleur de l'école) -->
		  		<!-- type="submit" pour confirmer la form -->
		  		<input class="u-full-width button-primary" type="submit" value="Connexion" name="login" style="border-radius: 50px;">
	  		
	  		</div>
		  
		</form>

		<p class="inscription"><a href="<?php echo REGISTER_PAGE ?>">Pas de compte ? Inscrivez-vous ></a></p>

	</div>

</div>

<?php 
	include("templates/footer.php");
?>


</body>
</html>