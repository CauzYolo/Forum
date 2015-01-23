<?php
	
	require_once('include/redirection.php');

	$db = new myPdo();
	$categorieManagers = new categorieManager($db);
	$sujetManagers= new sujetManager($db);
	$userManagers=new userManager($db);


	if(isset($_SESSION['id']))
		$userId = intval($_SESSION['id']->idUser);
	else
		$userId = -1;

	if(isset($_GET['id']))
		$idSujet = htmlentities($_GET['id']);
	else
		$idSujet = null;

	if(isset($_POST['suppr']))
		$suppr = htmlentities($_POST['suppr']);
	else
		$suppr = null;

	$infoSujet = new sujet($sujetManagers->getSujetsByID($idSujet));

	if($userManagers->estAdmin($userId) || $userManagers->estMod($userId) || $sujetManagers->getIdUser() == $userId)
	{
		if(!is_null($infoSujet->getIdUser()))
		{
		?>
			<h2>Suppression du sujet : <?php echo $infoSujet->getTitreSujet(); ?></h2>
			<?php
			//vérif que l'utilisateur ait choisi s'il voulait supprimé ou non + récap du sujet
			if(empty ($suppr))
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
				CKEDITOR.replace('descr');
				</script>	
				<br/>
				
				<label for="suppr">Êtes-vous sûr de vouloir supprimer le sujet <?php echo $infoSujet->getTitreSujet(); ?> ? </label>

				<input type="radio" name="suppr" value="true"> Oui
				<input type="radio" name="suppr" value="false"  checked="checked"> Non  
				<input type="hidden" name="id" value="<?php echo $idSujet; ?>">


				<br />
				<input class="btn btn-success btn-xs" type="submit" name="Submit" value="Valider" />
			</form>
			<?php
			}
			else
			{
				// true est entre '' car $suppr renvoie un string
				if($suppr == 'true')
				{
					$sujetManagers->del($idSujet);
					?>
					<p class="success">Le sujet <?php echo $infoSujet->getTitreSujet() ?> a bien été supprimé</p>
					<?php
				}
				else
				{
				?>
					<p class="success">Vous n'avez pas supprimer le sujet <?php echo $infoSujet->getTitreSujet() ?></p>

				<?php
				}
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
	else
		redirection(0, "index.php");