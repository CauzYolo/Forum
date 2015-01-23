<?php
	
	$db = new myPdo();
	$categorieManagers = new categorieManager($db);
	$userManagers = new userManager($db);

	if(isset($_GET['idCat']))
		$idCat = htmlentities($_GET['idCat']);
	else
		$idCat = null;
	if(is_null($categorieManagers->getCategorieById($idCat)))
		redirection(0, "index.php");
	else
		$cat = $categorieManagers->getCategorieById($idCat);
	$infoCat = new categorie($cat);

	//Détruire la varialbe $cat

	unset($cat);

	if(isset($_SESSION['id']))
		$userId = intval($_SESSION['id']->idUser);
	else
		$userId = -1;


	if($userManagers->estAdmin($userId)){
		if(!is_null($infoCat->getIdCat())){

?>
	 		<h2>Modification de la catégorie <?php echo $infoCat->getLibCat(); ?> </h2> 
		<?php
			// vérif que l'utilisateur est passé et souhaite modifier + sujet avec tous ces champ prérempli
			if(isset($_POST['libele']))
				$libele = htmlentities($_POST['libele']);
			else
				$libele = null;

			if(empty($libele))
			{
		?>
	 
				<form action="#" method="post">
					<label for="libele">Nom de la catégorie :</label>
					<br/>
					<input type="text" name="libele" id="libele" value="<?php echo $infoCat->getLibCat(); ?>"/>
					<br/>

					<!-- Nous cachons l'id du sujet car l'utilisateur n'a pas l'utilité de le connaitre et il nous servira pour la mod'ification d'un seul élément et non toute la base -->
					<input type="hidden" name="id" value="<?php echo $idCat ?>">

					<br />
					<div class="btn-group">
						<input class="btn btn-success btn-xs" type="submit" name="Submit" value="Valider" />
						<input class="btn btn-danger btn-xs" type="button" name="reset" value="Annuler" onclick="document.location='index.php'" />			
					</div>
				</form>
	
		<?php
			}
			else
			{
				$categorie = new categorie(
					array(
						'idCat'=>$infoCat->getIdCat(),
						'libCat'=>$libele
					)
				);
				$categorieManagers->update($categorie);
		?>
			<p class="succes">La catégorie <?php echo $infoCat->getLibCat(); ?> a bien été modifié.</p>
		<?php
			redirection(5, $_SERVER['PHP_SELF']);
			}
		}
		else{
			?>
			<div class="error"> Aucune catégorie trouvée </div>
			<?php
			redirection(5, "index.php");
		}
	}
	else redirection(0, "index.php");
	?> 