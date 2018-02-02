
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

{block name = "mid" } 
<center>
    <body>
    <form method="POST" action="cadAtividade.php">
        <label>Experiência:</label><input type="text" name="experiencia" id="experiencia"><br>
        <label>Desempenho:</label><input type="text" name="desempenho" id="desempenho"><br>
        <label>Tipo:</label><input type="text" name="tipo" id="tipo"><br>
        <label>ID aluno:</label><input type="text" name="idAluno" id="idAluno"><br>
        <input type="submit" value="Cadastrar" id="cadastrar" name="cadastrar"></form>
    </body>
</center>




 {/block}