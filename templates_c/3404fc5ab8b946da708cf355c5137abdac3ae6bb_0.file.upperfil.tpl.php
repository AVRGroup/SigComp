<?php
/* Smarty version 3.1.30, created on 2018-01-29 13:39:31
  from "C:\wamp64\www\ProjetoGamificacao-master\templates\upperfil.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_5a6f241397a956_39149875',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '3404fc5ab8b946da708cf355c5137abdac3ae6bb' => 
    array (
      0 => 'C:\\wamp64\\www\\ProjetoGamificacao-master\\templates\\upperfil.tpl',
      1 => 1517232548,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:basepage.tpl' => 1,
  ),
),false)) {
function content_5a6f241397a956_39149875 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_loadInheritance();
$_smarty_tpl->inheritance->init($_smarty_tpl, true);
?>



<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_118095a6f2413973910_16360128', "lateral");
?>


<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_251585a6f2413978d71_89795613', "mid");
?>


<?php $_smarty_tpl->inheritance->endChild();
$_smarty_tpl->_subTemplateRender("file:basepage.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 2, false);
}
/* {block "lateral"} */
class Block_118095a6f2413973910_16360128 extends Smarty_Internal_Block
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
class Block_251585a6f2413978d71_89795613 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

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

<?php
}
}
/* {/block "mid"} */
}
