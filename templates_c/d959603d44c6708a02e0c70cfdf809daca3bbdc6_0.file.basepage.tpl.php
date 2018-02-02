<?php
/* Smarty version 3.1.30, created on 2018-01-30 13:11:48
  from "C:\wamp64\www\ProjetoGamificacao-master\templates\basepage.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_5a706f14d61566_67450077',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'd959603d44c6708a02e0c70cfdf809daca3bbdc6' => 
    array (
      0 => 'C:\\wamp64\\www\\ProjetoGamificacao-master\\templates\\basepage.tpl',
      1 => 1517317904,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5a706f14d61566_67450077 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_loadInheritance();
$_smarty_tpl->inheritance->init($_smarty_tpl, false);
?>
<html> 
	<head>
	<meta http-equiv="Content-Type" content="text/html"; charset="utf-8"; content="width=device-width, initial-scale=1">
	<title></title>
    <link rel="stylesheet" type="text/css" href="estilopag.css">
	</head>
	
<body style="overflow:auto">

 <header id="header"> 
    
		<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_327105a706f14d4c997_74810813', "head");
?>

	
    </header>
	<div id="wrapper" style="overflow:auto">
        <nav id="nav"> 
		<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_275275a706f14d55542_88296146', "lateral");
?>

        </nav>
		<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_68365a706f14d5df97_12379305', "mid");
?>

    </div>
</body>
</html><?php }
/* {block "head"} */
class Block_327105a706f14d4c997_74810813 extends Smarty_Internal_Block
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
class Block_275275a706f14d55542_88296146 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

		<?php
}
}
/* {/block "lateral"} */
/* {block "mid"} */
class Block_68365a706f14d5df97_12379305 extends Smarty_Internal_Block
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
