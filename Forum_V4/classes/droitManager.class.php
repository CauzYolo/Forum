<?php 
// Classe reliant l'utilisateur à la base de données du site web
class droitManager {
	
	public function __construct($db)
	{
		$this->db=$db;
	}
	
	public function getListDroits()
	{
		$listDroits=array();
		$req = $this->db->prepare("SELECT * FROM droits");
		$req->execute();
		
		while($droit = $req->fetch(PDO::FETCH_OBJ)){
			
			$listDroits[]=new categorie ($droit);
			
		}
		$req->closeCursor();
			
		return $listDroits;
	}

	public function getDroitById()
	{
		
	}
	
}
?>