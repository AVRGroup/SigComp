
	<?php 
		header("Content-Type: text/html; charset=ISO-8859-1");


		require 'conexao.php';
		$stmt = $conn->prepare("SELECT id, nome, matricula FROM aluno");
		$stmt->execute();
		
		
		echo "<table style='border: solid 1px black;'>";
		echo "<tr><th>Id</th><th>Nome</th><th>Matricula</th><th>IRA</th></tr>";

		$alunos = $stmt->fetchAll();


		foreach($alunos as $key => &$value) {
			$stmt2 = $conn->prepare("SELECT valor, estado, codDisciplina, carga FROM nota WHERE idAluno=".$value["id"]);
			$stmt2->execute();
			$result = $stmt2->fetchAll();

			$sumTotal = 0;
			$cont = 0;
			foreach($result as $k => $disciplina){
				if($disciplina['estado'] == 'Trancado' || $disciplina['estado'] == 'Matriculado' || $disciplina['estado'] == 'Sem Conceito' || $disciplina['codDisciplina'] == 'DCC110' || $disciplina['carga'] == 3)
					continue;

				if($disciplina['estado'] != 'Rep Freq'){
					$sumTotal+= ($disciplina['valor'] * $disciplina['carga']);
				}

				$cont += $disciplina['carga'];
			}

			if($sumTotal == 0 || $cont == 0)
				$value['ira'] = 0;
			else
				$value['ira'] = $sumTotal/$cont;
		}

		foreach($alunos as $chave => $valor) {

			echo "<tr><td>".$valor["id"]."</td><td>".$valor["nome"]."</td><td>".$valor["matricula"]."</td><td>".$valor["ira"]."</td></tr>";
		}
		echo "</table>";
		
		
		echo "<li><a href='pagAdmin.php'>Retornar</a><br></li>";
		


	?>
