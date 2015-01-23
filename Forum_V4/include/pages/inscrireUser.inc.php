<?php
	$db = new myPdo();
	$managerUser= new userManager($db); 
	$managerImg = new formatImageManager($db);

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

	if(empty($pseudo) || empty($login) || empty($pwd))
	{
	?>
		<h2>S'inscrire</h2>
		<form action="#" method="POST"  enctype="multipart/form-data">
			<label for="pseudo">Votre pseudo (utilisé dans le forum) :</label>
			<input type="text" name="pseudo" id="pseudo" />
			<br />
			<label for="login">Votre login (pour vous connecter) :</label>
			<input type="text" name="login" id="login" />
			<br />
			<label for="pwd">Votre mot de passe :</label>
			<input type="password" name="pwd" id="pwd" />
			<br />
			<label for="avatar">Votre avatar :</label>
			<input type="file" name="avatar" id="avatar" />
			<br />
			<div class="btn-group">
				<input type="submit" class="btn btn-success btn-xs" value="S'inscrire" />
				<input type="button" class="btn btn-danger btn-xs" value="Annuler" onclick="document.location='index.php'">
			</div>
		</form>
		<?php
	}
	else
	{	
		//cryptage du mdp envoyé
		$pass= md5($pwd);

		// Mise en place d'une image par défaut

		if(empty($_FILES['avatar']["name"])){
			$_FILES['avatar']['name'] = "anonyme-avatar.jpg";
			$_FILES['avatar']['tmp_name'] = getcwd() . "/image/default/anonyme-avatar.jpg";
			$_FILES['avatar']['type'] = "image/jpeg";
			$_FILES['avatar']['size'] = 5500;
			$_FILES['avatar']['error'] = 0;
		}

		// Si problème durant upload

		if ($_FILES['avatar']['error']> 0 ) {
			$erreur="erreur lors du transfert";
			echo "<p style='color:red'>" . $erreur . "</p>";
		}

		//Si tout c'est bien passé

		else {
			$extentionValide = $managerImg->getListFIValid();
			$extentionUpload =  strtolower(substr(strrchr($_FILES['avatar']['name'], '.'),1));
			//var_dump($_FILES);
			if(in_array($extentionUpload,$extentionValide)){

				$url = $managerUser->addImageUser($extentionUpload,$extentionValide,$_FILES['avatar']['tmp_name']);
				$user = new user(
				array(
					'pseudoUser'=>$pseudo,
					'loginUser'=>$login,
					'pwdUser'=>$pass,
					'estBLUser'=>false,
					'urlLogo'=>$url,
					'idDroit'=>3 // Simple utilisateur
					)
				);
				$managerUser->add($user);
				?>
				<p class="success">Vous avez été enregistré : <?php echo $_POST['pseudo']; ?></p> 
				<?php
			}
			else echo "<p class='error'> Erreur lors de la création de votre compte. </p>";
		}
	?>
		<?php
		redirection(5,"index.php");
	}
?>