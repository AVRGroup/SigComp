<?php
/* Smarty version 3.1.31, created on 2018-01-04 13:28:32
  from "/var/www/html/templates/upfile.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.31',
  'unifunc' => 'content_5a4e2c0052fb72_35603807',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'c320f81055b90dcad98593a999c8665da2d002b5' => 
    array (
      0 => '/var/www/html/templates/upfile.tpl',
      1 => 1515003413,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5a4e2c0052fb72_35603807 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_loadInheritance();
$_smarty_tpl->inheritance->init($_smarty_tpl, true);
?>


<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_11500229995a4e2c0052dd71_20995190', "mid");
$_smarty_tpl->inheritance->endChild($_smarty_tpl, 'basepage.tpl');
}
/* {block "mid"} */
class Block_11500229995a4e2c0052dd71_20995190 extends Smarty_Internal_Block
{
public $subBlocks = array (
  'mid' => 
  array (
    0 => 'Block_11500229995a4e2c0052dd71_20995190',
  ),
);
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
