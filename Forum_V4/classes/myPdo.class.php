<?php 
// Classe permettant de se connecter à la base de donnée de mySQL
class myPdo extends PDO
{
	protected $dbo;
	
	public function __construct(){
		$host="localhost";
		$user="root";
		$pass="root";
		$base="forum";
		$this->dbo=parent::__construct
			("mysql:host=$host;
			dbname=$base",
			$user,$pass,
			array(PDO::ATTR_PERSISTENT =>true));
	}
}
?>