{extends 'basepage.tpl'}

{block name= "mid"}
<html>
    <head>
        <meta charset="utf-8">
    </head>
<body>

<form action="upload.php" method="post" enctype="multipart/form-data">
	<center>
    Escolha o arquivo a ser enviado:
    <input type="file" name="fileToUpload" id="fileToUpload"><br>
	Escolha o tipo:
	 <br><input type="radio" name="tipo" value="palestra"> Certificado de participação em palestra<br>
    <input type="radio" name="tipo" value="p_minicurso"> Certificado de participação em minicurso<br>
    <input type="radio" name="tipo" value="a_minicurso"> Certificado de apresentação de minicurso<br>
	<input type="radio" name="tipo" value="maratona"> Certificado de participação em maratona<br>
	<input type="radio" name="tipo" value="artigo"> Certificado de publicação de artigo<br>
    <input type="submit" value="Upload Image" name="submit">
	</center>
</form>

</body>
</html>

{/block}