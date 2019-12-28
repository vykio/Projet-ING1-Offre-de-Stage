<?php
include ("../../database.php");
include ("../../src/classes/CLASS_login.php");

class Request {

	public function getSqlOutput($request) {
		if (Login::isLoggedIn()) {
			$user = database::query('SELECT account_type FROM utilisateurs WHERE id=:id', array(':id'=>Login::isLoggedIn()))[0];
			
			if ($user["account_type"] == '2') {
				if (strpos(strtolower($request), "drop") === false) {
					$output = database::query($request);
					
				} else {
					$output = [["DROP Impossible"]];
				}

				return $output;
				
			}
		}
	} 

}

//Pas mettre if !empty($_GET["start"]) car parfois, start = 0 => empty($_GET["start"]) = true (ce que l'on ne veut pas)
if (isset($_GET["cmd"])) {
	$cmd = $_GET["cmd"];

	$req = new Request();
	$data = $req->getSqlOutput($cmd);

	echo json_encode($data);
} else {
	header('Location: ' . INDEX_PAGE);
	die();
}

?>