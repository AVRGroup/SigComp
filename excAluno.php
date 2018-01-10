
    <?php
	require 'conexao.php';
		require 'guestbook/setup.php';
	$smarty = new Smarty;
    $matricula = $_POST['matricula'];

        $sql = "DELETE FROM aluno WHERE matricula = '$matricula'";
        // use exec() because no results are returned
        $conn->exec($sql);
        		
				$smarty -> display('pagAdmin.tpl');

    ?>
