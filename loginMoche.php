<?php 
include('database.php');


$nompage = "Inscription au service en ligne";
define('PAGE_NAME', $nompage);

if(isset($_POST['creerCompte'])){

	$username = $_POST['username'];
	$password = $_POST['password'];
	$password_verif =$_POST['password_verif'];
	$email = $_POST['email'];
	$first_name = $_POST['first_name'];
	$last_name = $_POST['last_name'];
		

	//Si le nom d'utilisateur n'est pas utilisé
	if (!database::query('SELECT username FROM utilisateurs WHERE username=:username', array(':username'=>$username))) {


		//si la taille du nom d'utilisateur est entre 3 et 32
		if (strlen($username) >= 3 && strlen($username) <= 32){
			//Si le nom d'utilisateur contient uniquement des lettres et des chiffres
			if (preg_match('/[a-zA-Z0-9_]+/', $username)){

				//Password verif c'est une autre input de mot de passe mais pour vérifier, genre tu dois mettre deux fois le mdp
				if ($password == $password_verif){

					//Si le mot de passe est entre 6 et 60 , pareil pour le password_verif
					if (strlen($password) >= 6 && strlen($password) <= 60 && strlen($password_verif) >= 6 && strlen($password_verif) <= 60 ) {
						//Si l'email est sous la forme d'une vraie email
						if (filter_var($email, FILTER_VALIDATE_EMAIL)){
		
		
							database::query('INSERT INTO utilisateurs VALUES (:id, :username, :password, :password_verif, :email, :first_name, :last_name)', array('id'=>NULL, ':username'=>$username,':password'=>$password, ':password_verif'=>$password_verif, ':email'=>$email, ':first_name'=>$first_name, 'last_name'=>$last_name));
							echo "ok ça marche !!!";



 							// header('Location: http://localhost/projet-ing1-offre-de-stage/login.php');
 							//exit();




						}else{
							echo'Votre adresse mail ressemble a R';
						}
					} else {
						echo'Votre mot de passe doit être le même dans les deux champs. Il doit contenir entre 6 et 60 caractères.';
					}
				}else{
					echo'Votre mot de passe doit être le même dans les deux champs';
				}
			}else{
				echo'Votre nom utilisateur ne peut contenir pas contenir des caractères spécifiques';
			}
		}else{
			echo'VOtre nom utilisateur doit contenir entre 3 et 32 caractères';
		}	
	}else{
		echo'Nom utilisateur déjà utilisé';
	}
}



?>




<html>
<body>

<head>
	<?php
	//Import de header.php qui contient tous les codes de liens CSS, et le titre de la page défini par la variable PAGE_NAME
	include('templates/header.php');
	?>

	<!-- CSS custom pour la page register (non utilisé par les autres pages -->
	<link rel="stylesheet" type="text/css" href="src/css/register/register.css">

</head>

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

	  	<form>
	  		
	  		<!-- Contenu dans la form pour mettre un padding left et right sur le contenu de la forme -->
	  		<div class="lower">

	  			<h2><strong>Inscription au service en ligne</strong></h2>

	  			<!-- class = "row" créé par Skeleton CSS pour faire une "ligne" -->
	  			<div class="row">
					<label for="first_nameInput">Prénom</label>
					<!-- Classe u-full-width créée par Skeleton.css et permet de mettre la longueur (width) au maximum de la div dans lequel il est contenu -->
					<input class="u-full-width" type="text" placeholder="Prénom" id="first_nameInput" style="border-radius: 50px;" autofocus required>
				</div>

		  		<div class="row">
					<label for="last_nameInput">Nom de famille</label>
		      		<input class="u-full-width" type="text" placeholder="Nom de famille" id="last_nameInput" style="border-radius: 50px;" required>
		  		</div>

		  		<div class="row">
					<label for="usernameInput">Nom d'utilisateur</label>
		      		<input class="u-full-width" type="text" placeholder="Nom d'utilisateur" id="usernameInput" style="border-radius: 50px;" required>
		  		</div>

		  		<div class="row">
					<label for="emailInput">Adresse électronique</label>
		      		<input class="u-full-width" type="text" placeholder="blabla@bla.bla" id="emailInput" style="border-radius: 50px;" required>
		  		</div>

		  		<div class="row">
					<label for="passwordInput">Mot de passe</label>
		      		<input class="u-full-width" type="password" placeholder="Mot de passe" id="passwordInput" style="border-radius: 50px;" required>
		  		</div>

		  		<div class="row">
					<label for="password_verifInput">Mot de passe</label>
		      		<input class="u-full-width" type="password" placeholder="Confirmer mot de passe" id="passwordInput" style="border-radius: 50px;" required>
		  		</div>

		  		<br>
		  		<!-- button-primary créé par Skeleton.css et change la couleur du bouton par la couleur primaire (à changer par la couleur de l'école) -->
		  		<!-- type="submit" pour confirmer la form -->
		  		<input class="u-full-width button-primary" type="submit" value="S'inscrire" style="border-radius: 50px;">
	  		
	  		</div>
		  
		</form>


	</div>

</div>

<div class="footer">
	Projet informatique - 1ère année Ecole d'Ingénieurs du Littoral Côte d'Opale - Groupe TP12
</div>


	
	<!-- <h1> Authentification </h1>
		<form action="loginMoche.php" method="post">
			<input type="text" name="username" value="" placeholder="Utilisateur..."> </p>
			<input type="password" name="password" value="" placeholder="Mot de passe ..."></p>
			<input type="password_verif" name="password_verif" value="" placeholder="Verification mot de passe.."></p>
			<input type="email" name="email" value="" placeholder="blabla@blabla.bla"></p>
			<input type="first_name" name="first_name" value="" placeholder="Prénom..."> </p>
			<input type="last_name" name="last_name" value="" placeholder="Nom..."> </p>
			<input type="submit" name="creerCompte" value="Créer compte" >
		</form> -->
	
</body>
</html>