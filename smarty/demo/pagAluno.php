
<?php

		require 'guestbook/setup.php';
		
		$smarty = new Smarty;
        session_start();
        if((!isset ($_SESSION['login']) == true) and (!isset ($_SESSION['senha']) == true))
        {
            unset($_SESSION['login']);
            unset($_SESSION['senha']);
            header('location:index.php');
        }
        $logado = $_SESSION['login'];
		
		require_once 'conexao.php';
		foreach (glob("uploads/$logado/perfil.*") as $arquivo) $smarty->assign('foto',$arquivo);
		
        $stmt2 = $conn->prepare("SELECT nome, nivel FROM aluno WHERE matricula = '$logado'");
        $stmt2->execute();
        $result = $stmt2->fetchAll()[0];
		
		$smarty-> assign('nome',$result['nome']);
		$smarty-> assign('nivel',$result['nivel']);
		$smarty-> assign('matricula', $logado);
		$smarty-> display('pagAluno.tpl');
		