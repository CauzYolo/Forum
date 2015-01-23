<h2>Se déconnecter</h2>
<?php

	if(isset($_SESSION['id']))
		$userId = intval($_SESSION['id']->idUser);
	else
		$userId = -1;

	if(isset($_POST['deconnect']))
		$deconnect = $_POST['deconnect'];
	else 
		$deconnect = null;

	if($userId != -1){

		if(empty($deconnect))
		{
		?>
			<form action='#' method="POST">
				<?php
				echo "Êtes-vous sûr de  vouloir vous déconnecter ?";
				?>
				<br/><br>
				<label>
					<input type="radio" name="deconnect" value="true">
						Oui
					</input>
				</label>
				<br/>
				<label>
					<input type="radio" name="deconnect" checked="checked" value="false">
						Non
					</input>
				</label>
				<br/><br/>
				<input class="btn btn-success btn-sm" type="submit" value="Valider"/>
			</form>
			<?php
		}
		else
		{
			if($deconnect=="true")
			{
				session_unset();
				//unset($_SESSION['Pass']);
				//session_commit();
			?>
				<div class="success">
					Déconnection réussie
				</div>
			<?php
				redirection(5, "index.php");
				//header("Location: index.php");
			}
			else
			{
				redirection(0, "index.php");
				//header("Location: index.php?page=3");
			}
		}
	}
	else 
		redirection(0, "index.php");
?>

		