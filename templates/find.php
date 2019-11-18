<div class="row" >
				<!-- Dans SKELETON CSS on peut diviser les lignes en colonnes en spécifiant pour chaque élément, la place qu'il va prendre 
				sur 12. Par exemple, ici on a dit que la textbox doit prendre 8 colonnes (class "eight columns") sur 12. Et 4 / 12 pour le bouton.
				 -->
				 <form action="<?php echo INDEX_PAGE ?>" method="GET">
				 	<div class="row" >
					 	<select class="three columns" name="categorie" style="padding-left: 15px" >
					 		<?php 
					 			$categ = database::query("SELECT * FROM categorie_annonce");
					 			foreach ($categ as $categorie) {

					 				echo "<option value=\"".$categorie["Nom_url"]."\">".$categorie["Nom"]."</option>";
						 		
					 			}
					 		?>
					 	</select>
					 	<input type="text" name="search" placeholder="Rechercher un stage par mots clés ..." class="six columns home_header_searchbox" maxlength="60" style="padding-left: 20px; padding-right: 20px">
						<input type="text" name="position" placeholder="Ville" maxlength="20" class="three columns home_header_searchbox" style="padding-left: 20px; padding-right: 20px">
					</div>
					<div class="row" >
						<button type="submit" class="u-full-width button-primary" style="font-size: 1.2rem;"><i class="fas fa-search"></i>&emsp;Recherche</button>
					</div>
				 </form>
				</div>