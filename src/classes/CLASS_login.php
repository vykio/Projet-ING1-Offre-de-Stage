<?php

class Login {
	public static function isLoggedIn() {

		//Si le cookie du nom de SFID existe
		if (isset($_COOKIE['SFID'])) {

			//Si le token de connection du cookie encodé en sha256 se trouve dans la BDD dans la table login_tokens
			if (database::query('SELECT user_id FROM login_tokens WHERE token=:token', array(':token'=>hash('sha256', $_COOKIE['SFID'])))) {

				//On récupère le ID de l'utilisateur correspondant à ce token
				$userid = database::query('SELECT user_id FROM login_tokens WHERE token=:token', array(':token'=>hash('sha256', $_COOKIE['SFID'])))[0]['user_id'];

				//Si le token de vérification existe, on retourne l'id de l'utilisateur
				if (isset($_COOKIE['SFID_verif'])) {
					return $userid;
				} else {
					//Sinon
					// Ca fait plus de trois jours que l'utilisateur ne s'est pas connecté
					//Génération d'un nouveau token sans déconnecter l'utilisateur
					$cstrong = True;
					$token = bin2hex(openssl_random_pseudo_bytes(64, $cstrong));

					database::query('INSERT INTO login_tokens VALUES (null, :token, :user_id)', array(':token' => hash('sha256', $token), ':user_id' => $userid));
					database::query('DELETE FROM login_tokens WHERE token=:token', array(':token'=>hash('sha256', $_COOKIE['SFID'])));

					setcookie("SFID", $token, time() + 60 * 60 * 24 * 7, '/', NULL, NULL, TRUE);
					setcookie("SFID_verif", '1', time() + 60 * 60 * 24 * 3, '/', NULL, NULL, TRUE);

					return $userid;
				}


			}

		}

	}
}


?>