<div class="row footer">
	<?php
		$url = $_SERVER['PHP_SELF'];
		if(!empty($_SERVER['QUERY_STRING'])) $url = $url ."?" . $_SERVER['QUERY_STRING'];
		if($url != $_SERVER['PHP_SELF']){
	?>
			<a class="btn btn-default btn-xs" href="index.php"> Retour à l'accueil </a>
	<?php
		}

		if(isset($_POST['login'])){
			$login = htmlentities($_POST['login']);
		}
		else $login = null;
		if(isset($_POST['pass'])){
			$pass = htmlentities($_POST['pass']);
		}
		else $pass = null;
		if ( ( !empty($pass) && !empty($login) ) || ( !empty($_SESSION['Log']) && !empty($_SESSION['Pass']) ) )
		{
	?>
	<div class="adminBot">
		<a href="index.php?page=2">Administration</a>
	</div>
	<?php
		}
	?>
	<div class="visite pull-right">
		<?php
			require_once('pages/comptVisite.php');
		?>
	</div>
	

</div>

