
	<?php 
		header("Content-Type: text/html; charset=utf8");

 

		require 'conexao.php';


        $stmt = $conn->prepare("SELECT experience, desempenho, tipo, id_aluno FROM atividade");
        $stmt->execute();

        echo "<table style='border: solid 1px black;'>";
        echo "<tr><th>Experiência</th><th>Desempenho</th><th>Tipo</th><th>ID Aluno</th></tr>";

        $atividades = $stmt->fetchAll();

        foreach($atividades as $chave => $valor) {

            echo "<tr><td>".$valor["experience"]."</td><td>".$valor["desempenho"]."</td><td>".$valor["tipo"]."</td><td>".$valor["id_aluno"]."</td></tr>";
        }
        echo "</table>";
		
		echo "<li><a href='pagAdmin.php'>Retornar</a><br></li>";
    


	?>
