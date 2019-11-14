<?php 

$pagename = "Annonce";
define('PAGE_NAME', $pagename);

include('templates/short_links.php');
include('database.php');
include('src/classes/CLASS_login.php');

if (Login::isLoggedIn()) {
	$user = database::query('SELECT username, email, first_name, last_name FROM utilisateurs WHERE id=:id', array(':id'=>Login::isLoggedIn()))[0];
} else {
	header('Location: ' . LOGIN_PAGE);
	die(); 
}



if (isset($_GET['id']) && !empty($_GET['id'])) {
	$requested_id = $_GET['id'];
	$requested_id = filter_var($requested_id, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);

	if (database::query("SELECT * from annonces WHERE id=:id", array(':id'=>$requested_id))) {

		$annonce = database::query("SELECT * from annonces WHERE id=:id", array(':id'=>$requested_id))[0];

		// echo "<span style=\"white-space: pre-line;\">" . $annonce["description"] ."</span>";

	} else {

		header('Location: ' . LOGIN_PAGE);
		die(); 


	}

} else {

	header('Location: ' . LOGIN_PAGE);
	die(); 

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
	<div class="annonce_titre"> 
		 <span class= six columns> <b> <?php echo $annonce["titre"] ?> </b> </span>
	</div>
	<div class ="annonce_description">
		 <?php echo "<span class=\"six columns;\" style=\"white-space: pre-line;\"> <b>" . $annonce["description"] . "</b> </span>";?>
	</div>
</body>
</html>
