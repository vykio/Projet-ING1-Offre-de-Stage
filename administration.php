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
		.card {
			border: 1px solid lightgrey;
			border-radius: 5px;
		}

		.card-title {
			text-align: center;
			font-size: 2rem;
		}

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
		}
		.tabs .tab {
			order: 2; /* puts the tabs last */
			flex-grow: 1;
			width: 100%;
			display: none;
			background: #fff;
			margin-top: -5px;

		}
		.tabs input[type="radio"] {
			display: none;
		}
		.tabs input[type="radio"]:checked + label {
			background: #fff;
		}
		.tabs input[type="radio"]:checked + label + .tab {
			display: block;
		}

		@media (max-width: 45em) {
			.tabs .tab,
			  .tabs label {
			  	margin: 0px;
			    order: initial;
			    width: 100%;
			  }
		}

		body {
			box-sizing: border-box;
			background-color: #EFEFEF;
		}

	</style>
</head>
<body>

	<div class="container">



		<div class="tabs">
			<input type="radio" name="tabs" id="tab_one" checked="checked">
			<label for="tab_one">Utilisateurs</label>
			<div class="tab">
				<table class="u-full-width">
				  <thead>
				    <tr>
				      <th>Name</th>
				      <th>Age</th>
				      <th>Sex</th>
				      <th>Location</th>
				    </tr>
				  </thead>
				  <tbody id="users-data"></tbody>
				</table>

				 <a onclick="getUserData()" style="cursor: pointer;">Load More</a>

			</div>

			<input type="radio" name="tabs" id="tab_two">
			<label for="tab_two">Annonces</label>
			<div class="tab">
				lbabaqzd qzd qzd qzdqzdqz dqzd lbdlqkzdblqdkzbqzld qlzdkb qlzdk bq
				qzdlqzdihqz d
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

		        // Appending all returned data in a variable called html
		        for (var a = 0; a < data.length; a++) {
		            html += "<tr>";
		                html += "<td>" + data[a].username + "</td>";
		                html += "<td>" + data[a].first_name + "</td>";
		                html += "<td>" + data[a].last_name + "</td>";
		                html += "<td>" + data[a].email + "</td>";
		            html += "</tr>";
		        }

		        // Appending the data below old data in <tbody> tag
		        document.getElementById("users-data").innerHTML += html;

		        // Incrementing the offset so you can get next records when that button is clicked
		        start = start + 5;
		    }
		};
    }

    // Calling the function on page load
    getUserData();

</script>
</html>
