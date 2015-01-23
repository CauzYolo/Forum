<!DOCTYPE html>
<html>

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title>Forum</title>
	<link rel="stylesheet" href="css/site.css" />
	<link rel="stylesheet" href="js/jquery-ui-1.10.3.custom/css/ui-lightness/jquery-ui-1.10.3.custom.css" />
	<link rel="stylesheet" href="css/bootstrap.css">
	<!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap-theme.min.css"> -->
	<script type="text/javascript" src="js/ckeditor/ckeditor.js"></script>
	<script type="text/javascript" src="js/jquery-ui-1.10.3.custom/js/jquery-1.9.1.js"></script>
	<script type="text/javascript" src="js/jquery-ui-1.10.3.custom/js/jquery-ui-1.10.3.custom.js"></script>
	<script type="text/javascript" src="js/jquery-ui-1.10.3.custom/development-bundle/demos/datepicker/jquery.ui.datepicker-fr.js"></script>
		
		<!-- Script affichage calendrier -->
		<script>
			$(function() {
				 $( "#datepicker" ).datepicker({
					changeMonth: true,
					changeYear: true
					});
			$.datepicker.setDefaults($.datepicker.regional['fr']);
			})
		</script>
</head>
<body class="container">
	<?php
		/* Nous en avont besoin pour compter les visites et pour l'utilisation si nécessaire de login et mot de passe dans le panneau d'administration */
		session_start();
		require_once("include/header.php");
	?>



	<div id="wrap" class="corps">
	<?php
		require_once("include/menu.php");
		require_once("include/texte.php");
	?>
	</div>

	<?php
		require_once("include/footer.php");
	?>
</body>
</html>
