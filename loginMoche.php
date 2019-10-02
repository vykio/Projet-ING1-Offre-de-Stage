<?php 
include('database.php');


$nompage = "Authentification";
define('PAGE_NAME', $nompage);

	if(isset($_POST['creerCompte'])){
		$username = $_POST['username'];
		$password = $_POST['password'];
		$email = $_POST['email'];
		$first_name = $_POST['first_name'];
		$last_name = $_POST['last_name'];
		
		
		
		database::query('INSERT INTO utilisateurs VALUES (:id, :username, :password, :email, :first_name, :last_name)', array('id'=>NULL, ':username'=>$username,':password'=>$password,':email'=>$email, ':first_name'=>$first_name, 'last_name'=>$last_name));
		echo "ok ça marche !!!";
		
		
		
		
	}
?>


<html>
<body>
	
	<h1> Authentification </h1>
		<form action="loginMoche.php" method="post">
			<input type="text" name="username" value="" placeholder="Utilisateur..."> </p>
			<input type="password" name="password" value="" placeholder="Mot de passe ..."></p>
			<input type="email" name="email" value="" placeholder="blabla@blabla.bla"></p>
			<input type="first_name" name="first_name" value="" placeholder="Prénom..."> </p>
			<input type="last_name" name="last_name" value="" placeholder="Nom..."> </p>
			<input type="submit" name="creerCompte" value="Créer compte" >
		</form>
</body>
</html>