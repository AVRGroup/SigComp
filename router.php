<?php		
		require 'guestbook/setup.php';
		
		$smarty = new Smarty;
        session_start();
		
		$valor = $_POST['submit'];
		//echo $valor;
		if( $valor == "Trocar Perfil") $smarty -> display('upperfil.tpl');
		else if ($valor == "Enviar Certificados") $smarty-> display('upfile.tpl');
		else if ($valor == "Alterar Dados") $smarty-> display('alterar.tpl'); 
		else if ($valor == "Cadastrar aluno") $smarty->display('cadAluno.tpl');
		else if ($valor == "Cadastrar atividade") $smarty->display('cadAtividade.tpl');
		else if ($valor == "Excluir aluno") $smarty->display('excAluno.tpl');
		else if ($valor == "Excluir atividade") $smarty->display('excAtividade.tpl');
		//else if ($valor == "Consultar alunos") $smarty->display('consAluno.tpl');
		
		