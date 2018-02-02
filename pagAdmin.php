<?php
	session_start();
	require_once 'conexao.php';
	if(!isset ($_SESSION['login']))
        {
            unset($_SESSION['login']);
            unset($_SESSION['senha']);
            header('location:index.php');
        }
	else{
		$matricula = $_SESSION['login'];
		$senha = $_SESSION['senha'];
		$srchAdm = $conn->prepare("SELECT * FROM aluno WHERE matricula = '$matricula' AND senha = '$senha' AND usrTipe = 1");
        $srchAdm->execute();
        $resultAdm = $srchAdm->rowCount();
		if ($resultAdm != 1){
			unset($_SESSION['login']);
            unset($_SESSION['senha']);
            header('location:index.php');
		}
	}
	require 'guestbook/setup.php';
	$smarty = new Smarty;
	$smarty->display('pagAdmin.tpl');
	
        
	?>