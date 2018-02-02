<?php
error_reporting(E_ERROR | E_WARNING | E_PARSE);

//
// Define as variáveis locais 
//
$ComandoSQL = "";
session_start();
$matricula = $_SESSION['login'];
// abre conexão com o banco
require_once 'conexao.php';
// abre conexão com o banco
switch ($_POST['form_operacao'])
	{
	case "alteracao":
	try
	{	
		$senhaA = $_SESSION['senha'];
		$senhaAC = $_POST['senhaA'];
		$senha = $_POST['senhaN'];
		$senhaC = $_POST['senhaC'];
		if($senhaAC == $senhaA){
			if ($senha == $senhaC){
				
						
					// recebe os dados do formulário
					//$senha = $_POST['senha'];
							

					$stmt = $conn->prepare('UPDATE aluno SET  
					senha =:senha WHERE matricula = :matricula');
					$stmt->bindValue(':senha', $senha);
							$stmt->bindValue(':matricula', $matricula);
					$stmt->execute();
					echo "<script>alert('Usuário alterado com sucesso, por favor, logue novamente!');
					window.location='index.php';</script>";
					exit;
					break;
				
			}
			else{
				echo "<script>alert('Senhas não correspondem!');
			window.location='index.php';</script>";
			exit;
			break;
			}
		}
		else{
			echo "<script>alert('Senha Atual incorreta!". $senhaA.$senhaN.$senhaC."');
			window.location='index.php';</script>";
			exit;
			break;
		}
	}
	catch (PDOException $e)
	{
	// caso ocorra uma exceção, exibe na tela
		print "Erro!: " . $e->getMessage() . "\n";
		die();
	}
	case "exclusao":
	try
	{
		// recebe os dados do formulário
		$matricula = $_POST['matricula'];
		$stmt = $conn->prepare('DELETE from aluno WHERE matricula = :matricula');
                $stmt->bindValue(':matricula', $matricula);
		$stmt->execute();
		echo "<script>alert('Usuário alterado com sucesso!');
		window.location='index.php';</script>";
		exit;
		break;
	}
	catch (PDOException $e)
	{
	// caso ocorra uma exceção, exibe na tela
		print "Erro!: " . $e->getMessage() . "\n";
		die();
	}	
}
// executa uma instrução SQL de consulta
$ComandoSQL = "SELECT * FROM aluno WHERE matricula = '" . $matricula . "'";
$result = $conn->query($ComandoSQL);

$row = $result->fetch(PDO::FETCH_OBJ);
?>
