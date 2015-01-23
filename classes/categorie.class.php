<?php 
// Classe définissant un manga
class categorie {
	private $idCat;
	private $libCat;
	
	public function getIdCat()
	{
		return $this->idCat;
	}
	
	public function setIdCat($nouveauNum)
	{
		return $this->idCat= $nouveauNum;
	}
	
	public function getLibCat()
	{
		return $this->libCat;
	}
	
	public function setLibCat($lib)
	{
		return $this->libCat= $lib;
	}
	
		
	public function __construct($value = array()){
		if(!empty($value))
			$this->affecte($value);
	}
	
	public function affecte($donnees){
		foreach($donnees as $attribut=>$value)
		{	
			
			switch($attribut){
				case 'idCat': $this->setIdCat($value);
					break;
				case 'libCat': $this->setLibCat($value);
					break;
			}
		}
	}
	
	}
?>