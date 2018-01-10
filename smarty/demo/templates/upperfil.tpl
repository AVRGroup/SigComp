
{extends 'basepage.tpl'}

{block name= "mid"}
<html>
    <head>
        <meta charset="utf-8">
    </head>
<body>

<form action="uploadperfil.php" method="post" enctype="multipart/form-data">
  <center>  Escolha o arquivo a ser enviado:
    <input type="file" name="fileToUpload" id="fileToUpload"><br>
    <input type="submit" value="Upload Image" name="submit">
	</center>
</form>

</body>
</html>

{/block}

