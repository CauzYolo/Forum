<?php 
// Classe reliant l'utilisateur à la base de données du site web
class categorieManager {
	
	public function __construct($db)
	{
		$this->db=$db;
	}
	
	// Ajout d'un sujet
	public function add($cat){
		$req = $this->db->prepare('INSERT INTO categorie (libCat) VALUES (:nom);');
		
		$req->bindValue(':nom',$cat->getLibCat(),PDO::PARAM_STR);
		
		$req->execute();
	}
	// Suppression d'un sujet
	public function del($numCat){
		$req = $this->db->prepare("DELETE FROM categorie WHERE idCat= :id;");
		$req->bindValue(':id',$numCat, PDO::PARAM_INT);
		$req->execute();
	}
	
	// Modification du sujet
	public function update($NewCat){
		$req = $this->db->prepare('UPDATE categorie SET libCat = :lib WHERE idCat=:id;');
		
		$req->bindValue(':lib',$NewCat->getLibCat(),PDO::PARAM_STR);
		$req->bindValue(':id', $NewCat->getIdCat(), PDO::PARAM_INT);
		
		$req->execute();
	}
	
	public function getListCat()
	{
		$listCat=array();
		$req = $this->db->prepare("SELECT * FROM categorie;");
		$req->execute();
		
		while($cat = $req->fetch(PDO::FETCH_OBJ)){
			
			$listCat[]=new categorie ($cat);
			
		}
		$req->closeCursor();
			
		return $listCat;
	}

	public function getCategorieByID($numCat)
	{
		$req = $this->db->prepare("SELECT * FROM categorie WHERE idCat=:num;");
		$req->bindValue(':num',$numCat, PDO::PARAM_INT);
		$req->execute();
		
		$categorie = new categorie ( $req->fetch(PDO::FETCH_OBJ));

		$req->closeCursor();
			
		return $categorie;
	}
	
}
?>