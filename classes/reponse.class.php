<?php 
// Classe définissant un manga
class reponse {

	private $idRep;
	private $dateRep;
	private $descrRep;
	private $modification;
	private $idUser;
	private $idSujet;
	
	public function getIdRep()
	{
		return $this->idRep;
	}
	
	public function setIdRep($nouveauNum)
	{
		return $this->idRep= $nouveauNum;
	}
	
	public function getDateRep()
	{
		return $this->dateRep;
	}
	
	public function setDateRep($date)
	{
		return $this->dateRep= $date;
	}	

	public function getDescrRep()
	{
		return $this->descrRep;
	}

	public function setDescrRep($descr)
	{
		return $this->descrRep = $descr;
	}
	
	public function getModification()
	{
		return $this->modification;
	}

	public function setModification($val)
	{
		return $this->modification = $val;
	}	

	public function getIdUser()
	{
		return $this->idUser;
	}
	
	public function setIdUser($id)
	{
		return $this->idUser= $id;
	}

	public function getIdSujet()
	{
		return $this->idSujet;
	}
	
	public function setIdSujet($idSujet)
	{
		return $this->idSujet= $idSujet;
	}
		
	public function __construct($value = array()){
		if(!empty($value))
			$this->affecte($value);
	}
	
	public function affecte($donnees){
		foreach($donnees as $attribut=>$value)
		{	
			switch($attribut){
				case 'idRep': $this->setIdRep($value);
					break;
				case 'dateRep': $this->setDateRep($value);
					break;
				case 'descrRep' : $this->setDescrRep($value);
					break;
				case 'modification' : $this->setModification($value);
					break;
				case 'idUser' : $this->setIdUser($value);
					break;
				case 'idSujet': $this->setIdSujet($value);
					break;
			}

		}
	}
	
	}
?>