
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

<form action="uploadperfil.php" method="post" enctype="multipart/form-data">
  <center>  Escolha o arquivo a ser enviado:
    <input type="file" name="fileToUpload" id="fileToUpload"><br>
    <input type="submit" value="Upload Image" name="submit">
	</center>
</form>

</body>
</html>

{/block}

