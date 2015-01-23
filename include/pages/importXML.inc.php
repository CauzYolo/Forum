<?php
	
	$db = new myPdo();
	$categorieManagers = new categorieManager($db);
	$userManagers = new userManager($db);
	$sujetManagers = new sujetManager($db);
	$reponseManagers = new reponseManager($db);


	if(isset($_SESSION['id']))
		$userId = intval($_SESSION['id']->idUser);
	else
		$userId = -1;

	if($userManagers->estAdmin($userId) || $userManagers->estMod($userId))
	{
    
		if(empty($_FILES['xml']['name']))
		{

?>			<h2>Importation de XML</h2>
			<form action="#" method="POST"  enctype="multipart/form-data">
				<label for="avatar">Votre fichier :</label>
				<input type="file" name="xml" id="xml" />
				<br />
				<div class="btn-group">
					<input type="submit" class="btn btn-success btn-xs" value="Importer" />
					<input type="button" class="btn btn-danger btn-xs" value="Annuler" onclick="document.location='index.php'">
				</div>
			</form>

	<?php

		}
		else
		{
			$export_xml = simplexml_load_file($_FILES['xml']['name']);
			foreach ($export_xml->categorie as $categorie) {
				echo "id de la catégorie : {$categorie->idCat} <br/>\n";
		    	echo "Nom de la categorie: {$categorie->nom} <br />\n";
		    	$cat = new categorie(array('idCat' => $categorie->idCat,'libCat' => $categorie->nom));
		    	$categorieManagers->update($cat);
				foreach ($categorie->sujet as $sujet) {
					echo "Id du Sujet : {$sujet->idSujet} <br/> \n";
					echo "Titre du sujet: {$sujet->titre} <br />\n";
					echo "Auteur du sujet : {$sujet->auteur} <br/> \n";
					echo "Date du sujet : {$sujet->dateSujet} <br/> \n";
					echo "Nombre de vues : {$sujet->nbVues} <br/> \n";
					echo "Sujet fermé : {$sujet->estFerme} <br/> \n";
					$contenu = str_replace("[", "<", $sujet->description);
		            $sujet->description = $contenu;
		            $contenu = str_replace("]", ">", $sujet->description);
		            $sujet->description = $contenu;
					echo "Description du sujet: {$sujet->description} <br />\n";					
					$nouvSujet = new sujet(array(
							'idSujet' => $sujet->idSujet,
							'titreSujet' => $sujet->titreSujet,
							'dateSujet' => $sujet->dateSujet,
							'descrSujet' => $sujet->description,
							'nbVues' => $sujet->nbVues,
							'estFerme' => $sujet->estFerme,
							'idUser' => $sujet->auteur,
							'idCat'=> $categorie->idCat
						)
					);
					$sujetManagers->update($nouvSujet);
					foreach ($sujet->reponse as $reponse) {
						echo "id de la reponse : {$reponse->idRep} <br/> \n";
						echo "Auteur de la réponse : {$reponse->utilisateur} <br/> \n";
						echo "Date de la réponse : {$reponse->dateReponse} <br/> \n";
						$contenu = str_replace("[", "<", $reponse->message);
			            $reponse->message = $contenu;
			            $contenu = str_replace("]", ">", $reponse->message);
			            $reponse->message = $contenu;
						echo "Message : {$reponse->message} <br />\n";
						$rep = new reponse(array(
								'idRep'=>$reponse->idRep,
								'dateRep' => $reponse->dateReponse,
								'descrRep' => $reponse->message,
								'modification' => 0,
								'idSujet' => $sujet->idSujet,
								'idUser' => $reponse->utilisateur
							)
						);
						$reponseManagers->update($rep);
					}
				}
			}
		}
	}
	else 
		redirection(0, "index.php");

?>