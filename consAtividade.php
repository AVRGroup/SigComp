
	<?php 
		header("Content-Type: text/html; charset=ISO-8859-1");




		
		require '/var/www/html/vendor/smarty/smarty/libs/SmartyBC.class.php';
		$smarty = new SmartyBC;
		
		$smarty->display('consAtividade.tpl');


	?>
