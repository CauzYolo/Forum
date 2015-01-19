<div id="main" class="row texte">
			
	<?php
	if (!empty($_GET["page"]))
	{
		$page=$_GET["page"];
	}
	else
	{
		$page=3;
	}
	
	switch($page)
	{
		case 1:
			include_once('pages/detailMembre.inc.php');
		break;
		case 2:
			include_once('pages/membre.inc.php');
		break;
		case 3:
			include_once('pages/index.inc.php');
		break;
		case 4:
			include_once("pages/detailSujet.inc.php");
		break;
		case 5:
			include_once("pages/ajoutSujet.inc.php");
		break;
		case 6:
			include_once("pages/modifSujet.inc.php");
		break;
		case 7:
			include_once("pages/supprSujet.inc.php");
		break;
		case 11:
			include_once('pages/connexion.inc.php');
		break;
		case 12:
			include_once('pages/deconnexion.inc.php');
		break;
		case 13:
			include_once('pages/inscrireUser.inc.php');
		break;
		case 14:
			include_once('pages/modifMembre.inc.php');
		break;
		case 15:
			include_once('pages/supprMembre.inc.php');
		break;
		case 16:
			include_once('pages/modifReponse.inc.php');
		break;
		case 17:
			include_once('pages/supprReponse.inc.php');
		break;
		case 18:
			include_once('pages/ajoutCategorie.inc.php');
		break;
		case 19:
			include_once('pages/modifCategorie.inc.php');
		break;
			case 20:
			include_once('pages/supprCategorie.inc.php');
		break;
		case 21:
			include_once('pages/exportXml.inc.php');
		break;
		case 22:
			include_once('pages/importXML.inc.php');
		break;
		default:
			include_once('pages/index.inc.php');
		break;
	}
	?>

</div>
