<?php
      //////////////////////////////////////////////////////////////////////////////////////////////////////////
      // Variables Globales utilisées par Template Odt
      //////////////////////////////////////////////////////////////////////////////////////////////////////////
require("template_odt.class.php");
      $variable['login'] = 'toto';
      $variable['nom'] ="Maitre";
      $variable['prenom']="Alex";
     
      
          //////////////////////////////////////////////////////////////////////////////////////////////////////////
      // Génération ODT via la classe Template ODT
      //////////////////////////////////////////////////////////////////////////////////////////////////////////
      
      // Informations de configuration
           
      $template=new template_odt();
      $template->set_process_dir(".");      
      $template->load_template("lettre.odt");
      $template->set_var_array($variable);
      $fichier=$template->save_template();
      $nouveauFichier=$variable['prenomEtu']."_".$variable['nomEtu']."_lettre.odt";
      unlink($nouveauFichier);
      rename($fichier,$nouveauFichier);
      header("Location: ".$nouveauFichier);
      $template->nettoyer_dir("0","10");
          
  ?>