<?php
	//$reponseManager = new reponseManager();
	if($userId != -1){

		if(isset($_POST['reponse']))
			$contentReponse = $_POST['reponse'];
		else $contentReponse = null;

		if (isset($contentReponse)) {
			$reponse = new reponse(
				array(
					'dateRep' => date('Y-m-d'),
					'descrRep' => $contentReponse,
					'modification' => "0",
					'idUser' => $userId,
					'idSujet' => $idSujet
				)
			);
			$reponseManagers->add($reponse);
			$url = $_SERVER['PHP_SELF'].'?'.$_SERVER['QUERY_STRING'];
			redirection(0, $url);
			//header('Location:'.$_SERVER['PHP_SELF'].'?'.$_SERVER['QUERY_STRING']);
		}
?>
		<form class="row col-lg-12 col-md-12 col-sm-12 col-xs-12" action="#" method="post">
			<textarea class="form-control" name="reponse" id="reponse">
			</textarea>	
			<script>
				CKEDITOR.replace('reponse');
			</script>
			<input type="submit" class="form-control btn btn-primary btn-xs" value="Répondre" name="repondre" />
			<input type="hidden" name="sujet" id="<?php echo "sujet" . $idSujet ?>" value="<?php echo "user". $userId ?>"/>
			<br />
		</form>

<?php

	}
	else{

		?>

		<form class="row col-lg-12 col-md-12 col-sm-12 col-xs-12" action="#" method="post">
			<textarea class="form-control" name="reponse" id="reponse">
				Vous devez être connecter pour pouvoir répondre.
				<a class="btn btn-link" href="index.php?page=11"> 
					Se connecter 
				</a>
			</textarea>	
			<script>
				CKEDITOR.replace('reponse');
				CKEDITOR.config.readOnly = true;

				/*
				Fonction permetant de capture le clique sur le lien. 
				Obligatoire car si textarea disabled aucn lien ne redirige
				*/

				CKEDITOR.on('instanceReady', function(ev) {						
					$('iframe').contents().click(function(e) {		

						if(typeof e.target.href != 'undefined') {			
							document.location = e.target.href;
						}
					});	
				});
			</script>
			<input type="submit" class="disabled form-control btn btn-primary btn-xs" value="Répondre" name="repondre" />
			<input type="hidden" name="sujet" id="<?php echo "sujet" . $idSujet ?>" value="<?php echo "user". $idUser ?>"/>
			<br />
		</form>
<?php

	}

?>
