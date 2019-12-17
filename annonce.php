<?php 

$pagename = "Annonce";
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

	if (database::query("SELECT * from annonces WHERE id=:id", array(':id'=>$requested_id))) {

		$annonce = database::query("SELECT * from annonces WHERE id=:id", array(':id'=>$requested_id))[0];
		$user_annonce = database::query("SELECT id, company_name FROM utilisateurs WHERE id=:id", array(":id"=>$annonce["user_id"]))[0];

		// echo "<span style=\"white-space: pre-line;\">" . $annonce["description"] ."</span>";

		if (isset($_POST['confirm']) && $_POST['confirm'] == 'Envoyer') {
			if (isset($_FILES['uploadedFile']) && $_FILES['uploadedFile']['error'] === UPLOAD_ERR_OK) {
				// get details of the uploaded file
				$fileTmpPath = $_FILES['uploadedFile']['tmp_name'];
				$fileName = $_FILES['uploadedFile']['name'];
				$fileSize = $_FILES['uploadedFile']['size'];
				$fileType = $_FILES['uploadedFile']['type'];
				$fileNameCmps = explode(".", $fileName);
				$fileExtension = strtolower(end($fileNameCmps));

				//Sanitize !
				$newFileName = md5(time() . $fileName) . '.' . $fileExtension;

				$allowedfileExtensions = array('pdf', 'doc', 'docx', 'odt', 'rtf');

				if (in_array($fileExtension, $allowedfileExtensions)) {

					// directory in which the uploaded file will be moved
					$uploadFileDir = 'uploads/';
					$dest_path = $uploadFileDir . $newFileName;
					 
					if(move_uploaded_file($fileTmpPath, $dest_path))
					{
					  $message ='File is successfully uploaded.';

					  //OK envoie du mail
						

						// To
						$to = database::query("SELECT contact_mail FROM utilisateurs WHERE id=:user_id", array(':user_id'=>$annonce["user_id"]))[0]["contact_mail"];
						 
						// Subject
						$subject = 'étu-stage - Nouvelle Candidature [' . $annonce["titre"] . ']';
						 
						// clé aléatoire de limite
						$boundary = md5(uniqid(microtime(), TRUE));
						 
						// Headers
						$headers = 'From: étu-stage <admin@vykio.fr>'."\r\n";
						$headers .= 'Mime-Version: 1.0'."\r\n";
						$headers .= 'Content-Type: multipart/mixed;boundary='.$boundary."\r\n";
						$headers .= "\r\n";
						 
						// Message pour les clients ne supportant pas le type MIME
						$msg = 'Texte affiché par des clients mail ne supportant pas le type MIME.'."\r\n\r\n";
						 
						// Message HTML
						$msg .= '--'.$boundary."\r\n";
						$msg .= 'Content-type: text/html; charset=utf-8'."\r\n\r\n";
						$msg .= '
						<center>Code <strong>affiché</strong></center>
						<div style="">Code test reçu par des utilisateurs</div>
						'."\r\n";
						 
						// Pièce jointe 1
						$file_name = $dest_path;
						if (file_exists($file_name))
						{
							$file_type = filetype($file_name);
							$file_size = filesize($file_name);
						 
							$handle = fopen($file_name, 'r') or die('File '.$file_name.'can t be open');
							$content = fread($handle, $file_size);
							$content = chunk_split(base64_encode($content));
							$f = fclose($handle);
						 
							$msg .= '--'.$boundary."\r\n";
							$msg .= 'Content-type:'.$file_type.';name='.'CV.'.$fileExtension."\r\n";
							$msg .= 'Content-transfer-encoding:base64'."\r\n\r\n";
							$msg .= $content."\r\n";
						}
						 
						// Fin
						$msg .= '--'.$boundary."\r\n";
						 
						// Function mail()
						$mail_sent = mail($to, $subject, $msg, $headers);
						if ($mail_sent) {
							unlink($dest_path);
						} else {
							header('Location: ' . INDEX_PAGE);
							die(); 

						}


						
						header('Location: ' . ANNONCE_PAGE);
						die(); 

					}
					else
					{
					  $message = 'There was some error moving the file to upload directory. Please make sure the upload directory is writable by web server.';
						echo $message;
					}

				}

			}
		} else {
			$vue =$annonce["nbVue"];
			$vue++;
			database::query("UPDATE annonces set nbVue=:nbvue WHERE id=:id", array(":nbvue"=> $vue, ":id"=> $annonce["id"]));
		}

		





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
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	
	<?php
	//Import de header.php qui contient tous les codes de liens CSS, et le titre de la page défini par la variable PAGE_NAME
	include('templates/header.php');
	?>
	<!-- CSS custom pour la page login (non utilisé par les autres pages -->
	<link rel="stylesheet" type="text/css" href="src/css/annonce/annonce.css">

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

		<div class="container main_container">
			<!-- Contenus de la page -->

			<?php 
			include('templates/menu.php');
			?>
	

		<div class="annonce_container">
			<div class="annonce_inner_container">
				<div class="annonce_titre">
					<?php echo $annonce["titre"] ?>
				</div>
				<div class="row">
					<div class="annonce_entreprise three columns"><a href="<?php echo PROFILE_PAGE . "?id=" . $user_annonce["id"]  ?>"><?php echo $user_annonce["company_name"] ?></a></div>
					<div class="annonce_location three columns"><span>&#128204 </span><?php echo $annonce["ville"] ?></div>
					<div class="annonce_duree three columns"><?php echo $annonce["duree"] ?> mois</div>
					<div class="annonce_duree three columns"><?php

									$categ = database::query("SELECT Nom FROM categorie_annonce, annonces WHERE categorie_annonce.id = annonces.numCategorie AND annonces.id={$annonce["id"]}")[0]["Nom"];
									echo $categ;
							?></div>
				</div>
			
				<div class="annonce_description">
					<span style="white-space: pre-line;"><?php
						echo $annonce["description"];
					?></span>
				
				</div>
			</div>
		</div>
	
		<?php

		if ($user["account_type"] == 0) {

		?>

		<div class= "postuler_div">

			<?php if ($annonce["dateDebut"] > database::query("SELECT DATE(NOW()) AS DATE;")[0]["DATE"]) { 
				?>

			<div class="annonce_titre">
				<h3> Postuler</h3>
			</div>
			<form method="POST" action="<?php echo ANNONCE_PAGE . "?id=" . $annonce["id"] ?>" enctype="multipart/form-data">
			
				<div class="row">
				<div class="six columns">
					  <label>Email</label>
					  <input class="u-full-width" type="email" placeholder=".....@mail.com" >
					</div>

					<div class="six columns">
						<div class= "row">
							<label>CV Upload</label>
							<!--<label for="exampleEmailInput">CV Upload</label>
							<button>chercher le fichier</button>
							<input class="button-primary" type="button" value=" Telechargement">-->
							<label>Upload CV</label>
							 <input type="file" name="uploadedFile" />
						</div>
					</div>


				</div>

						 <label>Message</label>
						 <textarea class="u-full-width" placeholder="Votre motivation en quelques lignes" id="exampleMessage"></textarea>
						 <label class="example-send-yourself-copy">
						  <input type="checkbox">
						  <span class="label-body">Envoi d'une confirmation par mail</span>
							</label>
						<input class="button-primary" name="confirm" type="submit" value="Envoyer">
				</form>
			<?php 
			} else {
			?>
			<center>L'annonce n'est plus disponible.</center>
			<?php
			}
			?>
		
			
			</div>
			
			<?php
		}
			 ?>

		</div>


	</div>



</html>