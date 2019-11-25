<?php
include ("../../database.php");
include ("../../src/classes/CLASS_login.php");

class Request {
	public function getUsersData ($like, $start, $limit) {
		if (Login::isLoggedIn()) {
			$user = database::query('SELECT account_type FROM utilisateurs WHERE id=:id', array(':id'=>Login::isLoggedIn()))[0];
			
			if ($user["account_type"] == '2') {

				$users = database::query("SELECT id, username, first_name, last_name, email, account_type FROM utilisateurs WHERE (id LIKE '%{$like}%') OR (username LIKE '%{$like}%') or (first_name LIKE '%{$like}%') OR (last_name LIKE '%{$like}%') OR (email LIKE '%{$like}%') LIMIT $start, $limit");
				return $users;

			}

		} 
	}


	public function getPostsData($like, $start, $limit) {
		if (Login::isLoggedIn()) {
			$user = database::query('SELECT account_type FROM utilisateurs WHERE id=:id', array(':id'=>Login::isLoggedIn()))[0];
			
			if ($user["account_type"] == '2') {

				$annonces = database::query("SELECT annonces.id AS id, annonces.titre AS titre, utilisateurs.username AS username, categorie_annonce.Nom AS categorieName, utilisateurs.contact_mail AS contactMail
					FROM annonces INNER JOIN utilisateurs ON utilisateurs.id=annonces.user_id INNER JOIN categorie_annonce ON categorie_annonce.id=annonces.numCategorie 
					WHERE (annonces.id LIKE '%{$like}%') OR (annonces.titre LIKE '%{$like}%') OR (utilisateurs.contact_mail LIKE '%{$like}%')
					LIMIT $start, $limit");
				return $annonces;

			}

		} 
	}


}

//Pas mettre if !empty($_GET["start"]) car parfois, start = 0 => empty($_GET["start"]) = true (ce que l'on ne veut pas)
if (isset($_GET["start"]) && ($_GET["start"] >= 0) && isset($_GET["limit"]) && !empty($_GET["limit"]) && isset($_GET["like"]) && !isset($_GET["annonce"])) {
	$start = $_GET["start"];
	$start = filter_var($start, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
	$limit = $_GET["limit"];
	$limit = filter_var($limit, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
	$like = $_GET["like"];
	$like = filter_var($like, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);

	$req = new Request();
	$data = $req->getUsersData($like, $start, $limit);

	echo json_encode($data);
} else if (isset($_GET["annonce"]) && isset($_GET["start"]) && ($_GET["start"] >= 0) && isset($_GET["limit"]) && !empty($_GET["limit"])) {
	$start = $_GET["start"];
	$start = filter_var($start, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
	$limit = $_GET["limit"];
	$limit = filter_var($limit, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
	$annonce_like = $_GET["annonce"];
	$annonce_like = filter_var($annonce_like, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);

	$req = new Request();
	$data = $req->getPostsData($annonce_like, $start, $limit);

	echo json_encode($data);
} else {
	header('Location: ' . INDEX_PAGE);
	die();
}

?>