<?php
	
	$db = new myPdo();
	$managerSujets = new sujetManager($db); 
	$userManagers = new userManager($db);


	if(isset($_SESSION['id']))
		$userId = htmlentities($_SESSION['id']->idUser);
	else
		$userId = -1;

	if(isset($_POST['titre']))
		$titre = htmlentities($_POST['titre']);
	else
		$titre = null;

	if(isset($_POST['descr']))
		$descrSujet = $_POST['descr'];
	else
		$descr = null;

	if(isset($_GET['cat']))
		$categorie = htmlentities($_GET['cat']);
	else
		$categorie = null;

	if(empty($titre) || empty($descrSujet) || empty($categorie))
	{

	?>

		<h2>Ajouter un sujet</h2>
		<form action="#" method="post">
			<label for="titre">Titre du sujet :</label>
			<input type="text" name="titre" id="titre" />
			<br />
			<label for="descr">Description du sujet :</label>
			<textarea name="descr" id="descr">
			</textarea>	
			<script>
				CKEDITOR.replace( 'descr' );
			</script>
			<input type="hidden" name="cat" id="<?php echo "cat".$categorie; ?>" value="<?php echo "cat".$categorie; ?>"/>
			<br />
			<div class="btn-group">
					<input class="btn btn-success btn-xs" type="submit" name="Submit" value="Valider" />
					<input class="btn btn-danger btn-xs" type="button" name="Annuler" value="Annuler" onclick="document.location='index.php'" />
			</div>			
		</form>

	<?php

	}
	else
	{	
	
		$cat=str_replace("cat","",$categorie);
		$sujet = new sujet(
			array(
				'titreSujet'=>$titre,
				'dateSujet'=>date("Y-m-d"),
				'descrSujet'=>$descrSujet,
				'nbVue'=>0,
				'estFerme'=>0,
				'idUser'=>$userId,
				'idCat'=>intval($cat)
			)
		);
		
		$managerSujets->add($sujet);

		?>

		<p class="success">Le sujet <?php echo $titre; ?> a été enregistré</p>

		<?php

		redirection(5, $_SERVER['PHP_SELF']);
	}
?>