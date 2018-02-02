
{extends 'basepage.tpl'}

{block name = "lateral" } <center >    
 <body>
        <h1>Página do Administrador</h1>
         <form method="POST" action="router.php">
            <input type="submit" value="Cadastrar aluno" id="submit" name="submit"><br>
            <input type="submit" value="Excluir aluno" id="excAluno" name="submit"><br>
            <input type="submit" value="Cadastrar atividade" id="btnCadAtividade" name="submit"><br>
            <input type="submit" value="Excluir atividade" id="btnExcAtividade" name="submit">
		</form>
			<button onclick="window.location='consAluno.php';"> Consultar Alunos </button>		
			<button onclick="window.location='consAtividade.php';"> Consultar Atividades </button>	
		<form method="POST" action="router.php">
			<br><input type="submit" value="Logout" id="logout" name="submit">
		</form>			
    </body> </h1> 
	</center> 
	{/block}

{block name = "mid" } <center >     
    <body>
        <form method="POST" action="cadAluno.php">
        <label>Nome:</label><input type="text" name="nome" id="nome"><br>
        <label>Matrícula:</label><input type="text" name="matricula" id="matricula"><br>
        <label>Grade:</label><input type="text" name="grade" id="grade"><br>
        <label>Código do Curso:</label><input type="text" name="codCurso" id="codCurso"><br>
        <input type="submit" value="Cadastrar" id="cadastrar" name="cadastrar"></form>
    </body>  </center> {/block}