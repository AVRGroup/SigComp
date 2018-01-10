<?php
/* Smarty version 3.1.31, created on 2018-01-08 15:38:45
  from "/var/www/html/templates/excAluno.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.31',
  'unifunc' => 'content_5a539085b1cda8_29600019',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '23bfbc36fd94b0c7dd614780ac191cd1f3058a66' => 
    array (
      0 => '/var/www/html/templates/excAluno.tpl',
      1 => 1515085296,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5a539085b1cda8_29600019 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_loadInheritance();
$_smarty_tpl->inheritance->init($_smarty_tpl, true);
?>



<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_4337091115a539085b1b985_10136846', "mid");
$_smarty_tpl->inheritance->endChild($_smarty_tpl, 'basepage.tpl');
}
/* {block "mid"} */
class Block_4337091115a539085b1b985_10136846 extends Smarty_Internal_Block
{
public $subBlocks = array (
  'mid' => 
  array (
    0 => 'Block_4337091115a539085b1b985_10136846',
  ),
);
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>
 
<center>
    <body>
        <form method="POST" action="excAluno.php">
        <label>Matrícula:</label><input type="text" name="matricula" id="matricula"><br>
        <input type="submit" value="Deletar" id="deleta" name="deleta"></form>

    </body>
</center>




 <?php
}
}
/* {/block "mid"} */
}
