
    <?php
	
	require 'conexao.php';
		require 'guestbook/setup.php';
	$smarty = new Smarty;
    $experiencia = $_POST['experiencia'];
    $desempenho = $_POST['desempenho'];
    $tipo = $_POST['tipo'];
    $idAluno = $_POST['idAluno'];
	
        $sql = "INSERT INTO atividade (experience, desempenho, tipo, id_aluno) VALUES ('$experiencia', '$desempenho', '$tipo', '$idAluno')";
        // use exec() because no results are returned
        $conn->exec($sql);
        		
				$smarty -> display('pagAdmin.tpl');
		
    ?>
