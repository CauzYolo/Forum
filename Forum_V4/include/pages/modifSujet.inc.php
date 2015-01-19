<?php

	$db = new myPdo();
	$categorieManagers = new categorieManager($db);
	$sujetManagers = new sujetManager($db);
	$userManagers = new userManager($db);


	if(isset($_GET['id']))
		$idSujet = htmlentities($_GET['id']);
	else
		$idSujet = null;

	if(isset($_SESSION['id']))
		$userId = htmlentities($_SESSION['id']->idUser);
	else
		$userId = -1;

	if(isset($_POST['titre']))
		$titre = htmlentities($_POST['titre']);
	else
		$titre = null;

	if(isset($_POST['descr']))
		$descrSujet = $_POST['descr'];
	else
		$descr = null;

	if(isset($_POST['cat']))
		$categorie = htmlentities($_POST['cat']);
	else
		$categorie = null;

	if(isset($_POST['ferme']))
	{
		$estFerme = htmlentities($_POST['ferme']);
		if($estFerme == "true")
		{
			$estFerme = 1;
		}
		else
		{
			$estFerme = 0;
		}
	}
	else
	{
		$estFerme = null;
	}

	$infoSujet = new sujet($sujetManagers->getSujetsByID($idSujet));

	if($userManagers->estAdmin($userId) || $userManagers->estMod($userId) || $sujetManagers->getIdUser() == $userId)
	{
		if(!is_null($infoSujet->getIdSujet()))
		{
		?>
			<h2>Modification du sujet : <?php echo $infoSujet->getTitreSujet(); ?></h2>
			<?php
			// vérif que l'utilisateur est passé et souhaite modifier + sujet avec tous ces champ prérempli
			if(	empty ($titre) ||	
				empty ($descrSujet) ||
				empty ($categorie) ||
				is_null ($estFerme))
			{
			?>
			<form action="#" method="post">
				<label for="titre">Titre du sujet :</label>
				<input type="text" name="titre" id="titre" value="<?php echo $infoSujet->getTitreSujet(); ?>"/>
				<br />
				<label for="descr">Description du sujet :</label>
				<br/>
				<textarea name="descr" id="descr" ><?php echo $infoSujet->getDescrSujet(); ?></textarea>	
				<script>
				CKEDITOR.replace("descr");
				</script>
				<br/>
				
				<select name="cat">
				<?php 
				$listCat= $categorieManagers->getListCat();
				foreach ($listCat as $cat)
				{?>
					<option value=<?php echo $cat->getIdCat(); ?> ><?php echo $cat->getLibCat(); ?></option>
				<?php
				}
				?>
				</select>
				<br />
				
				<label for="ferme">Voulez vous fermer le sujet ? </label>

				<?php
					$sujetFerme = $infoSujet->getEstFerme();
					if($sujetFerme == 0){
				?>

				<input type="radio" name="ferme" value="false" checked="checked"> Non </input>
				<input type="radio" name="ferme" value="true"> Oui </input>

				<?php 
					}
					else{

				?>
						<input type="radio" name="ferme" value="false"> Non </input>
						<input type="radio" name="ferme" value="true" checked="checked"> Oui </input>
						
				<?php
					}
				?>

				<!-- Nous cachons l'id du sujet car l'utilisateur n'a pas l'utilité de le connaitre et il nous servira pour la mod'ification d'un seul élément et non toute la base -->
				<input type="hidden" name="id" value="<?php echo $idSujet;?>">

				<br />
				<div class="btn-group">
					<input class="btn btn-success btn-xs" type="submit" name="Submit" value="Valider" />
					<input class="btn btn-danger btn-xs" type="button" name="Reset" value="Annuler" onclick="document.location='index.php'"/>
				</div>
			</form>
			<?php
			}
			else
			{
				//$userId=intval($_SESSION['id']->idUser);
				$newSujet= new Sujet(
					array(
					'idSujet'=>$idSujet,
					'titreSujet'=>$titre,
					'dateSujet'=>$infoSujet->getDateSujet(),
					'descrSujet'=>$descrSujet,
					'nbVue'=>$infoSujet->getNbVue(),
					'estFerme'=>$estFerme,
					'idUser'=>$infoSujet->getIdUser(),
					'idCat'=>$categorie
					)
				);
				$sujetManagers->update($newSujet);
				?>
				<p class="success">Le sujet <?php echo $infoSujet->getTitreSujet(); ?> a bien été modifié.</p>
				<?php
				redirection(5, "index.php");
			}
		}
		else
		{

		?>

			<div class="error"> Aucun sujet trouvé </div>
			
		<?php	
			redirection(5, "index.php");
		}
	}
	else redirection(0, "index.php");
	?>