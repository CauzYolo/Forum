<?php 

	$db = new myPdo();
	$userManagers = new userManager($db);

	if(isset($_SESSION['id']))
		$userId = intval($_SESSION['id']->idUser);
	else 
		$userId = -1;

	if(isset($_GET['id']))
		$idUser = htmlentities($_GET['id']);
	else
		$idUser = null;

	$membre = new user($userManagers->getContactById($idUser));

	if( ( $userManagers->estAdmin($userId) || $userManagers->estMod($userId) || $userId == $idUser)  && (!is_null($membre->getIdUser() ) ) )
	{
		//récapitulatif du profil
	?>

		<h2>Détail du profil de <?php echo $membre->getPseudoUser(); ?></h2>
		<p>
			Pseudo : <?php echo $membre->getPseudoUser(); ?>
		</p>
		<p>
			Login :
			<?php echo $membre->getLoginUser(); ?>
		</p>
		<p>Avatar : </p>
		<?php 
			$avatar=$membre->getUrlLogo();
			if(empty($avatar)){
				echo "Aucun avatar";
			}
			else{
		?>
				<img src="<?php echo $membre->getUrlLogo(); ?>" alt="Avatar de <?php echo $membre->getPseudoUser(); ?>" title="Avatar de <?php echo $membre->getPseudoUser(); ?>" /><br />

		<?php
			} 
		//Affichage pour un modérateur
		$estBL = $userManagers->estBLUser($userId);
		if($userManagers->estMod($userId))
		{
			//Modification uniquement pour blacklister
			?>
			<p>Black listé :
			<?php
			 if ($membre->getEstBLUser())
			{
				echo " Oui";
			}
			else
			{
				echo " Non";
			}
		}
		//Affichage pour un administrateur
		if($userId == $idUser && !$userManagers->estAdmin($userId) || $userManagers->estMod($userId))
		{
			//Modification du profil
			?>
			<div>
				<a class="btn btn-success btn-xs" href="index.php?page=14&id=<?php echo $membre->getIdUser();?>">
					Modifier
				</a>
			</div>
			 <br/> 
			<?php
		}
		if($userManagers->estAdmin($userId))
		{
			//Modification complète 
			?>
			<div class="btn-group">
				<a class="btn btn-success btn-xs" href="index.php?page=14&id=<?php echo $membre->getIdUser();?>">
					Modifier
				</a>

				<!-- Suppression de l'utilisateur-->
				<a class="btn btn-danger btn-xs" href="index.php?page=15&id=<?php echo $membre->getIdUser();?>">
					Supprimer
				</a> 

				<a class="btn btn-primary btn-xs" href="index.php?page=2">
					Membres
				</a> 
			</div>
			<?php
			
		}
	}
	else redirection(0, "index.php");
?>