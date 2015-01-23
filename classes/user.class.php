<?php 
// Classe définissant un manga
class user {
	private $idUser;
	private $pseudoUser;
	private $loginUser;
	private $pwdUser;
	private $estBLUser;
	private $urlLogo;
	private $idDroit;
	
	public function getIdUser()
	{
		return $this->idUser;
	}
	
	public function setIdUser($nouveauNum)
	{
		return $this->idUser= $nouveauNum;
	}
	
	public function getPseudoUser()
	{
		return $this->pseudoUser;
	}
	
	public function setPseudoUser($nouveauNom)
	{
		return $this->pseudoUser= $nouveauNom;
	}
	
	public function getLoginUser()
	{
		return $this->loginUser;
	}
	
	public function setLoginUser($login)
	{
		return $this->loginUser= $login;
	}
	
	public function getPwdUser()
	{
		return $this->pwdUser;
	}
	
	public function setPwdUser($pwd)
	{
		return $this->pwdUser= $pwd;
	}
	
	public function getEstBLUser()
	{
		return $this->estBLUser;
	}
	
	public function setEstBLUser($bl)
	{
		return $this->estBLUser= $bl;
	}
	
	public function getUrlLogo()
	{
		return $this->urlLogo;
	}
	
	public function setUrlLogo($url)
	{
		return $this->urlLogo= $url;
	}
	
	public function getIdDroit()
	{
		return $this->idDroit;
	}
	
	public function setIdDroit($droit)
	{
		return $this->idDroit= $droit;
	}
		
	public function __construct($value = array()){
		if(!empty($value))
			$this->affecte($value);
	}
	
	public function affecte($donnees){
		foreach($donnees as $attribut=>$value)
		{	
			
			switch($attribut){
				case 'idUser': $this->setIdUser($value);
					break;
				case 'pseudoUser': $this->setPseudoUser($value);
					break;
				case 'loginUser': $this->setLoginUser($value);
					break;
				case 'pwdUser': $this->setPwdUser($value);
					break;
				case 'estBLUser': $this->setEstBLUser($value);
					break;
				case 'urlLogo': $this->setUrlLogo($value);
					break;
				case 'idDroit': $this->setIdDroit($value);
					break;
			}
		}
	}
	
}
?>