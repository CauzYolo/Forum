<?php 

	$db= new myPdo();
	$userManagers=new userManager($db);

	if(isset($_SESSION['id']))
		$userId = intval($_SESSION['id']->idUser);
	else
		$userId = -1;

	if(isset($_GET['id']))
		$idMembre = htmlentities($_GET['id']);
	else
		$idMembre = null;

	if(isset($_POST['suppr']))
		$suppr = htmlentities($_POST['suppr']);
	else
		$suppr = null;

	if($userManagers->estAdmin($userId))
	{
		$membre = new user($userManagers->getContactById($idMembre));

		if(!is_null($membre->getIdUser()))
		{

			// message de confirmation de supression de l'utilisateur
			if(empty($suppr))
			{
				?>
				<form method="POST" action="#">
					<label>Êtes-vous sûr de vouloir supprimer l'utilisateur <?php echo $membre->getPseudoUser(); ?> ?</label><br/>
					<input type= "radio" name="suppr" value="true"> Oui</input><br/>
					<input type= "radio" name="suppr" checked="checked" value="false"> Non </input><br/>
					<input class="btn btn-success btn-xs" type="submit" name="Submit" value="Valider" />
				</form>
				<?php
			}
			else
			{
				if($suppr == 'true')
				{
					if($userManagers->estAdmin($idMembre))
					{
						?>
						<p>Vous n'avez pas l'autorisation de supprimer un administrateur.</p>
						<?php
					}
					else
					{
						$userManagers->delete($idMembre);
						?>
						<p class="success">L'utilisateur <?php echo $membre->getPseudoUser(); ?> a bien été supprimé.</p>
						<?php
					}
				}
				if($suppr == 'false')
				{
					?>
					<p class="success">Vous n'avez pas supprimé l'utilisateur <?php echo $membre->getPseudoUser(); ?></p>
					<?php
				}
					redirection(5, "index.php");
			}
		}
		else
		{
		
		?>
			<div class="error"> Aucun utilisateur trouvé </div>

			<?php

			redirection(5, "index.php");

		}
	}
	else 
		redirection(0, "index.php");
?>