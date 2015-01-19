<?php
	function redirection($sec, $url){

		if($sec == 0 || is_null($sec)){
			header("Location:".$url);
		}
		else{
			echo "<p>Redirection automatique dans " . $sec . " secondes</p>
			 	<p> Si la redirection n'as pas lieu <a href=\"$url\"> cliquer ici </a>";
			header('refresh:'.$sec .';url='.$url);
		}
	}
?>