<?php
	

	$db = new myPdo();
	$reponseManagers = new reponseManager($db);
	$userManagers = new userManager($db);

	if(isset($_SESSION['id']))
		$userId = intval($_SESSION['id']->idUser);
	else
		$userId = -1;

	if(isset($_GET['id']))
		$idRep = htmlentities($_GET['id']);
	else
		$idRep = null;

	if(isset($_POST['suppr']))
		$suppr = htmlentities($_POST['suppr']);
	else
		$suppr = null;

	$infoRep = new reponse($reponseManagers->getReponseByID($idRep));

	if($userManagers->estAdmin($userId) || $userManagers->estMod($userId) || $reponseManagers->getIdUser() == $userId)
	{
		if(!is_null($infoRep->getIdRep()))
		{
?>
			<h2>Suppression de votre message</h2>
			<?php
			//vérif que l'utilisateur ait choisi s'il voulait supprimé ou non + récap du sujet
			if (empty ($suppr)) {
			?>
			<form action="#" method="post">
				<label for="descr">Votre message :</label>
				<br/>
				<textarea name="descr" id="descr" ><?php echo $infoRep->getDescrRep(); ?></textarea>	
				<script>
					CKEDITOR.replace( 'descr' );
				</script>
				<br/>
				
				<label for="suppr">Êtes-vous sûr de vouloir supprimer ce message ? </label>

				<input type="radio" name="suppr" value="true"> Oui
				<input type="radio" name="suppr" value="false"  checked="checked"> Non 
				<input type="hidden" name="id" value="<?php echo $idRep; ?>">


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
					$reponseManagers->del($idRep);
					?>
					<p class="success">Votre réponse a bien été supprimé</p>

					<?php
				}
				else
				{
				?>
					<p class="success">Vous n'avez pas supprimé votre réponse</p>
				<?php
				}
				redirection(5, "index.php");
			}
		}
		else
		{

		?>

			<div class="error"> Aucune réponse trouvée </div>

			<?php

			redirection(5, "index.php");

		}
	}
	else redirection(0, "index.php");

?>