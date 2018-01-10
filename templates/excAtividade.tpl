
{extends 'basepage.tpl'}

{block name = "mid" } 
<center>
    <body>
        <form method="POST" action="excAtividade.php">
        <label>ID Atividade:</label><input type="text" name="id_atividade" id="id_atividade"><br>
        <input type="submit" value="Deletar" id="deleta" name="deleta"></form>
    </body>
</center>




 {/block}