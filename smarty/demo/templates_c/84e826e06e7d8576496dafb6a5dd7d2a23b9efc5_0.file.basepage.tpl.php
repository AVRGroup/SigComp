<?php
/* Smarty version 3.1.30, created on 2018-01-04 12:41:02
  from "C:\wamp64\www\Smarty\demo\templates\basepage.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_5a4e20de97d480_63188164',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '84e826e06e7d8576496dafb6a5dd7d2a23b9efc5' => 
    array (
      0 => 'C:\\wamp64\\www\\Smarty\\demo\\templates\\basepage.tpl',
      1 => 1514994451,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5a4e20de97d480_63188164 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_loadInheritance();
$_smarty_tpl->inheritance->init($_smarty_tpl, false);
?>
<html> 
	<head>
	<meta http-equiv="Content-Type" content="text/html"; charset="utf-8">
	<title></title>
    <link rel="stylesheet" type="text/css" href="estilopag.css">
	</head>
	
<body>

 <header id="header"> <?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_85815a4e20de9714c3_04948072', "head");
?>

    </header>
	<div id="wrapper">
        <nav id="nav"> 
		<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_317065a4e20de9766e1_17178757', "lateral");
?>

        </nav>
		<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_225395a4e20de97b668_41132514', "mid");
?>

    </div>
</body>
</html><?php }
/* {block "head"} */
class Block_85815a4e20de9714c3_04948072 extends Smarty_Internal_Block
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
class Block_317065a4e20de9766e1_17178757 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

		<?php
}
}
/* {/block "lateral"} */
/* {block "mid"} */
class Block_225395a4e20de97b668_41132514 extends Smarty_Internal_Block
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
