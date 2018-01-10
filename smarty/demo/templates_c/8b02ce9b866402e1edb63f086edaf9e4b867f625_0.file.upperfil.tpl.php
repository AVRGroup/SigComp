<?php
/* Smarty version 3.1.30, created on 2018-01-03 18:12:06
  from "C:\wamp64\www\smarty\demo\templates\upperfil.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_5a4d1cf67f4cb7_70249943',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '8b02ce9b866402e1edb63f086edaf9e4b867f625' => 
    array (
      0 => 'C:\\wamp64\\www\\smarty\\demo\\templates\\upperfil.tpl',
      1 => 1515003114,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:basepage.tpl' => 1,
  ),
),false)) {
function content_5a4d1cf67f4cb7_70249943 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_loadInheritance();
$_smarty_tpl->inheritance->init($_smarty_tpl, true);
?>



<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_28705a4d1cf67f3038_64468760', "mid");
?>


<?php $_smarty_tpl->inheritance->endChild();
$_smarty_tpl->_subTemplateRender("file:basepage.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 2, false);
}
/* {block "mid"} */
class Block_28705a4d1cf67f3038_64468760 extends Smarty_Internal_Block
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
