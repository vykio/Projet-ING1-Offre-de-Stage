<?php 

$pagename = "Questions fréquentes";
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


?><!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">

	<?php
	//Import de header.php qui contient tous les codes de liens CSS, et le titre de la page défini par la variable PAGE_NAME
	include('templates/header.php');
	?>
	<!-- CSS custom pour la page login (non utilisé par les autres pages -->

	<link rel="stylesheet" type="text/css" href="src/css/faq/faq.css">

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

	<meta name="viewport" content="width=device-width, initial-scale=1">


		<!-- Visible par tout le monde -->

	<center><h3> Questions fréquentes </h3></center>

	<br>


	<button class="collapsible"> Comment puis-je modifier mon adresse e-mail ? </button>
	<div class="content">
	  <p> Vous pouvez changer votre adresse e-mail très facilement. Il vous suffit juste d’aller dans votre page personnelle (Mon profil). Une fois sur votre page de profil il faut cliquer sur "Modifier le profil". Voila ! Vous pouvez modifier votre adresse mail.</p>
	</div>


	<button class="collapsible"> Que faire si j’ai oublié mon mot de passe ? </button>
	<div class="content">
	  <p> Pour le moment notre site ne vous permet pas de modifier votre mot de passe.</p>
	</div>

	<button class="collapsible"> Où puis-je déposer mon C.V ? </button>
	<div class="content">
	  <p> Vous pouvez déposer votre C.V uniquement au moment où vous postulez à une annonce.</p>
	</div>

	<button class="collapsible"> Où puis-je modifier mon profil ? </button>
	<div class="content">
	  <p> Vous pouvez modifier votre profil en allant dans la rubrique "Mon profil". Ensuite, il suffit de cliquer sur le bouton "Modifier le profil".</p>
	</div>

	<button class="collapsible"> Mes informations personnelles seront-elles fournies à des tiers ? </button>
	<div class="content">
	  <p> Non, nous ne fournissons et ne fournirons aucunes informations personnelles de nos utilisateurs. Seules les informations que vous avez entré en postulant à une annonce sont transmises à l'entreprise.</p>
	</div>

	<button class="collapsible"> Est-ce que mes données privées sont visibles par tout le monde ? </button>
	<div class="content">
	  <p> Non, vos données privées ne seront pas toutes visibles par tout le monde. En effet, votre nom d'utilisateur, nom et prénom seront visibles par tous les utilisateurs. </p>
	</div>

	<button class="collapsible"> Comment supprimer mon profil ? </button>
	<div class="content">
	  <p> Pour le moment, notre site ne vous permet pas de supprimer votre profil. </p>
	</div>

		<!-- Si on est étudiant ou admin -->
 <?php 
 	if($user["account_type"]=='0'|| $user["account_type"]=='2'){

?>
	<br>

	<center><h3> Questions fréquentes d'étudiants </h3></center>

	<br>


	<button class="collapsible"> Comment puis-je mettre toutes les chances de mon coté pour décrocher le stage ? </button>
		<div class="content">
		  <p>Lorsque vous postulez à une offre de stage, il faut adapter votre lettre de motivation en fonction du poste. Votre CV doit être dans la langue demandée par l’entreprise. Lorsque vous êtes invité pour un entretien, il est important que vous connaissiez un certain nombre d’informations concernant l’entreprise. Il est aussi très important que vous connaissiez exactement le type de profil que l’entreprise recherche, et a quoi correspond exactement le job et la fonction que vous allez devoir exercer. Tout cela est important pour préparer au mieux l’entretien. Une fois que vous avez fait tout ca , vous serez alors bien préparer.

		  Pas de panique si vous ne décrochez pas le stage, ne vous inquiétez pas, ce n'était peut être pas vraiment le stage adéquate pour vous.</p>
		</div>

	<button class="collapsible"> Comment postuler à un stage ? </button>
		<div class="content">
		  <p> Une fois que vous avez trouvé une annonce qui vous interesse, il faut cliquer sur celle-ci. Ensuite vous verrez l'annonce détaillée et en bas de page vous pourrez postuler. </p>
		</div>


	<button class="collapsible"> Que se passe-t-il une fois la candidature envoyée ? </button>
		<div class="content">
		  <p> Une fois que vous avez envoyé votre candidature, elle est transmise par mail à la personne de l'entreprise qui a publié l'annonce.</p>
		</div>

	<button class="collapsible"> Quand un stage doit-il être rémunéré ? </button>
		<div class="content">
		  <p> En France, tous les stages d'une durée de plus de deux mois à temps plein doit être rémunéré. Dans ce cas, un stagiaire à temps plein a donc le droit à un minimum de 554 € par mois.</p>
		</div>

	

	

	<?php

	}
	?>


	<!-- Si on est gestionnaire ou admin -->

<?php 
 	if($user["account_type"]=='1'|| $user["account_type"]=='2'){

?>
	<br>

	<center><h3> Questions fréquentes de gestionnaires </h3></center>

	<br>


	<button class="collapsible"> Comment créer une offre ? </button>
		<div class="content">
		  <p>Pour créer une offre, il faut aller dans la rubrique "Mon Espace". Vous y trouverez un bouton "Creer une annonce". Il ne vous reste plus qu'à remplir les champs nécessaires à la création de l'annonce. Après avoir envoyé votre annonce, votre offre de stage est immédiatement visible par tout les utilisateurs.</p>
		</div>

	<button class="collapsible"> Qui peut postuler à mes offres de stage ? </button>
		<div class="content">
		  <p> Tous les candidats inscrits peuvent postuler à vos offres.</p>
		</div>

	<button class="collapsible"> De quelle manière, vais-je recevoir les candidatures ? </button>
		<div class="content">
		  <p>Les candidatures des candidats vous seront envoyés par mail. Sans aucune intervention de notre part.</p>
		</div>

	<button class="collapsible"> Puis-je modifier mon offre après l'avoir mise en ligne? </button>
		<div class="content">
		  <p> Oui, c'est possible. Il faut aller dans la rubrique "Mon Espace". Vous y verrez toutes les annonces que vous avez publié. Sous chacune d'elles se trouvent 2 boutons, un pour modifier l'annonce et l'autre pour la supprimer.</p>
		</div>
	
	<button class="collapsible"> Dois-je payer pour déposer mes offres de stage ? </button>
		<div class="content">
		  <p>Non, notre service est totalement gratuit.</p>
		</div>





<?php

	}
	?>

</div>	



<script>
var coll = document.getElementsByClassName("collapsible");
var i;

for (i = 0; i < coll.length; i++) {
  coll[i].addEventListener("click", function() {
    this.classList.toggle("active");
    var content = this.nextElementSibling;
    if (content.style.maxHeight){
      content.style.maxHeight = null;
    } else {
      content.style.maxHeight = content.scrollHeight + "px";
    } 
  });
}
</script>


<br>
<br>
<br>
<?php 
include("templates/footer.php");
?>
</body>
</html>	