<?php
	// connexion à la base de donnée
	$db = new myPdo();
	$catManagers = new categorieManager($db);
	$sujManagers= new sujetManager($db);
	$userManagers=new userManager($db);
	$reponseManagers = new reponseManager($db);
?>
<h1 class="row text-center">Forum</h1>

<?php
	// affiche les categories
	$listCat=$catManagers->getListCat();
	//verification que l'utilisateur a saisi ses identifiants
	if((empty($_SESSION['Log']) || empty($_SESSION['Pass'])))
	{	

		foreach($listCat as $categorie)
		{
?>
			<table class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
				<tr class="">
					<th class="col-lg-9 col-md-9 col-sm-9 col-xs-9">
						<h2>
							<?php 
								echo $categorie->getLibCat(); 
							?>
						</h2>
					</th>

					<th class="col-lg-3 col-md-3 col-sm-3 col-xs-3">

					</th>
				</tr>
			</table>
			<table class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
				<tr class="default">
					<th class="col-lg-1 col-md-1 col-sm-1 col-xs-1"><!-- Status --></th>
					<th class="col-lg-3 col-md-3 col-sm-3 col-xs-3">Sujet</th>
					<th class="col-lg-1 col-md-1 col-sm-1 col-xs-1"><!-- NbVue --></th>
					<th class="col-lg-3 col-md-3 col-sm-3 col-xs-3">Auteur</th>
					<th class="col-lg-1 col-md-1 col-sm-1 col-xs-1"><!-- NbRep --></th>
				</tr>
				<?php 
					// affiche les sujets
					$listSujet=$sujManagers->getListSujetsByCat($categorie->getIdCat());

					if(empty($listSujet)){
				?>

						<tr class="default">
							<td class="col-lg-1 col-md-1 col-sm-1 col-xs-1"> <!-- Status -->
									
							</td>
					
							<td class="col-lg-3 col-md-3 col-sm-3 col-xs-3"> <!-- Sujet -->
								<?php 
									echo "Aucun Sujet";
								?>
							</td>
							
							<td class="col-lg-1 col-md-1 col-sm-1 col-xs-1"> <!-- NbVue -->
								
							</td>
				
							<td class="col-lg-3 col-md-3 col-sm-3 col-xs-3"> <!-- Auteur --> 

							</td>
							
							<td class="col-lg-1 col-md-1 col-sm-1 col-xs-1"> <!-- NbRep -->

							</td>
						</tr>
				<?php

					}
					else{
						foreach($listSujet as $sujet)
						{
				?>
						<tr class="default">
							<td class="col-lg-1 col-md-1 col-sm-1 col-xs-1"> <!-- Status -->
								<?php 
									if($sujet->getEstFerme()==true){
										echo "[Fermé]";
									}
									else{
										echo "";
									}
								?>
							</td>
					
							<td class="col-lg-3 col-md-3 col-sm-3 col-xs-3"> <!-- Sujet -->
								<a href="index.php?page=4&id=<?php echo $sujet->getIdSujet();?>&nbVue=<?php echo $sujet->getNbVue()+1;?>">
									<?php 
										echo $sujet->getTitreSujet();
									?>
								</a>
							</td>
							
							<td class="col-lg-1 col-md-1 col-sm-1 col-xs-1"> <!-- NbVue -->
								<?php 
									$nbVue = $sujet->getNbVue();
									if($nbVue > 1){
										echo $nbVue . " vues";
									}
									else echo $nbVue . " vue";
								?>
							</td>
				
							<td class="col-lg-3 col-md-3 col-sm-3 col-xs-3"> <!-- Auteur --> 
								<?php				
									/* récupération du nom d'utilisateur a l'aide de user manager*/
									$res=$userManagers->getPseudoUserById($sujet->getIdUser());
									$idSujet = $sujet->getIdSujet();
									echo $res->pseudoUser;
								?>
							</td>
							
							<td class="col-lg-1 col-md-1 col-sm-1 col-xs-1"> <!-- NbRep -->
								<?php 
									$nbReponse = $reponseManagers->getNbReponseBySujet($idSujet);
									if($nbReponse > 1){
										echo $nbReponse . " réponses";
									}	
									else echo $nbReponse . " réponse";
								?>	
							</td>
						</tr>
				<?php
						} /* End FOREACH Sujet */
					}
				?>
			</table>
<?php
		} /* END FOREACH Categorie */
	} /* END IF UnLogged */
	else
	{	
		//récupération de l'id de l'utilisateur
		if(isset($_SESSION['id']))
			$userId=intval($_SESSION['id']->idUser);

?>
	<span class="">
		<?php 
			if($userManagers->estAdmin($userId))
				echo '<a class="btn btn-primary btn-xs" href="index.php?page=18">Ajouter une catégorie</a>';
			?>
	</span>
		<?php 
			foreach($listCat as $categorie)
			{
		?>		<table class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
					<tr class="cat">
						<th class="col-lg-9 col-md-9 col-sm-9 col-xs-9">
							<h2>
								<?php 
									echo $categorie->getLibCat(); 
								?>
							</h2>
						</th>

						<th class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
	
							<?php 
								if($userManagers->estAdmin($userId)){
									$idCat = $categorie->getIdCat();
							?>

							<div class='btn-group pull-right'>
									<a class="btn btn-success btn-xs" href="index.php?page=19&idCat=<?php echo $idCat ?>">
										Modifier
									</a>
									<a class="btn btn-danger btn-xs" href="index.php?page=20&idCat=<?php echo $idCat ?>"> 
										Supprimer 
									</a>
									<a class="btn btn-primary btn-xs" href="index.php?page=21&idCat=<?php echo $idCat ?>"> 
										Export XML 
									</a>  
							</div>

							<?php
								}
							?>
						</th>
					</tr>
				</table>
				<!--  <h2> -->
					<?php /*
						echo $categorie->getLibCat(); 
						if($userManagers->estMod($userId) || $userManagers->estAdmin($userId)){
							$idCat = $categorie->getIdCat();
						*/
					?>
						<!-- 
							<div class='btn-group pull-right'>
								<a class="btn btn-success btn-xs" href="index.php?page=19&idCat=<?php echo $idCat ?>"> Modifier </a>
								<a class="btn btn-danger btn-xs" href="index.php?page=20&idCat=<?php echo $idCat ?>"> Supprimer </a> 
							</div>
							-->
					<?php
						//}

					?>
				<!-- </h2> -->
				<div class="row col-lg-12 col-md-12 col-sm-12 col-xs-12">
					<span class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
						<a class="btn btn-primary btn-xs" href="index.php?page=5&cat=<?php echo $categorie->getIdCat();?>">
							Ajouter un sujet
						</a>
					</span>
				</div>
				<table class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
					<tr class="default">
						<!-- 
							<th>Status<th>
							<th>Sujet</th>
							<th>Nb Vues</th>
							<th>Auteur</th>
							<th>Nb reponses</th>
							<th>Modifier</th>
							<th>Supprimer</th>
						-->

						<th class="col-lg-1 col-md-1 col-sm-1 col-xs-1"><!-- Status --></th>
						<th class="col-lg-3 col-md-3 col-sm-3 col-xs-3">Sujet</th>
						<th class="col-lg-1 col-md-1 col-sm-1 col-xs-1"><!-- NbVues --></th>
						<th class="col-lg-3 col-md-3 col-sm-3 col-xs-3">Auteur</th>
						<th class="col-lg-1 col-md-1 col-sm-1 col-xs-1"><!-- NbRep --></th>
						<th class="col-lg-3 col-md-3 col-sm-3 col-xs-3"> <!-- Modif/Suppr --></th>
					</tr>
					<?php 
						// affiche les sujets
						$listSujet=$sujManagers->getListSujetsByCat($categorie->getIdCat());
						if(empty($listSujet)){

							?>

							<tr class="default">
								<td class="col-lg-1 col-md-1 col-sm-1 col-xs-1"> <!-- Status -->

								</td>
	
								<td class="col-lg-3 col-md-3 col-sm-3 col-xs-3"> <!-- Sujet -->
									<?php echo "Aucun sujet"; ?>
								</td>
		
								<td class="col-lg-1 col-md-1 col-sm-1 col-xs-1"> <!-- NbVues -->

								</td>
	
								<td class="col-lg-3 col-md-3 col-sm-3 col-xs-"> <!-- Auteur -->

								</td>
								
								<td class="col-lg-1 col-md-1 col-sm-1 col-xs-1"> <!-- NbRep -->

								<td class="col-lg-3 col-md-3 col-sm-3 col-xs-3"> <!-- Droits -->

								</td>
							</tr>
					<?php		

						}
						else{

							foreach($listSujet as $sujet)
							{
					?>
							<tr class="default">
								<td class="col-lg-1 col-md-1 col-sm-1 col-xs-1"> <!-- Status -->
									<?php 
										if($sujet->getEstFerme() == true){
											echo "[Fermé]";
										}
										else{
											echo "";
										}
									?>
								</td>
	
								<td class="col-lg-3 col-md-3 col-sm-3 col-xs-3"> <!-- Sujet -->
									<a href="index.php?page=4&id=<?php echo $sujet->getIdSujet();?>&nbVue=<?php echo $sujet->getNbVue()+1;?>">
										<?php 
											echo $sujet->getTitreSujet();
										?>		
									</a>
								</td>
		
								<td class="col-lg-1 col-md-1 col-sm-1 col-xs-1"> <!-- NbVues -->
									<?php
											$nbVue = $sujet->getNbVue();
											if($nbVue > 1){
												echo $nbVue . " vues </td>";
											}
											else echo $nbVue . " vue </td>"; 
									?>
								</td>
	
								<td class="col-lg-3 col-md-3 col-sm-3 col-xs-3"> <!-- Auteur -->
									<?php /* récupération du nom d'utilisateur a l'aide de user manager*/
										$res=$userManagers->getPseudoUserById($sujet->getIdUser());
										$idSujet = $sujet->getIdSujet();
										echo $res->pseudoUser;
									?>
								</td>
								
								<td class="col-lg-1 col-md-1 col-sm-1 col-xs-1"> <!-- NbRep -->
									<?php 
										$nbReponse = $reponseManagers->getNbReponseBySujet($idSujet);
										if($nbReponse > 1){
											echo $nbReponse . " réponses ";
										}
										else echo $nbReponse . " réponse"; 
									?>
								</td>		
				
									<?php 
										// vérifier si l'utilisateur est admin ou modérateur ou c'est le propriétaire 
										if($userManagers->estAdmin($userId)|| $userManagers->estMod($userId) || $userManagers->estPropr($userId,$sujet->getIdSujet()))
										{	
									?>
											<td class="col-lg-3 col-md-3 col-sm-3 col-xs-3"> <!-- Droit -->
												<div class="pull-right btn-group">
													<a class="btn btn-success btn-xs" href="index.php?page=6&id=<?php echo $sujet->getIdSujet();?>"> 
														Modifier
													</a>
													<a class="btn btn-danger btn-xs" href="index.php?page=7&id=<?php echo $sujet->getIdSujet();?>"> 
														Supprimer
													</a>
												</div>
											</td>
									<?php
										}
										else
										{
									?>
											<td class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
												Aucun droit de modification/suppression
											</td>
									<?php
										}
									?>
							</tr>
					<?php	
							} /* END FOREACH Sujet */
						}
					?>
				</table>

<?php
			}/* END FOREACH Categorie */
			if($userManagers->estAdmin($userId))
			{

			?>
				<a class="btn btn-warning btn-xs" href="index.php?page=22">Import XML </a>
			<?php
			}

	}/* END ELSE Logged */
?>