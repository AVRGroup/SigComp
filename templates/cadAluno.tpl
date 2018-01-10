
{extends 'basepage.tpl'}

{block name = "mid" } <center >     
    <body>
        <form method="POST" action="cadAluno.php">
        <label>Nome:</label><input type="text" name="nome" id="nome"><br>
        <label>Matrícula:</label><input type="text" name="matricula" id="matricula"><br>
        <label>Grade:</label><input type="text" name="grade" id="grade"><br>
        <label>Código do Curso:</label><input type="text" name="codCurso" id="codCurso"><br>
        <input type="submit" value="Cadastrar" id="cadastrar" name="cadastrar"></form>
    </body>  </center> {/block}