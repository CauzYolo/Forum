<?php 

	$db = new myPdo();
	$userManagers = new userManager($db);
	$formatImageManagers = new formatImageManager($db);

	if(isset($_SESSION['id']))
		$userId = intval($_SESSION['id']->idUser);
	else
		$userId = -1;

	if(isset($_GET['id']))
		$idMembre = htmlentities($_GET['id']);

	if(isset($_POST['pseudo']))
		$pseudo = htmlentities($_POST['pseudo']);
	else
		$pseudo = null;

	if(isset($_POST['login']))
		$login = htmlentities($_POST['login']);
	else
		$login = null;

	if(isset($_POST['pwd']))
		$pwd = htmlentities($_POST['pwd']);
	else
		$pwd = null;

	if(isset($_POST['blacklist']))
		$blacklist = htmlentities($_POST['blacklist']);
	else
		$blacklist = "false";

	if(isset($_POST['grade']))
		$grade = htmlentities($_POST['grade']);
	else
		$grade = "3";

	if($userManagers->estAdmin($userId) || $userManagers->estMod($userId) || $userId == $idMembre )
	{

		$membre = new user($userManagers->getContactById($idMembre));

		if(!is_null($membre->getIdUser()))
		{

			if(empty($login) ||  empty($pseudo))
			{
			?>
				<h2>Modifier</h2>
				<form action="#" method="POST" enctype="multipart/form-data">
					<label for="pseudo">Votre pseudo (Utilisé dans le forum) :</label>
					<input type="text" name="pseudo" id="pseudo" value="<?php echo $membre->getPseudoUser(); ?>"/>
					<br />
					<label for="login">Votre login (Utilisé pour vous connecter) :</label>
					<input type="text" name="login" id="login" value="<?php echo $membre->getLoginUser(); ?>"/>
					<br />
					<label for="pwd">Votre mot de passe (Laisser vide pour aucune modification) :</label>
					<input type="password" name="pwd" id="pwd" />
					<br />
					<label>Votre avatar (Ne rien upload pour aucune modification) :</label>
					<img class="avatar" src="<?php echo $membre->getUrlLogo(); ?>" alt="Avatar de <?php echo $membre->getPseudoUser(); ?>" title="Avatar de <?php echo $membre->getPseudoUser(); ?>" /><br />

					<input type="file" name="avatar" id="avatar" />
					<br />
					<?php
						if($userManagers->estMod($userId))
						{
							?>
							<p>Liste noire : </p>
							<?php
							if($membre->getEstBLUser())
							{
								?>
								<input type="radio" name="blacklist" value="true" checked/> Oui<br/>
								<input type="radio" name="blacklist" value="false"/> Non<br/>
								<?php
							}
							else
							{
								?>
								<input type="radio" name="blacklist" value="true"/> Oui<br/>
								<input type="radio" name="blacklist" value="false" checked/> Non<br/>
								<?php
							}
						}
						if($userManagers->estAdmin($userId))
						{
						?>
							<p>Grade : </php>
							<select name="grade">
								<?php 
								if($membre->getIdDroit() == 3)
								{
									?>
									<option value="3" selected>Membre</option>
									<?php
								}
								else
								{
									?>
									<option value="3">Membre</option>
								<?php
								}	
								if($membre->getIdDroit() == 2)
								{
								?>							
								<option value="2" selected>Modérateur</option>
								<?php
								}
								else
								{
								?>
									<option value="2">Modérateur</option>
								<?php
								}
								if($membre->getIdDroit() == 1)
								{
								?>
									<option value="1" selected>Administrateur</option>
								<?php
								}
								else
								{
								?>
									<option value="1">Administrateur</option>
								<?php
								}
								?>
							</select> 
							<br />
							<?php
						}
						?>
					<div class="btn-group">
						<input class="btn btn-success btn-xs" type="submit" name="Submit" value="Valider" />
						<input class="btn btn-danger btn-xs" type="button" name="reset" value="Annuler" onclick="document.location='index.php'" />			
					</div>
				</form>
			<?php
			}
			else
			{	
				//cryptage du mdp envoyé
				if(!empty($pwd))
				{
					$pass= md5($pwd);
				}
				else
				{
					$pass = $membre->getPwdUser();
				}

				if($blacklist == "true")
				{
					$bl = true;
				}
				else
				{
					$bl = false;
				}
					
				if(!empty($_FILES['avatar']['tmp_name']))
				{
					// on efface l'image si l'utilisateur en a auparavant une
					if ($membre->getUrlLogo() != "")
					{
						$delAvatar = unlink($membre->getUrlLogo());
						if (!$delAvatar) {
							echo "erreur lors de la suppression de l'image";
						}
					}
					
					if ($_FILES['avatar']['error']> 0 ) {
						$erreur="erreur lors du transfert";
					}
					else {
						$extentionValide = $formatImageManagers->getListFIValid();
						$extentionUpload =  strtolower(substr(strrchr($_FILES['avatar']['name'], '.'),1));

						if(in_array($extentionUpload,$extentionValide)){
						$url=$userManagers->addImageUser($extentionUpload,$extentionValide,$_FILES['avatar']['tmp_name']);

						$user = new user(
							array(
								'idUser'=>$membre->getIdUser(),
								'pseudoUser'=>$pseudo,
								'loginUser'=>$login,
								'pwdUser'=>$pass,
								'estBLUser'=>$bl,
								'urlLogo'=>$url,
								'idDroit'=>$grade
								)
							);
						}
					}
				}
				else
				{
					$user = new user(
					array(
						'idUser'=>$membre->getIdUser(),
						'pseudoUser'=>$pseudo,
						'loginUser'=>$login,
						'pwdUser'=>$pass,
						'estBLUser'=>$bl,
						'urlLogo'=>$membre->getUrlLogo(),
						'idDroit'=>$grade
						)
					);
				}
				$userManagers->update($user);
				?>
				<p class="success">Votre profil a bien été modifié <?php echo $pseudo; ?></p>
				<?php
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
	else redirection(0, "index.php");
?>