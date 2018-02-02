<?php
/* Smarty version 3.1.30, created on 2018-02-01 23:49:53
  from "C:\wamp64\www\ProjetoGamificacao-master\templates\upfile.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_5a73a7a1694989_38643069',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'cf292e14ec3f7e412f5e40a3b1b0fd4e2e87fada' => 
    array (
      0 => 'C:\\wamp64\\www\\ProjetoGamificacao-master\\templates\\upfile.tpl',
      1 => 1517528988,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:basepage.tpl' => 1,
  ),
),false)) {
function content_5a73a7a1694989_38643069 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_loadInheritance();
$_smarty_tpl->inheritance->init($_smarty_tpl, true);
?>


<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_31665a73a7a1687c53_39973276', "lateral");
?>


<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_62075a73a7a1691845_64630682', "mid");
$_smarty_tpl->inheritance->endChild();
$_smarty_tpl->_subTemplateRender("file:basepage.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 2, false);
}
/* {block "lateral"} */
class Block_31665a73a7a1687c53_39973276 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>
             
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
<?php
}
}
/* {/block "lateral"} */
/* {block "mid"} */
class Block_62075a73a7a1691845_64630682 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

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

<?php
}
}
/* {/block "mid"} */
}
