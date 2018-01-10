<?php
/* Smarty version 3.1.30, created on 2018-01-03 15:40:33
  from "C:\wamp64\www\smarty\demo\templates\outro.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_5a4cf971431978_47909066',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '627e7ab3a5020e39722d60878236d93ec54c0d54' => 
    array (
      0 => 'C:\\wamp64\\www\\smarty\\demo\\templates\\outro.tpl',
      1 => 1514994031,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:basepage.tpl' => 1,
  ),
),false)) {
function content_5a4cf971431978_47909066 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_loadInheritance();
$_smarty_tpl->inheritance->init($_smarty_tpl, true);
$_smarty_tpl->compiled->nocache_hash = '13225a4cf9713ba455_32909919';
?>



<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_120595a4cf971412b18_65382999', "head");
?>

<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_309045a4cf97141c1f1_74641752', "lateral");
?>

<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_98735a4cf97142f205_73932310', "mid");
$_smarty_tpl->inheritance->endChild();
$_smarty_tpl->_subTemplateRender("file:basepage.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 9999, $_smarty_tpl->cache_lifetime, array(), 2, false);
}
/* {block "head"} */
class Block_120595a4cf971412b18_65382999 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>
 <center > <h1> ADD </h1> </center> <?php
}
}
/* {/block "head"} */
/* {block "lateral"} */
class Block_309045a4cf97141c1f1_74641752 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>
 <center > <h1> $var </h1> </center> <?php
}
}
/* {/block "lateral"} */
/* {block "mid"} */
class Block_98735a4cf97142f205_73932310 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>
 <center >  <?php echo $_smarty_tpl->tpl_vars['var']->value;?>
  </center> <?php
}
}
/* {/block "mid"} */
}
