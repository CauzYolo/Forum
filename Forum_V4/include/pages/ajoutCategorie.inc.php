<?php

	$db = new MyPdo();
	$userManagers = new userManager($db);
	$categorieManagers = new categorieManager($db);

	if(isset($_SESSION['id']))
		$userId = intval($_SESSION['id']->idUser);
	else
		$userId = -1;

	if($userManagers->estAdmin($userId)){

		if(isset($_POST['libele']))
			$libele = htmlentities($_POST['libele']);
		else 
			$libele = null;

		if(empty($libele))
		{
	?>
			<h2>Ajouter une catégorie</h2>
			<form action="#" method="post">
				<label for="libele">Nom de la catégorie :</label>
				<input type="text" name="libele" id="libele" />
				<br />
				<div class="btn-group">
					<input class="btn btn-success btn-xs" type="submit" name="Submit" value="Valider" />
					<input class="btn btn-danger btn-xs" type="button" name="Annuler" value="Annuler" onclick="document.location='index.php'" />
				</div>			
			</form>
			<?php
		}
		else
		{

			$categorie = new categorie(
			array(
				'libCat'=>$libele,
				)
		);

		$categorieManagers->add($categorie);

		?>

		<p class="success">La catégorie <?php echo $categorie->getLibCat() ?> a été enregistré</p>

		<?php

		redirection(5, "index.php");

		}
	}
	else redirection(0, "index.php");

?>