<?php
include ("../../database.php");
include ("../../src/classes/CLASS_login.php");
class Request {
	public function getUsersData ($start, $limit) {
		if (Login::isLoggedIn()) {
			$user = database::query('SELECT account_type FROM utilisateurs WHERE id=:id', array(':id'=>Login::isLoggedIn()))[0];
			
			if ($user["account_type"] == '2') {

				$users = database::query("SELECT username, first_name, last_name, email FROM utilisateurs LIMIT $start, $limit");
				return $users;

			}

		}
	}
}

if (isset($_GET["start"])) {
	$start = $_GET["start"];
	$limit = $_GET["limit"];

	$req = new Request();
	$data = $req->getUsersData($start, $limit);

	echo json_encode($data);
}

?>