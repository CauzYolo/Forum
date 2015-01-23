<?php 
// Classe définissant un manga
class sujet {
	private $idSujet;
	private $titreSujet;
	private $dateSujet;
	private $descrSujet;
	private $nbVue;
	private $estFerme;
	private $idUser;
	private $idCat;

	
	public function getIdSujet()
	{
		return $this->idSujet;
	}
	
	public function setIdSujet($nouveauNum)
	{
		return $this->idSujet= $nouveauNum;
	}
	
	public function getTitreSujet()
	{
		return $this->titreSujet;
	}
	
	public function setTitreSujet($titre)
	{
		return $this->titreSujet= $titre;
	}	

	public function getDateSujet()
	{
		return $this->dateSujet;
	}
	
	public function setDateSujet($date)
	{
		return $this->dateSujet= $date;
	}	

	public function getDescrSujet()
	{
		return $this->descrSujet;
	}
	
	public function setDescrSujet($descr)
	{
		return $this->descrSujet= $descr;
	}

	public function getNbVue()
	{
		return $this->nbVue;
	}
	
	public function setNbVue($vue)
	{
		return $this->nbVue= $vue;
	}

	public function getEstFerme()
	{
		return $this->estFerme;
	}
	
	public function setEstFerme($ferme)
	{
		return $this->estFerme= $ferme;
	}

	public function getIdUser()
	{
		return $this->idUser;
	}
	
	public function setIdUser($id)
	{
		return $this->idUser= $id;
	}

	public function getIdCat()
	{
		return $this->idCat;
	}
	
	public function setIdCat($id)
	{
		return $this->idCat= $id;
	}
		
	public function __construct($value = array()){
		if(!empty($value))
			$this->affecte($value);
	}
	
	public function affecte($donnees){
		foreach($donnees as $attribut=>$value)
		{	
			
			switch($attribut){
				case 'idSujet': $this->setIdSujet($value);
					break;
				case 'titreSujet': $this->setTitreSujet($value);
					break;
				case 'dateSujet' : $this->setDateSujet($value);
					break;
				case 'descrSujet' : $this->setDescrSujet($value);
					break;
				case 'nbVue': $this->setNbVue($value);
					break;
				case 'estFerme': $this->setEstFerme($value);
					break;
				case 'idUser': $this->setIdUser($value);
					break;
				case 'idCat': $this->setIdCat($value);
					break;
			}
		}
	}
	
	}
?>