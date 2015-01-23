<?php 
// Classe reliant une news à la base de donnée du site web
class formatImageManager {
	
	public function __construct($db)
	{
		$this->db=$db;
	}
	
	// Obtention de la liste des news présent dans la base de donnée
	public function getListFIValid()
	{
		$listExts=array();
		$req = $this->db->prepare("SELECT libFormat FROM formatImage");
		$req->execute();
		
		while($formImg = $req->fetch(PDO::FETCH_OBJ)){
			
			$listForms[]=$formImg->libFormat;
			
		}
		$req->closeCursor();
			
		return $listForms;
	}
	
	public function getFIByName($nom)
	{
		
		$req = $this->db->prepare("SELECT * FROM formatImage WHERE libFormat = :nom;");
		$req->bindValue(':nom',$nom, PDO::PARAM_STR);
		$req->execute();
		
		$ext = $req->fetch(PDO::FETCH_OBJ);
			
		$res=new extentions ($ext);
			
		
		$req->closeCursor();
			
		return $res;
	}
	
}
?>