<!-- login page -->
<!DOCTYPE html>
<html>
<head>
	<title>Authentification</title>

	<!-- Skeleton CSS -->
	<link rel="stylesheet" type="text/css" href="src/css/skeleton/normalize.css">
	<link rel="stylesheet" type="text/css" href="src/css/skeleton/skeleton.css">

	<!-- CSS custom -->
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
	<div id="login" class="super">

	  	<form>
	  		
	  		<!-- Contenu dans la form pour mettre un padding left et right sur le contenu de la forme -->
	  		<div class="lower">

	  			<h2><strong>Connexion au service en ligne</strong></h2>

	  			<!-- Message à afficher quand erreur connexion -->
	  			<div id="message_erreur_login" class="erreur_login" style="display: none">Erreur, le nom d'utilisateur ou le mot de passe est incorrect</div>

	  			<!-- class = "row" créé par Skeleton CSS pour faire une "ligne" -->
	  			<div class="row">
					<label for="usernameInput">Nom d'utilisateur</label>
					<!-- Classe u-full-width créée par Skeleton.css et permet de mettre la longueur (width) au maximum de la div dans lequel il est contenu -->
					<input class="u-full-width" type="text" placeholder="Utilisateur" id="usernameInput" style="border-radius: 50px;" required>
				</div>

		  		<div class="row">
					<label for="passwordInput">Mot de passe</label>
		      		<input class="u-full-width" type="password" placeholder="Mot de passe" id="passwordInput" style="border-radius: 50px;" required>
		  		</div>
		  		<br>
		  		<!-- button-primary créé par Skeleton.css et change la couleur du bouton par la couleur primaire (à changer par la couleur de l'école) -->
		  		<!-- type="submit" pour confirmer la form -->
		  		<input class="u-full-width button-primary" type="submit" value="Connexion" style="border-radius: 50px;">
	  		
	  		</div>
		  
		</form>


	</div>

</div>


<div class="footer">
	Projet informatique - 1ère année Ecole d'Ingénieurs du Littoral Côte d'Opale - Groupe TP12
</div>


	

</body>
</html>