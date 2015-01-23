<?php 
// Classe définissant un manga
class droits {
	private $idDroit;
	private $isAdmin;
	private $isMod;
	
	public function getIdDroit()
	{
		return $this->idDroit;
	}
	
	public function setIdUser($nouveauNum)
	{
		return $this->idUser= $nouveauNum;
	}
	
	public function getIsAdmin()
	{
		return $this->isAdmin;
	}
	
	public function setIsAdmin($admin)
	{
		return $this->isAdmin= $admin;
	}
	
	public function getIsMod()
	{
		return $this->isMod;
	}
	
	public function setIsMod($Mod)
	{
		return $this->isMod= $Mod;
	}
		
	public function __construct($value = array()){
		if(!empty($value))
			$this->affecte($value);
	}
	
	public function affecte($donnees){
		foreach($donnees as $attribut=>$value)
		{	
			
			switch($attribut){
				case 'idDroit': $this->setIdDroit($value);
					break;
				case 'isAdmin': $this->setIsAdmin($value);
					break;
				case 'isMod': $this->setIsMod($value);
					break;
			}
		}
	}
	
	}
?>