<html>
   <head>
      <title>Export XML</title>
   </head>
   <body>
      <?php

         $db = new myPdo();
         $categorieManagers = new categorieManager($db);
         $userManagers = new userManager($db);

         if(isset($_GET['idCat']))
            $idCat = htmlentities($_GET['idCat']);
         else
            $idCat = null;

         if(isset($_SESSION['id']))
            $userId = intval($_SESSION['id']->idUser);
         else
            $userId = -1;

         if($userManagers->estAdmin($userId) || $userManagers->estMod($userId))
         {
            $categorie = $categorieManagers->getCategorieById($idCat);

            if(!is_null($categorie->getIdCat()))
            {

              // requete pour recuperer le nom de la categorie
               $rqt1 = $categorie->getLibCat();
               $idCategorie = $categorie->getIdCat();



               // requete pour recuperer l'id et les titres des sujets
               $rqt = $db->prepare("SELECT * FROM sujet WHERE idCat = :id ");

               $rqt->bindValue(':id', $idCat, PDO::PARAM_INT);

               $rqt->execute();

               $listCat = [];

               while($rqt2 = $rqt->fetch(PDO::FETCH_OBJ)){
         
                   $listCat[] = $rqt2;
               }
               $rqt->closeCursor();

               $xml = 
               '<?xml version="1.0" encoding="UTF-8" standalone="yes" ?>

               <!DOCTYPE export [
                  <!-- Declaration de la DTD interne car FireFox ne prends pas en compte les DTDs externes -->
                  <!ELEMENT export (categorie*)>
                     <!ELEMENT categorie (idCat, nom, sujet*)>
                        <!ELEMENT idCat (#PCDATA)>
                        <!ELEMENT nom (#PCDATA)>
                        <!ELEMENT sujet (idSujet, titre, auteur, dateSujet, nbVues, estFerme, description, reponse*)>
                              <!ELEMENT idSujet (#PCDATA)>
                              <!ELEMENT titre (#PCDATA)>
                              <!ELEMENT auteur (#PCDATA)>
                              <!ELEMENT dateSujet (#PCDATA)>
                              <!ELEMENT description (#PCDATA)>
                              <!ELEMENT nbVues (#PCDATA)>
                              <!ELEMENT estFerme (#PCDATA)>
                              <!ELEMENT reponse (idRep, utilisateur, dateReponse, message)>
                                 <!ELEMENT idRep (#PCDATA)>
                                 <!ELEMENT utilisateur (#PCDATA)>
                                 <!ELEMENT dateReponse (#PCDATA)>
                                 <!ELEMENT message (#PCDATA)>

                  <!-- Formatage des caractères spéciaux HTML en XML -->

                  <!ENTITY Ccedil "&#199;">
                  <!ENTITY ccedil "&#231;">
                  <!ENTITY Aacute "&#193;">
                  <!ENTITY aacute "&#225;">
                  <!ENTITY agrave "&#224;">
                  <!ENTITY Agrave "&#192;">
                  <!ENTITY eacute "&#233;">
                  <!ENTITY Eacute "&#201;">
                  <!ENTITY ecirc "&#234;">
                  <!ENTITY Ecirc "&#202;">
                  <!ENTITY nbsp  " ">

               ]>';


               $xml .='<export><categorie><idCat>' . $idCat . '</idCat><nom>'.$rqt1.'</nom>';


               //boucle parcourant les sujets d'une categorie
               foreach  ($listCat as $row2) {
                  $xml .= '<sujet>'
                  . '<idSujet>' . $row2->idSujet . '</idSujet>'
                  .'<titre>'.$row2->titreSujet.'</titre>';
                  $xml .= '<auteur>' . $userManagers->getContactById($row2->idUser)->pseudoUser . '</auteur>';
                  $xml .= '<dateSujet>' . $row2->dateSujet . '</dateSujet>';
                  $xml .= '<nbVues>' . $row2->nbVue . '</nbVues>';
                  $xml .= '<estFerme>' . $row2->estFerme . '</estFerme>';
                  $contenu = str_replace("<", "[", $row2->descrSujet);
                  $row2->descrSujet = $contenu;
                  $contenu = str_replace(">", "]", $row2->descrSujet);
                  $row2->descrSujet = $contenu;
                  $xml .= '<description>' . $row2->descrSujet . '</description>';

                  //requete pour recuperer les reponses d'un sujet
                  $rqt3 = $db->query("SELECT idRep, dateRep, descrRep, idUser FROM reponse WHERE idSujet = ".$row2->idSujet);


                  //boucle affichant les reponses d'un sujet
                  foreach  ($rqt3 as $row3){ 

                     $xml .= '<reponse>';
                     $xml .= '<idRep>' . $row3['idRep'] . '</idRep>';
                     $xml .= '<utilisateur>';
                     $user = new user($userManagers->getContactById($row3['idUser']));
                     $xml .= $user->getPseudoUser() . "</utilisateur>";
                     $xml .= '<dateReponse>'.$row3['dateRep'].'</dateReponse>';
                     $contenu = str_replace("<", "[", $row3['descrRep']);
                     $row3['descrRep'] = $contenu;
                     $contenu = str_replace(">", "]", $row3['descrRep']);
                     $row3['descrRep'] = $contenu;
                     $xml .= '<message>'.$row3['descrRep'].'</message>';
                     $xml .= '</reponse>';

                  }  

                  $xml .= '</sujet>';

               }

               $xml .= '</categorie></export>'; 


               
               // $contenu = str_replace('&'';', '', $xml);
               $file = "export_" . $categorie->getLibCat() . "_" . date('Y-m-d') .  ".xml";
               $fp = fopen($file, 'w+');
               //fputs($fp, $contenu);
               fputs($fp, $xml);
               fclose($fp);/*
               $fp = fopen($file, 'rw+');
               $contenu=file_get_contents($file);
               $contenuMod=str_replace('&', '', $contenu);
               fputs($fp,$contenuMod); 
               fclose($fp);*/
               /*
               while(!feof($fp)) 
               {  
                  $toute_ligne=fread($fp,filesize("export.xml")); 
                  var_dump($toute_ligne);
                  $toute_ligne=str_replace("&","",$toute_ligne);
               }*/
               echo '<p class="success">Export XML effectué ! </p><br><a class="btn btn-primary btn-xs" href="'. $file . '">Voir le fichier</a>';
            }
            else
            {

               ?> 
               <div class="error"> Aucune catégorie trouvée </div>

               <?php

               redirection(5, "index.php");

            }
         }
         else 
            redirection(0, "index.php");
      ?> 
   </body>
</html>