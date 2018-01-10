<?php
/* Smarty version 3.1.30, created on 2018-01-04 12:24:29
  from "/var/www/html/smarty/demo/templates/upfile.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_5a4e1cfdec5361_59165298',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'fabcd8495c58ce9844f2f15d05aa5b45aafa4a55' => 
    array (
      0 => '/var/www/html/smarty/demo/templates/upfile.tpl',
      1 => 1515003413,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:basepage.tpl' => 1,
  ),
),false)) {
function content_5a4e1cfdec5361_59165298 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_loadInheritance();
$_smarty_tpl->inheritance->init($_smarty_tpl, true);
?>


<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_10913593875a4e1cfdec46f6_94358915', "mid");
$_smarty_tpl->inheritance->endChild();
$_smarty_tpl->_subTemplateRender("file:basepage.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 2, false);
}
/* {block "mid"} */
class Block_10913593875a4e1cfdec46f6_94358915 extends Smarty_Internal_Block
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

<?php
}
}
/* {/block "mid"} */
}
