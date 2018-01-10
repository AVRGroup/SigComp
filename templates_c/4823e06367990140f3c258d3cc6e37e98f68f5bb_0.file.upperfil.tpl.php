<?php
/* Smarty version 3.1.31, created on 2018-01-04 13:28:05
  from "/var/www/html/templates/upperfil.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.31',
  'unifunc' => 'content_5a4e2be59cebb3_80471871',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '4823e06367990140f3c258d3cc6e37e98f68f5bb' => 
    array (
      0 => '/var/www/html/templates/upperfil.tpl',
      1 => 1515003114,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5a4e2be59cebb3_80471871 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_loadInheritance();
$_smarty_tpl->inheritance->init($_smarty_tpl, true);
?>



<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_1447619185a4e2be59cbb44_77460449', "mid");
?>


<?php $_smarty_tpl->inheritance->endChild($_smarty_tpl, 'basepage.tpl');
}
/* {block "mid"} */
class Block_1447619185a4e2be59cbb44_77460449 extends Smarty_Internal_Block
{
public $subBlocks = array (
  'mid' => 
  array (
    0 => 'Block_1447619185a4e2be59cbb44_77460449',
  ),
);
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
