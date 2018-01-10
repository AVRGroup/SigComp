
{extends 'basepage.tpl'}

{block name = "mid" } 
<center>
    <body>
        <form method="POST" action="excAluno.php">
        <label>Matrícula:</label><input type="text" name="matricula" id="matricula"><br>
        <input type="submit" value="Deletar" id="deleta" name="deleta"></form>

    </body>
</center>




 {/block}