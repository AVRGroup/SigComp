{extends 'basepage.tpl'}

{block name = "lateral" }             
<section>
			<center>
				<h1>Página do Aluno</h1>
				<button onclick="window.location='pagAluno.php';"> Perfil</button>
				<form action="router.php" method="post" enctype="multipart/form-data">
				<input type="submit" value="Alterar Dados" name="submit"><br>
				<input type="submit" value="Enviar Certificados" name="submit"><br>
				<input type="submit" value="Trocar Perfil" name="submit"><br>
				<br><input type="submit" value="Logout" id="logout" name="submit">
				</form>		
			</center>
				
				
</section> 
{/block}

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
	<table>
	 <br>
	<tr><td><input type="radio" name="tipo" value="palestra"> Certificado de participação em palestra</td></tr>
    <tr><td><input type="radio" name="tipo" value="p_minicurso"> Certificado de participação em minicurso</td></tr>
    <tr><td><input type="radio" name="tipo" value="a_minicurso"> Certificado de apresentação de minicurso</td></tr>
	<tr><td><input type="radio" name="tipo" value="maratona"> Certificado de participação em maratona</td></tr>
	<tr><td><input type="radio" name="tipo" value="artigo"> Certificado de publicação de artigo</td></tr>
	</table>
    <input type="submit" value="Upload Image" name="submit">
	</center>
</form>

</body>
</html>

{/block}