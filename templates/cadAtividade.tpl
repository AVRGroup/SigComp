
{extends 'basepage.tpl'}

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