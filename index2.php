<?php 

$pagename = "Accueil";
define('PAGE_NAME', $pagename);

?>


<!DOCTYPE html>
<html>
<head>
	<?php
	//Import de header.php qui contient tous les codes de liens CSS, et le titre de la page défini par la variable PAGE_NAME
	include('templates/header.php');
	?>
	<link rel="stylesheet" type="text/css" href="src/css/home/home.css">
</head>
<body>


	<div class="header" style="background: url('imgs/login.jpg') no-repeat center center fixed; background-color: #EEEEEE;
		-webkit-background-size: cover;
		-moz-background-size: cover;
		-o-background-size: cover;
		background-size: cover;">
	</div>

	<div class="home_header">
		
		<div class="container searchContainer">
			<div class="header_information_utilisateur">
				
			</div>
			<div class="header_slogan">
				Vous recherchez un stage ?<br>Ce site est fait pour vous
			</div>
			<div class="row">
				<input type="text" name="searchBox" placeholder="Rechercher un stage par mots clés ..." class="eight columns home_header_searchbox">
				<input type="button" name="clickSearchBox" value="&#10095; Recherche" class="four columns button-primary" style="font-size: 1.2rem;">
			</div>
			
		</div>
		
	</div>
	<div class="container home_container">
		ok
	</div>

</body>
</html>