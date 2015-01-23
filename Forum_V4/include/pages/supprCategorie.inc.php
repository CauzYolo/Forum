<?php
	
	$db = new MyPdo();
	$userManagers = new userManager($db);
	$categorieManagers = new categorieManager($db);

	if(isset($_SESSION['id']))
		$userId = intval($_SESSION['id']->idUser);
	else
		$userId = -1;

	if(isset($_GET['idCat']))
		$idCat = htmlentities($_GET['idCat']);
	else
		$idCat = null;

	if(isset($_POST['suppr']))
		$suppr = htmlentities($_POST['suppr']);
	else
		$suppr = null;

	if($userManagers->estAdmin($userId))
	{

		$cat = new categorie($categorieManagers->getCategorieById($idCat));

		if(!is_null($cat->getIdCat()))
		{
			if (empty ($suppr))
			{
	?>
				<form action="#" method="post">		
					<label for="suppr">Êtes-vous sûr de vouloir supprimer la catégorie <?php echo $cat->getLibCat() ?> ? </label>

					<input type="radio" name="suppr" value="true"> Oui 
					<input type="radio" name="suppr" value="false"  checked="checked"> Non 
					<input type="hidden" name="id" value="<?php echo $idCat;?>">
	
					<br />
					<input class="btn btn-success btn-xs" type="submit" name="Submit" value="Valider" />
				</form>
		<?php
			}
			else{
				// true est entre '' car $_POST['suppr'] renvoie un string
				if($suppr == 'true'){
					$categorieManagers->del($idCat);
		?>
					<p class="success">La catégorie <?php echo $cat->getLibCat() ?> a bien été supprimé</p>

			<?php
				}
				else
				{

				?>
					<p class="success"> Vous n'avez pas supprimé la catégorie <?php echo $cat->getLibCat() ?> </p>

				<?php
				}
				redirection(5, "index.php");
			} 
		}
		else
		{

		?>
			<div class="error" > Aucune catégorie trouvée </div>
		
		<?php

			redirection(5, "index.php");

		}
	}
	else
		redirection(0, "index.php");

?>