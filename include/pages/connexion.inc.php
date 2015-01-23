<?php
	
	$db = new myPdo();
	$managerUser = new userManager($db);

	if(isset($_POST['login']))
		$login = htmlentities($_POST['login']);
	else
		$login = null;

	if(isset($_POST['pass']))
		$pass = htmlentities($_POST['pass']);
	else 
		$pass = null;

	if( ( empty($pass) || empty($login) ) && ( empty($_SESSION['Log']) || empty($_SESSION['Pass']) ) )
	{

	?>
	
		<form action="#" method="post">
			<label for="login">Identifiant :</label>
			<input type="text" name="login" id="login" />
		
			<label for="pass">Mot de passe :</label>
			<input type="password" name="pass" id="pass" />
		
			<br />
			<input class="btn btn-success btn-sm" type="submit" name="Submit" value="Valider" />
		</form>
	
	<?php

	}
	else
	{
		$_SESSION['Pass'] = md5($pass);
		$_SESSION['Log'] = $login;

		$MDP = $_SESSION['Pass'];

		$estMDPValide = $managerUser->estMDPValide($_SESSION['Log'], $MDP);

		if($estMDPValide['valide']==false)
		{
			session_unset();
			
		?>
			<div class="error">Identifiant ou mot de passe incorrect</div>
			<a href="index.php? <?php echo $_SERVER['QUERY_STRING']; ?> " > Réessayer </a>
		<?php
			//redirection(5,"index.php?" . $_SERVER['QUERY_STRING']);
		}
		else
		{

		?>
			<div class="success">Identification réussie</div>
		<?php
			$_SESSION['id'] = $estMDPValide['id'];
			redirection(5, "index.php");
		}
	}
?>
	