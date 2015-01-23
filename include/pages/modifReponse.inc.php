<?php
	
	$db = new myPdo();
	$reponseManagers = new reponseManager($db);
	$userManagers = new userManager($db);

	if(isset($_GET['id']))
		$idReponse = htmlentities($_GET['id']);
	else 
		$idReponse = null;

	if(isset($_POST['descr']))
		$descr = $_POST['descr'];
	else
		$descr = null;

	if(isset($_SESSION['id']))
		$userId = intval($_SESSION['id']->idUser);
	else
		$userId = -1;

	$reponse = $reponseManagers->getReponseByID($idReponse);


	if($userManagers->estAdmin($userId) || $userManagers->estMod($userId) || $reponse->getIdUser() == $userId)
	{

		if(!is_null($reponse->getIdRep()))
		{

			$infoReponse = new reponse($reponse);
			unset($reponse); //Detruire la variable réponse 


	?>
			 <h2>Modification de votre réponse </h2> 
			<?php
			// vérif que l'utilisateur est passé et souhaite modifier + sujet avec tous ces champ prérempli
			if(empty($descr))
			{
			?>
			 
			<form action="#" method="post">
				<label for="descr">Votre réponse :</label>
				<br/>
				<textarea name="descr" id="descr" ><?php echo $infoReponse->getDescrRep(); ?></textarea>	
				<script>
				CKEDITOR.replace("descr");
				</script>
				<br/>

				<!-- Nous cachons l'id du sujet car l'utilisateur n'a pas l'utilité de le connaitre et il nous servira pour la mod'ification d'un seul élément et non toute la base -->
				<input type="hidden" name="id" value="<?php echo $userId; ?>">

				<br />
				<div class="btn-group">
					<input class="btn btn-success btn-xs" type="submit" name="Submit" value="Valider" />
					<input class="btn btn-danger btn-xs" type="button" name="reset" value="Annuler" onclick="document.location='index.php'" />			
				</div>
			</form>
			
			<?php
			}
			else
			{
				$userId=intval($_SESSION['id']->idUser);
				$newReponse= new reponse(
					array(
					'idRep'=>$infoReponse->getIdRep(),
					'dateRep'=> date("Y-m-d"),
					'descrRep'=>$_POST['descr'],
					'modification'=>"1",
					)
				);
				$reponseManagers->update($newReponse);
				?>
				<p class="success">Votre réponse a bien été modifiée.</p>
				<?php
				redirection(5, $_SERVER['PHP_SELF']);
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