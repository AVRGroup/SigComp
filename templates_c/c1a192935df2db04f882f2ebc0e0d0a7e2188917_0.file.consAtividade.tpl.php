<?php
/* Smarty version 3.1.31, created on 2018-01-08 17:00:24
  from "/var/www/html/templates/consAtividade.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.31',
  'unifunc' => 'content_5a53a3a8a036c3_67041819',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'c1a192935df2db04f882f2ebc0e0d0a7e2188917' => 
    array (
      0 => '/var/www/html/templates/consAtividade.tpl',
      1 => 1515433858,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5a53a3a8a036c3_67041819 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_loadInheritance();
$_smarty_tpl->inheritance->init($_smarty_tpl, true);
?>



<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_11407369305a53a3a89fe484_56017481', "head");
?>


<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_8589652315a53a3a8a00251_04554378', "mid");
$_smarty_tpl->inheritance->endChild($_smarty_tpl, 'basepage.tpl');
}
/* {block "head"} */
class Block_11407369305a53a3a89fe484_56017481 extends Smarty_Internal_Block
{
public $subBlocks = array (
  'head' => 
  array (
    0 => 'Block_11407369305a53a3a89fe484_56017481',
  ),
);
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>


<center>
        <h1>Atividades</h1>
		</center>


<?php
}
}
/* {/block "head"} */
/* {block "mid"} */
class Block_8589652315a53a3a8a00251_04554378 extends Smarty_Internal_Block
{
public $subBlocks = array (
  'mid' => 
  array (
    0 => 'Block_8589652315a53a3a8a00251_04554378',
  ),
);
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>
 
<center>
	<?php 
     include 'consHelper2.php'; 
	?>

</center>


 <?php
}
}
/* {/block "mid"} */
}
