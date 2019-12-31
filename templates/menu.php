<!-- Utilisé pour créer la barre de navigation -->
<nav class="nav_menu" role="navigation">
	<!-- Liste d'éléments <li> -->
    <ul class="menu">
		<li><a href="<?php echo INDEX_PAGE ?>"><i class="fas fa-home"></i>&emsp;Accueil</a></li>
		<li class="menu_toggle_icon" id="menu_toggle_button"><a href="javascript:void(0);" onclick="menu_toggle_fn()"><i class="fas fa-bars"></i></a></li>
		<li class="menu_item"><a href="<?php echo FAQ_PAGE?>">Besoin d'aide ?</a></li>	
    	<?php

    	if ($user["account_type"] != 0) {
    		?>
    		<li class="menu_item"><a href="<?php echo MYSPACE_PAGE?>">Mon espace</a></li>
    		<?php
    	}

    	?>
    	
        <li class="menu_item"><a href="<?php echo PROFILE_PAGE . "?id="  . Login::isLoggedIn() ?>"><i class="far fa-user"></i>&emsp;Mon profil</a></li>

    </ul>
</nav>

<script type="text/javascript">
	//Fonction Javascript utilisé pour afficher ou non le menu en mode mobile
	function menu_toggle_fn() {
		var menu_toggle_btn = document.getElementsByClassName("menu_item");
		for (i = 0; i < menu_toggle_btn.length; i++) {
			if (menu_toggle_btn[i].style.display != "block") {
				menu_toggle_btn[i].style.display = "block";
			} else {
				menu_toggle_btn[i].style.display = "";
			}
		}
		
	}
	
</script>