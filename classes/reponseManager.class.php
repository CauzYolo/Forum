<?php 
// Classe reliant la reponse à la base de données du site web
class reponseManager {
	
	public function __construct($db)
	{
		$this->db=$db;
	}

	// Ajout d'une reponse à un sujet
	public function add($newRep){
		$req = $this->db->prepare('INSERT INTO reponse (			
			dateRep,
			descrRep,
			modification,	
			idUser,
			idSujet) 
			VALUES (:date,:descr,:modif,:user,:sujet);');
		
		$req->bindValue(':date',$newRep->getDateRep(),PDO::PARAM_STR);
		$req->bindValue(':descr',$newRep->getDescrRep(),PDO::PARAM_STR);
		$req->bindValue(':modif',$newRep->getModification(),PDO::PARAM_INT);
		$req->bindValue(':user',$newRep->getIdUser(),PDO::PARAM_STR);
		$req->bindValue(':sujet',$newRep->getIdSujet(),PDO::PARAM_INT);

		$req->execute();
	}

	// Suppression d'une réponse liée à un sujet
	public function del($idRep){
		$rep = $this->db->prepare('DELETE FROM reponse WHERE idRep=:rep;');
		$rep->bindValue(':rep', $idRep, PDO::PARAM_INT);
		$rep->execute();
	}

	// Modification d'une réponse liée à un sujet
	public function update($newRep)
	{
		$req = $this->db->prepare('UPDATE reponse SET
			dateRep=:date,
			descrRep=:descr,
			modification=:modif
			WHERE idRep=:reponse;');
		
		$req->bindValue(':date',$newRep->getDateRep(),PDO::PARAM_STR);
		$req->bindValue(':descr',$newRep->getDescrRep(),PDO::PARAM_STR);
		$req->bindValue(':modif',$newRep->getModification(),PDO::PARAM_INT);
		$req->bindValue(':reponse',$newRep->getIdRep(), PDO::PARAM_INT);
	
		$req->execute();	
	}


	public function getReponseByID($numReponse)
	{
		$req = $this->db->prepare("SELECT * FROM reponse WHERE idRep=:num;");
		$req->bindValue(':num',$numReponse, PDO::PARAM_INT);
		$req->execute();

		$reponse =new reponse ( $req->fetch(PDO::FETCH_OBJ));

		$req->closeCursor();
			
		return $reponse;
	}
	
	// Affichage de toute les réponses liées à un sujet
	public function getReponseBySujet($idSujet)
	{
		$listReps = array();
		$req = $this->db->prepare('SELECT * FROM reponse WHERE idSujet=:sujet');
		$req->bindValue(':sujet',$idSujet, PDO::PARAM_INT);
		$req->execute();
		
		while($rep = $req->fetch(PDO::FETCH_OBJ)){

			$listReps[] = new reponse($rep);
			
		}

		$req->closeCursor();
		return $listReps;
	}

	// Affichage le nombre de réponse pour un sujet
	public function getNbReponseBySujet($idSujet)
	{
		$req = $this->db->prepare('SELECT COUNT(idRep) FROM reponse 
			JOIN sujet ON sujet.idSujet = reponse.idSujet
			WHERE reponse.idSujet=:sujet;'
		);
		$req->bindValue(':sujet',$idSujet, PDO::PARAM_INT);
		$req->execute();
		$rep = $req->fetch(PDO::FETCH_OBJ);
		foreach ($rep as $name => $value) {
     	 	$nb = $value;
 		}
		return $nb;
	}
	
}
?>