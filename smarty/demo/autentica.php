<?php
session_start();

require_once 'conexao.php';

$matricula = protecao($_POST['matricula']);
$senha = protecao($_POST['senha']);

try
{
    $srchLogin = $conn->prepare("SELECT * FROM aluno WHERE matricula = '$matricula' AND senha = '$senha'");
    $srchLogin->execute();
    $result = $srchLogin->rowCount();

    if ($result == 1){
        $srchAdm = $conn->prepare("SELECT * FROM aluno WHERE matricula = '$matricula' AND senha = '$senha' AND usrTipe = 1");
        $srchAdm->execute();
        $resultAdm = $srchAdm->rowCount();
        $_SESSION['login'] = $matricula;
        $_SESSION['senha'] = $senha;
        if ($resultAdm == 1) {
            echo "<script>location.href='adminMain.html'</script>";
        }else{
            echo "<script>location.href='pagAluno.php'</script>";
        }
    }else{
        unset ($_SESSION['login']);
        unset ($_SESSION['senha']);
        echo "<script>alert('Usuário e senha não correspondem.'); history.back();</script>";
    }
    $conn = null;
}
catch (PDOException $e)
{
    echo "Erro!: " . $e->getMessage() . "<br/>";
}
?>
