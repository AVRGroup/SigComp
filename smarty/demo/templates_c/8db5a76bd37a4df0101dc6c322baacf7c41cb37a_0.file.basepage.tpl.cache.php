<?php
/* Smarty version 3.1.30, created on 2018-01-03 15:47:33
  from "C:\wamp64\www\smarty\demo\templates\basepage.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_5a4cfb158de832_60242221',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '8db5a76bd37a4df0101dc6c322baacf7c41cb37a' => 
    array (
      0 => 'C:\\wamp64\\www\\smarty\\demo\\templates\\basepage.tpl',
      1 => 1514994451,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5a4cfb158de832_60242221 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_loadInheritance();
$_smarty_tpl->inheritance->init($_smarty_tpl, false);
$_smarty_tpl->compiled->nocache_hash = '144675a4cfb15887d01_72372900';
?>
<html> 
	<head>
	<meta http-equiv="Content-Type" content="text/html"; charset="utf-8">
	<title></title>
    <link rel="stylesheet" type="text/css" href="estilopag.css">
	</head>
	
<body>

 <header id="header"> <?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_107525a4cfb158d25e6_86717298', "head");
?>

    </header>
	<div id="wrapper">
        <nav id="nav"> 
		<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_46655a4cfb158d7b87_92268067', "lateral");
?>

        </nav>
		<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_206065a4cfb158dca32_12982997', "mid");
?>

    </div>
</body>
</html><?php }
/* {block "head"} */
class Block_107525a4cfb158d25e6_86717298 extends Smarty_Internal_Block
{
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
class Block_46655a4cfb158d7b87_92268067 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

		<?php
}
}
/* {/block "lateral"} */
/* {block "mid"} */
class Block_206065a4cfb158dca32_12982997 extends Smarty_Internal_Block
{
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
