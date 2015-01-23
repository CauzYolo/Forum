<header class="row header">
	<?php 
		include_once('autoLoad.php');
		require_once('include/redirection.php');
		$db = new myPdo();
		$userManagers = new userManager($db);
		
		if(isset($_GET['page'])){
			$page = htmlentities($_GET['page']);
		}
		else
			$page = 3;

		if(isset($_POST['login']))
			$login = htmlentities($_POST['login']);
		else
			$login = null;

		if(isset($_POST['pass']))
			$pass = htmlentities($_POST['pass']);
		else 
			$pass = null;

		//récupération de l'id de l'utilisateur
		if(isset($_SESSION['id']))
			$userId = intval($_SESSION['id']->idUser);
		else
			$userId = -1;
	
		if($page != 11 && $page != 12){
			if((empty($login) || empty($pass))&&(empty($_SESSION['Log']) || empty($_SESSION['Pass'])))
			{
	?>
			<div class="connect pull-right btn-group">	
				<a class="btn btn-default btn-sm" class="btn" href="index.php?page=11">Se connecter</a>
				<a class="btn btn-primary btn-sm"  class="btn" href="index.php?page=13">S'inscrire</a>
			</div>
	<?php
		
			}
			else
			{	
				
				//récupération de son nom (variable indexée)
				$nom = $userManagers->getPseudoUserById($userId)->pseudoUser;
	?>
				<div class="connect pull-right btn-group">
				<a class="btn btn-link btn-sm"  href="index.php?page=1&id=<?php echo $userId ?>" > <?php echo $nom ?> </a>
				<a class="btn btn-default btn-sm" href="index.php?page=12">Se déconnecter</a>
			</div>
		<?php

			}
		}
	?>
</header>

