<?php 
//http://adnan-tech.com/tutorial/load-more-data-ajax-php !!!!!!!!!!!!!!!!!!!!!!!!!!!!!

$pagename = "Administration";
define('PAGE_NAME', $pagename);

include('templates/short_links.php');
include('database.php');
include('src/classes/CLASS_login.php');

if (Login::isLoggedIn()) {
	$user = database::query('SELECT username, email, first_name, last_name, account_type FROM utilisateurs WHERE id=:id', array(':id'=>Login::isLoggedIn()))[0];
	
	if ($user["account_type"] != '2') {
		header('Location: ' . INDEX_PAGE);
		exit();
	}
} else {
	header('Location: ' . LOGIN_PAGE);
	die(); 
}


// Code executé une fois que le compte connecté est bien administrateur




?>

<!DOCTYPE html>
<html>
<head>
	<?php
	//Import de header.php qui contient tous les codes de liens CSS, et le titre de la page défini par la variable PAGE_NAME
	include('templates/header.php');
	?>
	<style type="text/css">

		.tabs {
			display: flex;
			flex-wrap: wrap;

		}
		.tabs label {
			order: 1; /* puts the labels first */
			display: block;
			cursor: pointer;
			background: #006BA8;
			width: auto;
			padding: 5px;
			margin-right: 10px;
			color: white;
		}
		.tabs .tab {
			order: 2; /* puts the tabs last */
			flex-grow: 1;
			width: 100%;
			display: none;
			/*background: #fff;*/
			margin-top: -5px;

		}
		.tabs input[type="radio"] {
			display: none;
		}
		.tabs input[type="radio"]:checked + label {
			background: #fff;
			color: #006BA8;
		}
		.tabs input[type="radio"]:checked + label + .tab {
			display: block;
		}

		

		body {
			box-sizing: border-box;
			background-color: #EFEFEF;
		}


		table {
		  /*border: 1px solid #ccc;*/
		  border-collapse: collapse;
		  margin: 0;
		  padding: 0;
		  width: 100%;
		  table-layout: fixed;
		}

		table tr {
		  /*border: 1px solid #ddd;*/
		}

		table th,
		table td {
		  padding: .625em;
		  text-align: center;
		  background-color: #fff;
		}

		

		table th {
		  font-size: .85em;
		  letter-spacing: .1em;
		  text-transform: uppercase;
		}

		.load-more {
			border: 1px solid lightgrey;
			border-radius: 20px;
			padding: 5px;
			cursor: pointer;
			text-align: center;
			margin-top: 10px;
			margin-bottom: 10px;
			background-color: white;
			color: #006BA8;
		}

		.load-more a {
			width: 100%;
		}

		.load-more:hover {
			background-color: #006BA8;
			color: white;
		}

		.welcome {
			text-align: center;
			text-transform: uppercase;
			font-family: "Open Sans", sans-serif;
			font-size: 1.5em;
			margin: .5em 0 .75em;
			padding-top: 20px;
		}

		.bg-white {
			background-color: white;
		}

		.lien-accueil {
			text-align: center;
			padding-bottom: 20px;
		}

		.sql-output {
			border : 1px solid lightgrey;
			margin-top: 20px;
			padding-top: 10px;
			padding-bottom: 10px;
			width: 100%;
		}

		@media screen and (max-width: 600px) {
			.tabs .tab {
				background: #EFEFEF;
			}

		  table {
		    border: 0;
		  }
		  
		  table thead {
		    border: none;
		    height: 1px;
		    margin: -1px;
		    overflow: hidden;
		    padding: 0;
		    position: absolute;
		    width: 1px;
		  }
		  
		  table tr {
		    border-bottom: 3px solid #ddd;
		    display: block;
		    margin-bottom: .625em;
		  }
		  
		  table td {
		    border-bottom: 1px solid #ddd;
		    display: block;
		    font-size: .8em;
		    text-align: right;
		    padding-right: .625em;
		    background-color: #fff;
		  }

		  table td:first-child {
			padding-left: .625em;
			}

			table td:last-child {
				padding-right: .625em;
			}
		  
		  table td::before {
		    /*
		    * aria-label has no advantage, it won't be read inside a table
		    content: attr(aria-label);
		    */
		    content: attr(data-label);
		    float: left;
		    font-weight: bold;
		    text-transform: uppercase;
		  }
		  
		}

	</style>
</head>
<body>

	<div class="container">

		<div class="welcome">
			Bienvenue <?php echo $user["first_name"] ?>
		</div>
		<div class="lien-accueil">
			<a href="<?php echo INDEX_PAGE ?>">< Retour sur le site</a>
		</div>



		<div class="tabs">
			<input type="radio" name="tabs" id="tab_one" checked="checked">
			<label for="tab_one">Utilisateurs</label>
			<div class="tab">
				<table class="u-full-width">
				  <thead>
				    <tr>
				      <th>Name</th>
				      <th>Prénom</th>
				      <th>Nom</th>
				      <th>Email</th>
				      <th>Type</th>
				    </tr>
				  </thead>
				  <tbody id="users-data"></tbody>
				</table>

				<div class="load-more" onclick="getUserData()">
					Load More
				</div>
				

			</div>

			<input type="radio" name="tabs" id="tab_two">
			<label for="tab_two">Annonces</label>
			<div class="tab">
				lbabaqzd qzd qzd qzdqzdqz dqzd lbdlqkzdblqdkzbqzld qlzdkb qlzdk bq
				qzdlqzdihqz d
			</div>

			<input type="radio" name="tabs" id="tab_three">
			<label for="tab_three">SQL</label>
			<div class="tab">
				<div class="sql-desc bg-white">
					Attention, la commande SQL que vous rentrez peut affecter la majorité des données.
				</div>

				<div class="bg-white">
					<input type="text" name="sql-cmd" class="u-full-width" placeholder="Commande SQL..." id="sql-cmd">
					<input type="button" name="sql-confirm" value="Envoyer Commande" class="u-full-width" onclick="getSqlOutput()" id="sql-confirm">
				</div>

				<div class="sql-output" id="sql-output"></div>
			</div>
		</div>


	</div>


	
</body>
<script>
	
	// Starting position to get new records
    var start = 0;

    // This function will be called every time a button pressed 
    function getUserData() {
        // Creating a built-in AJAX object
        var ajax = new XMLHttpRequest();

        // Sending starting position
        ajax.open("GET", "src/ajax/request.php?start=" + start + "&limit=5", true);

        // Actually sending the request
        ajax.send();

        // Detecting request state change
        ajax.onreadystatechange = function () {
		    if (this.readyState == 4 && this.status == 200) {
		        
		        // Converting JSON string to Javasript array
		        var data = JSON.parse(this.responseText);
		        var html = "";
		        var type = "";

		        // Appending all returned data in a variable called html
		        for (var a = 0; a < data.length; a++) {
		            html += "<tr>";
		                html += "<td data-label='Username' style=\"overflow: hidden; word-break: break-word\">" + data[a].username + " (" + data[a].id + ") </td>";
		                html += "<td data-label='Prenom' style=\"overflow: hidden; word-break: break-word\">" + data[a].first_name + "</td>";
		                html += "<td data-label='Nom' style=\"overflow: hidden; word-break: break-word\">" + data[a].last_name + "</td>";
		                html += "<td data-label='Email' style=\"overflow: hidden; word-break: break-word\">" + data[a].email + "</td>";
		                
		                switch (data[a].account_type) {

		                	case '0':
		                		type = "Utilisateur";
		                		break;
		                	case '1':
		                		type = "Gestionnaire";
		                		break;
		                	case '2':
		                		type = "Administrateur";
		                		break;
		                	default:
		                		type = "ND";
		                }
		                html += "<td data-label='Type' style=\"overflow: hidden; word-break: break-word\">" + type + "</td>";
		            html += "</tr>";
		        }

		        // Appending the data below old data in <tbody> tag
		        document.getElementById("users-data").innerHTML += html;

		        // Incrementing the offset so you can get next records when that button is clicked
		        start = start + 5;
		    }
		};
    }

 	function getSqlOutput() {

        // Creating a built-in AJAX object
        var ajax = new XMLHttpRequest();

        cmd = document.getElementById("sql-cmd").value;

 		if (document.getElementById("sql-output").innerHTML != "") {
 			document.getElementById("sql-output").innerHTML = "";
 		}

        // Sending starting position
        ajax.open("GET", "src/ajax/sqlOutput.php?cmd=" + cmd, true);

        // Actually sending the request
        ajax.send();

        document.getElementById("sql-confirm").disabled = true;
        document.getElementById("sql-confirm").style.backgroundColor = "lightgrey";

        // Detecting request state change
        ajax.onreadystatechange = function () {
		    if (this.readyState == 4 && this.status == 200) {

		    	document.getElementById("sql-confirm").disabled = false;
		    	document.getElementById("sql-confirm").style.backgroundColor = "";
		        
		        // Converting JSON string to Javasript array
		        //console.log(this.responseText);
		        var data = JSON.parse(this.responseText);
		        for (var a = 0; a < data.length; a++) {
		        	for ( var b = 0; b < Object.keys(data[a]).length /2 ; b++) {
		        	//for (var b in data[a]) {
		        		document.getElementById("sql-output").innerHTML += JSON.stringify(data[a][b]) + " ";
		        	}
		        	document.getElementById("sql-output").innerHTML += "<br>";
		        }
		        
		    }
		};
    }




    // Calling the function on page load
    getUserData();

</script>
</html>
