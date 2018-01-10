<?php
/* Smarty version 3.1.31, created on 2018-01-08 15:39:17
  from "/var/www/html/templates/consAluno2.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.31',
  'unifunc' => 'content_5a5390a520ef50_16799902',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '13215e2de714457646f47659072924ad72afab41' => 
    array (
      0 => '/var/www/html/templates/consAluno2.tpl',
      1 => 1515431942,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5a5390a520ef50_16799902 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_loadInheritance();
$_smarty_tpl->inheritance->init($_smarty_tpl, true);
?>



<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_20898995455a5390a520bbe8_76431982', "head");
?>


<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_3617037935a5390a520d6d0_41173846', "mid");
$_smarty_tpl->inheritance->endChild($_smarty_tpl, 'basepage.tpl');
}
/* {block "head"} */
class Block_20898995455a5390a520bbe8_76431982 extends Smarty_Internal_Block
{
public $subBlocks = array (
  'head' => 
  array (
    0 => 'Block_20898995455a5390a520bbe8_76431982',
  ),
);
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>


<center>
        <h1>Alunos Cadastrados</h1>
		</center>


<?php
}
}
/* {/block "head"} */
/* {block "mid"} */
class Block_3617037935a5390a520d6d0_41173846 extends Smarty_Internal_Block
{
public $subBlocks = array (
  'mid' => 
  array (
    0 => 'Block_3617037935a5390a520d6d0_41173846',
  ),
);
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>
 
<center>
	<?php 
     require 'consHelper2.php'; 
	?>
</center>



 <?php
}
}
/* {/block "mid"} */
}
