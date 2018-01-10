<?php
/* Smarty version 3.1.31, created on 2018-01-08 15:39:21
  from "/var/www/html/templates/excAtividade.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.31',
  'unifunc' => 'content_5a5390a9132029_71580541',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '3e54da55835ea3b95f9c3219081378e2838d1c67' => 
    array (
      0 => '/var/www/html/templates/excAtividade.tpl',
      1 => 1515085366,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5a5390a9132029_71580541 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_loadInheritance();
$_smarty_tpl->inheritance->init($_smarty_tpl, true);
?>



<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_4958006565a5390a912e807_41392001', "mid");
$_smarty_tpl->inheritance->endChild($_smarty_tpl, 'basepage.tpl');
}
/* {block "mid"} */
class Block_4958006565a5390a912e807_41392001 extends Smarty_Internal_Block
{
public $subBlocks = array (
  'mid' => 
  array (
    0 => 'Block_4958006565a5390a912e807_41392001',
  ),
);
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>
 
<center>
    <body>
        <form method="POST" action="excAtividade.php">
        <label>ID Atividade:</label><input type="text" name="id_atividade" id="id_atividade"><br>
        <input type="submit" value="Deletar" id="deleta" name="deleta"></form>
    </body>
</center>




 <?php
}
}
/* {/block "mid"} */
}
