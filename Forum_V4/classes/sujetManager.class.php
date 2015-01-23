<?php 
// Classe reliant l'utilisateur à la base de données du site web
class sujetManager {
	
	public function __construct($db)
	{
		$this->db=$db;
	}
	
	// Ajout d'un sujet
	public function add($NewSujet){
		$req = $this->db->prepare('INSERT INTO sujet (titreSujet,dateSujet,descrSujet,nbVue,estFerme,idUser,idCat) VALUES (:titre,:dt,:descr,:vue,:ferme,:user,:cat);');
		
		$req->bindValue(':titre',$NewSujet->getTitreSujet(),PDO::PARAM_STR);
		$req->bindValue(':dt',$NewSujet->getDateSujet(),PDO::PARAM_STR);
		$req->bindValue(':descr',$NewSujet->getDescrSujet(),PDO::PARAM_STR);
		$req->bindValue(':vue',$NewSujet->getNbVue(),PDO::PARAM_INT);
		$req->bindValue(':ferme',$NewSujet->getEstFerme(),PDO::PARAM_BOOL);
		$req->bindValue(':user',$NewSujet->getIdUser(),PDO::PARAM_STR);
		$req->bindValue(':cat',$NewSujet->getIdCat(),PDO::PARAM_INT);
		
		$req->execute();
	}
	// Suppression d'un sujet
	public function del($numSujet){
		$req = $this->db->prepare("DELETE FROM sujet WHERE idSujet= :id;");
		$req->bindValue(':id',$numSujet, PDO::PARAM_INT);
		$req->execute();
	}
	
	// Modification du sujet
	public function update($NewSujet){
		$req = $this->db->prepare('UPDATE sujet SET 
		titreSujet = :titre,
		dateSujet = :dt,
		descrSujet = :descr,
		nbVue = :vue,
		estFerme = :ferme,
		idUser = :user,
		idCat= :cat
		where idSujet = :id;');
		
		$req->bindValue(':titre',$NewSujet->getTitreSujet(),PDO::PARAM_STR);
		$req->bindValue(':dt',$NewSujet->getDateSujet(),PDO::PARAM_STR);
		$req->bindValue(':descr',$NewSujet->getDescrSujet(),PDO::PARAM_STR);
		$req->bindValue(':vue',$NewSujet->getNbVue(),PDO::PARAM_INT);
		$req->bindValue(':ferme',$NewSujet->getEstFerme(),PDO::PARAM_BOOL);
		$req->bindValue(':user',$NewSujet->getIdUser(),PDO::PARAM_STR);
		$req->bindValue(':cat',$NewSujet->getIdCat(),PDO::PARAM_INT);
		$req->bindValue(':id',$NewSujet->getIdSujet(),PDO::PARAM_INT);

		$req->execute();
	}
	
	public function getListSujetsByCat($numCat)
	{
		$listSujets=array();
		$req = $this->db->prepare("SELECT * FROM sujet WHERE idCat=:num;");
		$req->bindValue(':num',$numCat, PDO::PARAM_INT);
		$req->execute();
		
		while($sujet = $req->fetch(PDO::FETCH_OBJ)){
			
			$listSujets[]=new sujet ($sujet);
			
		}
		$req->closeCursor();
			
		return $listSujets;
	}
	
	public function getSujetsByID($numSujet)
	{
		$req = $this->db->prepare("SELECT * FROM sujet WHERE idSujet=:num;");
		$req->bindValue(':num',$numSujet, PDO::PARAM_INT);
		$req->execute();
		
		$sujet =new sujet ( $req->fetch(PDO::FETCH_OBJ));

		$req->closeCursor();
			
		return $sujet;
	}
	
	public function estMDPValide($login,$MDP)
	{
		$sql1='SELECT * FROM user WHERE pwdUser="'.$MDP.'" && loginUser="'.$login.'"';
		$req = $this->db->query($sql1);
		
		$user = $req->fetch(PDO::FETCH_OBJ);
		$req->closeCursor();
		if(empty($user))
		{
			return false;
		}
		else
		{
			return true;
		}
	}
	
	public function nbSujetByUser($idUser)
	{
		$req = $this->db->prepare('SELECT count( * ) AS nbSuj FROM sujet WHERE idUser = :id');
		$req->bindValue(':id',$idUser, PDO::PARAM_INT);
		$req->execute();
		
		$nbSuj = $req->fetch(PDO::FETCH_OBJ);

		$req->closeCursor();
			
		return $nbSuj->nbSuj;

	}

	public function nbCommentaireByUser($idUser)
	{
		$req = $this->db->prepare('SELECT count( * ) AS nbCom FROM reponse r INNER JOIN sujet s ON r.idSujet = s.idSujet WHERE s.idUser = :id');
		$req->bindValue(':id',$idUser, PDO::PARAM_INT);
		$req->execute();
		
		$nbCom = $req->fetch(PDO::FETCH_OBJ);

		$req->closeCursor();
			
		return $nbCom->nbCom;

	}

	public function updateNbVue($numSujet,$nbVues){
		$req = $this->db->prepare('UPDATE sujet SET 
		nbVue = :vue WHERE idSujet = :id;');
		$req->bindValue(':vue',intval($nbVues),PDO::PARAM_INT);
		$req->bindValue(':id',$numSujet, PDO::PARAM_INT);
		$req->execute();
	}
}
?>