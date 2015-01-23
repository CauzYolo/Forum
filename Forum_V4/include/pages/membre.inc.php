<?php

	$db = new myPdo();
	$userManagers = new userManager($db);
	$sujManagers= new sujetManager($db);

	if(isset($_SESSION['id']))
		$userId = intval($_SESSION['id']->idUser);
	else 
		$userId = -1;

	$listMembres=$userManagers->affContact();
	?>
	<h2>Membres</h2>

	<form>
	<table class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		<tr>
			<td class="col-lg-1 col-md-1 col-sm-1 col-xs-1"><!-- Pseudo --></td>
			<td class="col-lg-1 col-md-1 col-sm-1 col-xs-1"><!-- Nb Sujet --></td>
			<td class="col-lg-1 col-md-1 col-sm-1 col-xs-1"> <!-- Nb Commentaire --> </td>
			<?php
			if($userManagers->estMod($userId))
			{
				?>
				<td class="col-lg-9 col-md-9 col-sm-9 col-xs-9"> <!-- Droits --></td>
				<?php
			}
			?>
		</tr>

	<?php
	foreach ($listMembres as $membre) {
		?>
		<tr>
			<td class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
				<?php 
				if($userManagers->estAdmin($userId)||$userManagers->estMod($userId)|| $userId == $membre->getIdUser() )
				{
					?>
					<a class="btn btn-link btn-sm" href="index.php?page=1&id=<?php echo $membre->getIdUser();?>">
						<?php echo $membre->getPseudoUser(); ?>
					</a>
					<?php
				}
				else
				{
					echo $membre->getPseudoUser();
				}
				
				?>
			</td>
			<td class="col-lg-1 col-md-1 col-sm-1 col-xs-1">
				<?php 
					$nbSujet = $sujManagers->nbSujetByUser($membre->getIdUser());
					if($nbSujet > 1)
						echo $nbSujet . " sujets";
					else 
						echo $nbSujet . " sujet";
					?>
			</td>
			<td class="col-lg-1 col-md-1 col-sm-1 col-xs-1">
				<?php 
					$nbCommentaires = $sujManagers->nbCommentaireByUser($membre->getIdUser());
					if($nbCommentaires > 1)
						echo $nbCommentaires . " com.";
					else
						echo $nbCommentaires . " coms.";

					?>
			</td>
			<?php
			//l'utilisateur loggé est un modérateur
			if($userManagers->estMod($userId))
			{
				?>
				<td class="col-lg-9 col-md-9 col-sm-9 col-xs-9">
				<?php
					//l'utilisateur loggé est un administrateur
					if($userManagers->estAdmin($userId))
					{
					//le membre est un modérateur ou un administrateur
						if($userManagers->estAdmin($membre->getIdUser()))
						{
							?>
							<div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
								<input type="checkbox" name="estAd" value="true" disabled="disabled" checked /> Administrateur
							</div>
							<?php
						}
						else
						{
							?>
							<div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
								<input type="checkbox" name="estAd" value="false" disabled="disabled" /> Administrateur
							</div>
							<?php
						}
						if($userManagers->estMod($membre->getIdUser()))
						{
							?>
							<div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
								<input type="checkbox" name="estMod" value="true" disabled="disabled" checked /> Modérateur
							</div>
							<?php
						}
						else
						{
							?>
							<div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
								<input type="checkbox" name="estMod" value="false" disabled="disabled" /> Modérateur
							</div>
							<?php
						}
					}
				//le membre est il blaclisté
					$estBLUser = $userManagers->estBLUser($membre->getIdUser());
					//var_dump($estBLUser);
				if($estBLUser == true)
				{
					?>
					<div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
						<input type="checkbox" name="estBL" value="true" disabled="disabled" checked /> Blacklisté
					</div>
					<?php
				}
				else
				{
					?>
					<div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
						<input type="checkbox" name="estBL" value="false" disabled="disabled" /> Blacklisté
					</div>
					<?php
				}
				?>
				</td>
				<?php

			}
			?>
		</tr>
		<?php
	}
	?>
	</table>
	</form>
