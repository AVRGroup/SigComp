
    <?php
	require 'conexao.php';
		require 'guestbook/setup.php';
	$smarty = new Smarty;
    $id_atividade = $_POST['id_atividade'];


        $sql = "DELETE FROM atividade WHERE id_atividade = '$id_atividade'";
        // use exec() because no results are returned
        $conn->exec($sql);
        		
				$smarty -> display('pagAdmin.tpl');
    

    ?>
