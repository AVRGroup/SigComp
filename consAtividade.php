
	<?php 
		header("Content-Type: text/html; charset=ISO-8859-1");




		
		require 'smarty/libs/SmartyBC.class.php';
		$smarty = new SmartyBC;
		
		$smarty->display('consAtividade.tpl');


	?>
