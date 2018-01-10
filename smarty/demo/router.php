<?php		
		require 'guestbook/setup.php';
		
		$smarty = new Smarty;
        session_start();
		
		$valor = $_POST['submit'];
		echo $valor;
		if( $valor == "Trocar Perfil") $smarty -> display('upperfil.tpl');
		else if ($valor == "Enviar Certificados") $smarty-> display('upfile.tpl');
		else if ($valor == "Alterar Dados") $smarty-> display('alterar.tpl'); 
		
		
		
		