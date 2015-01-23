<?php 

// Classe reliant l'utilisateur à la base de données du site web
class userManager {
	
	public function __construct($db)
	{
		$this->db=$db;
	}
	
	public function add($newUser)
	{
		$req = $this->db->prepare('INSERT INTO user (
				pseudoUser,
				loginUser,
				pwdUser,
				estBLUser,
				urlLogo,
				idDroit
			) 
			VALUES(
				:pseudoUser,
				:loginUser,
				:pwdUser,
				:estBLUser,
				:urlLogo,
				:idDroit
			);'
		);
		
		$req->bindValue(':pseudoUser',$newUser->getPseudoUser(),PDO::PARAM_STR);
		$req->bindValue(':loginUser',$newUser->getLoginUser(),PDO::PARAM_STR);
		$req->bindValue(':pwdUser',$newUser->getPwdUser(),PDO::PARAM_STR);
		$req->bindValue(':estBLUser',$newUser->getEstBLUser(),PDO::PARAM_BOOL);
		$req->bindValue(':urlLogo',$newUser->getUrlLogo(),PDO::PARAM_STR);
		$req->bindValue(':idDroit',$newUser->getIdDroit(),PDO::PARAM_INT);

		$req->execute();
	}

	public function delete($numUser)
	{
		$req = $this->db->prepare("DELETE FROM user WHERE idUser= :id;");
		$req->bindValue(':id',$numUser, PDO::PARAM_INT);
		$req->execute();
	}
	
	// Modification de l'utilisateur
	public function update($NewUser){
		$req = $this->db->prepare('UPDATE user SET 
		pseudoUser = :pseudo,
		loginUser = :login,
		pwdUser = :pwd,
		estBLUser = :bl,
		urlLogo = :logo,
		idDroit = :droit
		where idUser = :id;');
		
		$req->bindValue(':pseudo',$NewUser->getPseudoUser(),PDO::PARAM_STR);
		$req->bindValue(':login',$NewUser->getLoginUser(),PDO::PARAM_STR);
		$req->bindValue(':pwd',$NewUser->getPwdUser(),PDO::PARAM_STR);
		$req->bindValue(':bl',$NewUser->getEstBLUser(),PDO::PARAM_STR);
		$req->bindValue(':logo',$NewUser->getUrlLogo(),PDO::PARAM_STR);
		$req->bindValue(':droit',$NewUser->getIdDroit(),PDO::PARAM_STR);
		$req->bindValue(':id',$NewUser->getIdUser(),PDO::PARAM_INT);

		$req->execute();
	}
	
	public function affContact()
	{
		$listUsers=array();
		$req = $this->db->prepare("SELECT * FROM user;");
		$req->execute();
		
		while($users = $req->fetch(PDO::FETCH_OBJ)){
			
			$listUsers[]=new user ($users);
			
		}
		$req->closeCursor();
			
		return $listUsers;
	}

	public function getContactById($id)
	{
		$listUsers=array();
		$req = $this->db->prepare("SELECT * FROM user WHERE idUser= :id;");
		$req->bindValue(':id',$id, PDO::PARAM_INT);
		$req->execute();
		
		$user = $req->fetch(PDO::FETCH_OBJ);
			
		return $user;
	}
	
	public function getPseudoUserById($id)
	{
		$req = $this->db->prepare('SELECT pseudoUser FROM user WHERE idUser= :id;');
		$req->bindValue(':id',$id,PDO::PARAM_INT);
		$req->execute();
		
		$pseudo = $req->fetch(PDO::FETCH_OBJ);
			
		$req->closeCursor();
		//var_dump($pseudo);
		return $pseudo;
	}
	
	public function estMDPValide($login,$MDP)
	{
		$sql1='SELECT idUser FROM user WHERE pwdUser="'.$MDP.'" && loginUser="'.$login.'"';
		$req = $this->db->query($sql1);
		
		$user = $req->fetch(PDO::FETCH_OBJ);
		$req->closeCursor();
		if(empty($user))
		{
			return array('id'=>null,'valide'=>false);
		}
		else
		{
			return array('id'=>$user,'valide'=>true);
		}
	}

	public function estAdmin($id)
	{
		$sql1='SELECT idUser FROM user u INNER JOIN droits d ON u.idDroit=d.idDroit WHERE idUser="'.$id.'" && isAdmin=true';
		$req = $this->db->query($sql1);
		
		$user = $req->fetch(PDO::FETCH_OBJ);
		$req->closeCursor();
		if(empty($user))
		{
			return false;
		}
		else
		{
			return true;
		}
	}

	public function estMod($id)
	{
		$sql1='SELECT idUser FROM user u INNER JOIN droits d ON u.idDroit=d.idDroit WHERE idUser="'.$id.'" && isMod=true';
		$req = $this->db->query($sql1);
		
		$user = $req->fetch(PDO::FETCH_OBJ);
		$req->closeCursor();
		if(empty($user))
		{
			return false;
		}
		else
		{
			return true;
		}
	}

	public function estBLUser($id)
	{
		$sql1='SELECT estBLUser FROM user WHERE idUser="'.$id.'"';
		$req = $this->db->query($sql1);
		
		$userBl = $req->fetch(PDO::FETCH_OBJ);
		$req->closeCursor();
		if($id != -1){
			if($userBl->estBLUser == "1")	
				$userBl = true;
			else
				$userBl = false;
		}
		else
			$userBl = false;
		return $userBl;
	}

	public function estPropr($idUser,$idSujet)
	{
		$sql1='SELECT u.idUser FROM user u INNER JOIN sujet s ON u.idUser=s.idUser WHERE s.idUser="'.$idUser.'" AND s.idSujet="'.$idSujet.'"';
		$req = $this->db->query($sql1);
		
		$user = $req->fetch(PDO::FETCH_OBJ);
		$req->closeCursor();
		if(empty($user))
		{
			return false;
		}
		else
		{
			return true;
		}
	}

	public function addImageUser($extentionUpload,$extentionValide,$tmp_name)
	{
		if(!is_dir('image')){
			mkdir('image', 0777, true);
		}
		// ---------------------------------------------------------------------

		// ------------------------------ image redimmentionner-----------------

		// ---------------------------------------------------------------------
		$NouvelleLargeur = 150; //Largeur choisie à 150 px mais modifiable
		$TailleImageChoisie = getimagesize($tmp_name);
		// Si l'image de base est un jpg / jpeg
		if($extentionUpload=="jpg"||$extentionUpload=="jpeg")
		{
			$ImageChoisie = imagecreatefromjpeg($tmp_name);
			
			$NouvelleHauteur = ( ($TailleImageChoisie[1] * (($NouvelleLargeur)/$TailleImageChoisie[0])) );

			$NouvelleImage = imagecreatetruecolor($NouvelleLargeur , $NouvelleHauteur) or die ("Erreur");

			imagecopyresampled($NouvelleImage , $ImageChoisie  , 0,0, 0,0, $NouvelleLargeur, $NouvelleHauteur, $TailleImageChoisie[0],$TailleImageChoisie[1]);
			imagedestroy($ImageChoisie);

			$nom = md5(uniqid(rand(), true)).'.'.$extentionUpload;
			$result= imagejpeg($NouvelleImage, "image/".$nom, 100);
		}
		// Si l'image de base est un png
		if($extentionUpload=="png")
		{

			$ImageChoisie = imagecreatefrompng($tmp_name);

			$NouvelleHauteur = ( ($TailleImageChoisie[1] * (($NouvelleLargeur)/$TailleImageChoisie[0])) );

			$NouvelleImage = imagecreatetruecolor($NouvelleLargeur , $NouvelleHauteur) or die ("Erreur");

			imagecopyresampled($NouvelleImage , $ImageChoisie  , 0,0, 0,0, $NouvelleLargeur, $NouvelleHauteur, $TailleImageChoisie[0],$TailleImageChoisie[1]);
			imagedestroy($ImageChoisie);

			$nom= md5(uniqid(rand(), true)).'.'.$extentionUpload;
			$result= imagepng($NouvelleImage, "image/".$nom, 100);
		}
		// Si l'image de base est un gif
		if($extentionUpload=="gif")
		{

			$ImageChoisie = imagecreatefromgif($tmp_name);
			

			$NouvelleHauteur = ( ($TailleImageChoisie[1] * (($NouvelleLargeur)/$TailleImageChoisie[0])) );

			$NouvelleImage = imagecreatetruecolor($NouvelleLargeur , $NouvelleHauteur) or die ("Erreur");

			imagecopyresampled($NouvelleImage , $ImageChoisie  , 0,0, 0,0, $NouvelleLargeur, $NouvelleHauteur, $TailleImageChoisie[0],$TailleImageChoisie[1]);
			imagedestroy($ImageChoisie);

			$nom= md5(uniqid(rand(), true)).'.'.$extentionUpload;
			$result= imagegif($NouvelleImage, "image/".$nom, 100);
		}
		// Si l'image de base est un bmp
		if($extentionUpload=="wbmp")
		{

			$ImageChoisie = imagecreatefromwbmp($tmp_name);

			$NouvelleHauteur = ( ($TailleImageChoisie[1] * (($NouvelleLargeur)/$TailleImageChoisie[0])) );

			$NouvelleImage = imagecreatetruecolor($NouvelleLargeur , $NouvelleHauteur) or die ("Erreur");

			imagecopyresampled($NouvelleImage , $ImageChoisie  , 0,0, 0,0, $NouvelleLargeur, $NouvelleHauteur, $TailleImageChoisie[0],$TailleImageChoisie[1]);
			imagedestroy($ImageChoisie);

			$nom= md5(uniqid(rand(), true)).'.'.$extentionUpload;
			$result= imagewbmp($NouvelleImage, "image/".$nom, 100);
		}

		if($result)
		{
			$url="image/".$nom;
		}
		else
		{
			$url="";
		}
		return $url;
	}

}

?>