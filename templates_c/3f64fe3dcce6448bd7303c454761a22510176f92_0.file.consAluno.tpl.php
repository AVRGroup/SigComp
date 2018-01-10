<?php
/* Smarty version 3.1.31, created on 2018-01-09 17:24:36
  from "/var/www/html/templates/consAluno.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.31',
  'unifunc' => 'content_5a54fad4ce8029_98600987',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '3f64fe3dcce6448bd7303c454761a22510176f92' => 
    array (
      0 => '/var/www/html/templates/consAluno.tpl',
      1 => 1515433296,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5a54fad4ce8029_98600987 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_loadInheritance();
$_smarty_tpl->inheritance->init($_smarty_tpl, true);
?>



<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_15378905315a54fad4cd5505_97247163', "head");
?>


<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_20703480845a54fad4cd7765_00431573', "mid");
$_smarty_tpl->inheritance->endChild($_smarty_tpl, 'basepage.tpl');
}
/* {block "head"} */
class Block_15378905315a54fad4cd5505_97247163 extends Smarty_Internal_Block
{
public $subBlocks = array (
  'head' => 
  array (
    0 => 'Block_15378905315a54fad4cd5505_97247163',
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
class Block_20703480845a54fad4cd7765_00431573 extends Smarty_Internal_Block
{
public $subBlocks = array (
  'mid' => 
  array (
    0 => 'Block_20703480845a54fad4cd7765_00431573',
  ),
);
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>
 
<center>
	<?php 
     require 'consHelper.php'; 
	?>
</center>



 <?php
}
}
/* {/block "mid"} */
}
