
<?php
	
	require 'conexao.php';
	require 'guestbook/setup.php';
	$smarty = new Smarty;
        $nome = $_POST['nome'];
        $matricula = $_POST['matricula'];
        $grade = $_POST['grade'];
        $codCurso = $_POST['codCurso'];
	
        $sql = "INSERT INTO aluno (nome, matricula, grade, curso, usrTipe) VALUES ('$nome', '$matricula', '$grade', '$codCurso', 0)";
         // use exec() because no results are returned
        $conn->exec($sql);
        		
				$smarty -> display('pagAdmin.tpl');
				
        


        ?>

