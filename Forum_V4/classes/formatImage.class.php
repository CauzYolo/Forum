<?php 
// Classe définissant un manga
class formatImage {
	private $idFormat;
	private $libFormat;
	
	public function getIdFormat()
	{
		return $this->idFormat;
	}
	
	public function setIdFormat($nouveauNum)
	{
		return $this->idFormat= $nouveauNum;
	}
	
	public function getLibFormat()
	{
		return $this->libFormat;
	}
	
	public function setLibFormat($lib)
	{
		return $this->libFormat= $lib;
	}
	
		
	public function __construct($value = array()){
		if(!empty($value))
			$this->affecte($value);
	}
	
	public function affecte($donnees){
		foreach($donnees as $attribut=>$value)
		{	
			
			switch($attribut){
				case 'idFormat': $this->setIdFormat($value);
					break;
				case 'libFormat': $this->setLibFormat($value);
					break;
			}
		}
	}
	
	}
?>