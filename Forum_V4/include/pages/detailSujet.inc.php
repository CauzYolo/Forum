<?php
	// connexion à la base de donnée


	$db = new myPdo();
	$categorieManagers = new categorieManager($db);
	$sujetManagers = new sujetManager($db);
	$userManagers = new userManager($db);
	$reponseManagers = new reponseManager($db);

?>
	<h1 class="row text-center">Sujet</h1>
	<?php

	// affiche le sujet

	if(isset($_GET['id']))
		$idSujet = intval(htmlentities($_GET['id']));
	else 
		$idSujet = null;

	//récupération du nombre de vue du sujet
	$nbVues=$_GET['nbVue'];
	// mise a jour du nombre de vues
	$sujetManagers->updateNbVue($idSujet,$nbVues);

	if(!is_null($sujetManagers->getSujetsByID($idSujet)->getIdSujet()))
		$infoSujet = new sujet($sujetManagers->getSujetsByID($idSujet));
	else 
		redirection(0, "index.php");

	$idCreateurSujet = $userManagers->getPseudoUserById($infoSujet->getIdUser());

	$createurSujet = new user($userManagers->getContactById($infoSujet->getIdUser()));

	if(isset($_SESSION['id']))
		$userId = intval($_SESSION['id']->idUser);
	else $userId = -1;

	?>
	<h1>
		<?php
		if($infoSujet->getEstFerme() == true){
			echo "[Fermé] ";
		}
		echo "Sujet : ";
		echo $infoSujet->getTitreSujet();
	?>
	</h1>
	<?php
		echo "<div class='col-lg-2 col-md-2 col-sm-2 col-xs-2 pull-right'>";
		$nbVues = $infoSujet->getNbVue();
		echo $nbVues ;
		if($nbVues > 1){
			echo " vues";
		}
		else echo " vue";
		echo "</div>";
		?>
	<hr class='row col-lg-12 col-md-12 col-sm-12 col-xs-12'/>
	<?php

	echo "<div class='row col-lg-12 col-md-12 col-sm-12 col-xs-12'>";
	echo "<div class='user row col-lg-2 col-md-2 col-sm-2 col-xs-2'>";
	echo $createurSujet->getPseudoUser();
	?>
		<img src="<?php echo $createurSujet->getUrlLogo(); ?>" alt="Avatar de <?php echo $createurSujet->getPseudoUser(); ?>" title="Avatar de <?php echo $createurSujet->getPseudoUser(); ?>" /><br />
	<?php
		echo "</div>";

		echo "<div class='descrSujet col-lg-10 col-md-10 col-sm-10 col-xs-10'>";
		echo "<div class='date'>";
		echo " Posté le " . $infoSujet->getDateSujet();
		echo "</div>";
		echo $infoSujet->getDescrSujet();
		echo "</div>";
		echo "</div>"
		?>

	<hr class="row col-lg-12 col-md-12 col-sm-12 col-xs-12"/>
	<h3 class="row text-center"> Réponses </h3>
	<hr/>
	<?php
	// vérif admin ou moderateur ou propriétaire -> possibilité de modifier , supprimer
	
	// affiche les réponses

	$listReponse = $reponseManagers->getReponseBySujet($idSujet);

	if(!empty($listReponse)){
		foreach ($listReponse as $rep) {
			$reponse = new reponse($rep);
			$userIdRep = $reponse->getIdUser();

			echo "<div class=' row col-lg-12 col-md-12 col-sm-12 col-xs-12'>";
			$userReponse = new user($userManagers->getContactById($userIdRep));
			$pseudoUserReponse = $userReponse->getPseudoUser();
			echo "<div class='user row col-lg-2 col-md-2 col-sm-2 col-xs-2'>";
			echo $pseudoUserReponse;
			?>
			<img src="<?php echo $userReponse->getUrlLogo(); ?>" alt="Avatar de <?php echo $userReponse->getPseudoUser(); ?>" title="Avatar de <?php echo $userReponse->getPseudoUser(); ?>" /><br />
			<?php
			echo "</div>";
			echo "<div class='descrSujet col-lg-10 col-md-10 col-sm-10 col-xs-10'>";
			echo "<div class='date'>";
			if($userId == $userIdRep || $userManagers->estMod($userId) || $userManagers->estAdmin($userId)){
				echo "<div class='pull-right btn-group btn-group-xs'>";
				$idRep = $reponse->getIdRep();
				echo '<a class="btn btn-success" href="index.php?page=16&id='.$idRep.'">Modifier</a>';
				echo '<a class="btn btn-danger" href="index.php?page=17&id='.$idRep.'">Supprimer</a>';
				echo "</div>";
			}
			$modif = $reponse->getModification();
			if($modif != "0"){
				echo " Modifiée le ";
			}
			else echo "Le ";
			echo $reponse->getDateRep();
			echo "</div>";
			echo $reponse->getDescrRep();
			echo "</div>";
			echo "</div>";
			echo "<hr class='col-lg-12 col-md-12 col-sm-12 col-xs-12'/>";
		}
	}

	if($infoSujet->getEstFerme() == false){
		if($userManagers->estBLUser($userId) == true){

		}
	}

	if($infoSujet->getEstFerme() == false && $userManagers->estBLUser($userId) == false)
	{
		include_once 'ajoutReponse.inc.php';
	}
	else if($infoSujet->getEstFerme() == false && $userId == -1){
		include_once 'ajoutReponse.inc.php';
	}
	
?>