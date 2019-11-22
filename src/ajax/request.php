<?php
include ("../../database.php");
include ("../../src/classes/CLASS_login.php");

class Request {
	public function getUsersData ($start, $limit) {
		if (Login::isLoggedIn()) {
			$user = database::query('SELECT account_type FROM utilisateurs WHERE id=:id', array(':id'=>Login::isLoggedIn()))[0];
			
			if ($user["account_type"] == '2') {

				$users = database::query("SELECT id, username, first_name, last_name, email, account_type FROM utilisateurs LIMIT $start, $limit");
				return $users;

			}

		} 
	}


}

//Pas mettre if !empty($_GET["start"]) car parfois, start = 0 => empty($_GET["start"]) = true (ce que l'on ne veut pas)
if (isset($_GET["start"]) && ($_GET["start"] >= 0) && isset($_GET["limit"]) && !empty($_GET["limit"])) {
	$start = $_GET["start"];
	$start = filter_var($start, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
	$limit = $_GET["limit"];
	$limit = filter_var($limit, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);

	$req = new Request();
	$data = $req->getUsersData($start, $limit);

	echo json_encode($data);
} else {
	header('Location: ' . INDEX_PAGE);
	die();
}

?>