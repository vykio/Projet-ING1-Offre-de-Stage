//Si le nom d'utilisateur n'est pas utilisé
	if (!DB::query('SELECT nickname FROM members WHERE nickname=:nickname', array(':nickname'=>$username))) {
		//inutile TU PEUX SUPPRIMER LA LIGNE EN DESSOUS
		if (isset($_POST['validation_checkbox'])){
			//si la taille du nom d'utilisateur est entre 3 et 32
			if (strlen($username) >= 3 && strlen($username) <= 32){
				//Si le nom d'utilisateur contient uniquement des lettres et des chiffres
				if (preg_match('/[a-zA-Z0-9_]+/', $username)){

					//Password verif c'est une autre input de mot de passe mais pour vérifier, genre tu dois mettre deux fois le mdp
					if ($password == $password_verif){

						//Si le mot de passe est entre 6 et 60 , pareil pour le password_verif
						if (strlen($password) >= 6 && strlen($password) <= 60 && strlen($password_verif) >= 6 && strlen($password_verif) <= 60 ) {

							//Si l'email est sous la forme d'une vraie email
							if (filter_var($email, FILTER_VALIDATE_EMAIL)){

								BRAVO CA MARCHE TU PEUX ENREGISTRER SON COMPTE