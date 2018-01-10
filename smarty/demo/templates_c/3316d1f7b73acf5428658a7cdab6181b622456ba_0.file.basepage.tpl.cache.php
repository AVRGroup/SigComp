<?php
/* Smarty version 3.1.30, created on 2018-01-04 11:01:18
  from "/var/www/html/smarty/demo/templates/basepage.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_5a4e097ea876a9_31084246',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '3316d1f7b73acf5428658a7cdab6181b622456ba' => 
    array (
      0 => '/var/www/html/smarty/demo/templates/basepage.tpl',
      1 => 1514994451,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5a4e097ea876a9_31084246 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_loadInheritance();
$_smarty_tpl->inheritance->init($_smarty_tpl, false);
$_smarty_tpl->compiled->nocache_hash = '1975928305a4e097ea82169_87833740';
?>
<html> 
	<head>
	<meta http-equiv="Content-Type" content="text/html"; charset="utf-8">
	<title></title>
    <link rel="stylesheet" type="text/css" href="estilopag.css">
	</head>
	
<body>

 <header id="header"> <?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_18028360175a4e097ea845f6_09920011', "head");
?>

    </header>
	<div id="wrapper">
        <nav id="nav"> 
		<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_12947197635a4e097ea85c03_50230540', "lateral");
?>

        </nav>
		<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_3618151675a4e097ea86fa8_60955968', "mid");
?>

    </div>
</body>
</html><?php }
/* {block "head"} */
class Block_18028360175a4e097ea845f6_09920011 extends Smarty_Internal_Block
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
class Block_12947197635a4e097ea85c03_50230540 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

		<?php
}
}
/* {/block "lateral"} */
/* {block "mid"} */
class Block_3618151675a4e097ea86fa8_60955968 extends Smarty_Internal_Block
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
