<?php
/* Smarty version 3.1.31, created on 2018-01-08 19:58:05
  from "/var/www/html/templates/basepage.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.31',
  'unifunc' => 'content_5a53cd4d7cae53_93187830',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '5647aef471088229da3369927d7ba8dcb5a7e346' => 
    array (
      0 => '/var/www/html/templates/basepage.tpl',
      1 => 1515437607,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5a53cd4d7cae53_93187830 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_loadInheritance();
$_smarty_tpl->inheritance->init($_smarty_tpl, false);
?>
<html> 
	<head>
	<meta http-equiv="Content-Type" content="text/html"; charset="utf-8">
	<title></title>
    <link rel="stylesheet" type="text/css" href="estilopag.css">
	</head>
	
<body style="overflow:auto">

 <header id="header"> 
    
		<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_9738504425a53cd4d7c6ac0_68153961', "head");
?>

	
    </header>
	<div id="wrapper" style="overflow:auto">
        <nav id="nav"> 
		<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_7312138865a53cd4d7c8ae2_68431829', "lateral");
?>

        </nav>
		<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_336404855a53cd4d7c9e10_04552820', "mid");
?>

    </div>
</body>
</html><?php }
/* {block "head"} */
class Block_9738504425a53cd4d7c6ac0_68153961 extends Smarty_Internal_Block
{
public $subBlocks = array (
  'head' => 
  array (
    0 => 'Block_9738504425a53cd4d7c6ac0_68153961',
  ),
);
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

	
		<center>
        <h1>GAMIFICAÇÃO</h1>
		</center>
		<?php
}
}
/* {/block "head"} */
/* {block "lateral"} */
class Block_7312138865a53cd4d7c8ae2_68431829 extends Smarty_Internal_Block
{
public $subBlocks = array (
  'lateral' => 
  array (
    0 => 'Block_7312138865a53cd4d7c8ae2_68431829',
  ),
);
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

		<?php
}
}
/* {/block "lateral"} */
/* {block "mid"} */
class Block_336404855a53cd4d7c9e10_04552820 extends Smarty_Internal_Block
{
public $subBlocks = array (
  'mid' => 
  array (
    0 => 'Block_336404855a53cd4d7c9e10_04552820',
  ),
);
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

		<div id="cont">
			<div id="imgp">
				<div id="simgp">
				</div>
			</div>
			<div id="infp">
			</div>
		</div>
		<div id="lin">
		</div>
				<div id="cont3">
			<div id="gp">
				<div id="sgp">

				</div>
			</div>
			<div id="infg">
				<div id="sinfg">
				</div>
			</div>
		</div>
		<?php
}
}
/* {/block "mid"} */
}
