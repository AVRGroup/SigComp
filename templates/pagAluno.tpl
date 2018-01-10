
{extends 'basepage.tpl'}

{block name = "lateral" }             
<section>

				
				<form action="router.php" method="post" enctype="multipart/form-data">
				<input type="submit" value="Alterar Dados" name="submit"><br>
				<input type="submit" value="Enviar Certificados" name="submit"><br>
				<input type="submit" value="Trocar Perfil" name="submit"><br>
				</form>
				 <ul>
                    <li><a href='index.php'>Logout</a><br></li>
                </ul>
				
				
</section> 
{/block}
{block name = "mid" } 
<div id="cont">
			<div id="imgp">
				<div id="simgp">
					<table border>
					    <tr><td><img src="{$foto}" height="250" width="auto"></td></tr>
					</table>
				</div>
			</div>
			<div id="infp">
				<p class="cent"><h1>{$nome}, Título do aluno</h1></p>
				<p ><h2>Classe, {$nivel}</h2></p>
			</div>
		</div>
        <div id="lin">
			<center>Sobre fulano</center>
		</div>
		<div id="cont3">
			<div id="gp">
				<div id="sgp">
                    <h2>Atributos<h2>
                    <table border>
                        <tr><td><img src="g_img.png" width="300px" height="auto"></td></tr>
                    </table>
				</div>
			</div>
			<div id="infg">
				<div id="sinfg">
                    <h2>Achievements<h2>
                    <table border>
                        <tr><td><img src="g_img.png" width="100px" height="100px"></td><td class="long"><p>Nome</p><p>Descrição da conquista</p></td></tr>
                        <tr><td><img src="g_img.png" width="100px" height="100px"></td><td class="long"><p>Nome</p><p>Descrição da conquista</p></td></tr>
                        <tr><td><img src="g_img.png" width="100px" height="100px"></td><td class="long"><p>Nome</p><p>Descrição da conquista</p></td></tr>
                        <tr><td><img src="g_img.png" width="100px" height="100px"></td><td class="long"><p>Nome</p><p>Descrição da conquista</p></td></tr>
                    </table>
				</div>
			</div>
		</div>

{/block}