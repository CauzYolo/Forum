<?php

class template_odt{

   var $zip_path="zip";
   var $unzip_path="unzip";
   var $process_dir="./";
   
   var $template_path;
   var $template_ext;
   var $template_content;
   
   function set_zip_path($zip)
   {
      $this->zip_path=$zip;
   }
   
   function set_unzip_path($unzip)
   {
      $this->unzip_path=$unzip;
   }
   
   function set_process_dir($repertoire)
   {
      $this->process_dir=$repertoire;
   }
   
   function load_template($fichier)
   {
      if (!file_exists($fichier))
      die("Erreur : Le fichier template n'existe pas.");
      
      $id=md5(microtime());
      $info=pathinfo($fichier);
      $this->template_ext=$info["extension"];
      $this->template_path=$this->process_dir.$id;
      
      if (!mkdir($this->template_path, 0777))
      die("Erreur : Impossible de créer le dossier unique.");
      
      if (!copy($fichier,$this->template_path.'.'.$this->template_ext))
      die("Erreur : Impossible de copier le fichier.");
      
      $xml_file="content.xml";
      exec($this->unzip_path." ".$this->template_path.".".$this->template_ext." -d ".$this->template_path." ".$xml_file);
      
      if (!file_exists($this->template_path."/".$xml_file))
      die("Erreur : Problème lors de l'extraction de content.xml.");
      
      $handle=fopen($this->template_path."/".$xml_file, "rb");
      $this->template_content= fread($handle , filesize ($this->template_path."/".$xml_file));
      fclose($handle);
      
      return $this->template_path.'.'.$this->template_ext;      
   }
   
   function set_var($nom,$valeur)
   {
      $this->template_content=str_replace("[var.".$nom."]",utf8_encode($valeur),$this->template_content);
   }
   
   function set_var_array($tableau)
   {
      foreach($tableau AS $nom => $valeur)
      $this->set_var($nom,$valeur);
   }
   
   function save_template()
   {
      $xml_file="content.xml";
      $handle=fopen($this->template_path."/".$xml_file, "wb");
      fwrite($handle,$this->template_content);
      fclose($handle);
      
      exec($this->zip_path." -u -j -m ".$this->template_path.".".$this->template_ext." ".$this->template_path."/".$xml_file);
      
      return $this->template_path.".".$this->template_ext;
   }
   
   function nettoyer_dir($h="2",$m="0")
   {
    $now=mktime(date("H")-abs((int)$h), date("i")-abs((int)$m), date("s"), date("m"), date("d"), date("Y"));
    if($dir=@opendir($this->process_dir))
    {
      while(($file=readdir($dir)) !== false)
        if ($file != ".." && $file != ".")
          if (filemtime($this->process_dir.$file) < $now)
            (is_dir($this->process_dir.$file) ? @rmdir($this->process_dir.'/'.$file):@unlink($this->process_dir.$file));
      closedir($dir);
    }
   }
}

?>
