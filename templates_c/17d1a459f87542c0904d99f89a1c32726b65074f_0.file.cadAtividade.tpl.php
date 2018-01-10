<?php
/* Smarty version 3.1.31, created on 2018-01-08 15:39:01
  from "/var/www/html/templates/cadAtividade.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.31',
  'unifunc' => 'content_5a539095068ed4_22119571',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '17d1a459f87542c0904d99f89a1c32726b65074f' => 
    array (
      0 => '/var/www/html/templates/cadAtividade.tpl',
      1 => 1515085032,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5a539095068ed4_22119571 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_loadInheritance();
$_smarty_tpl->inheritance->init($_smarty_tpl, true);
?>



<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_13647505335a539095065ea0_08632246', "mid");
$_smarty_tpl->inheritance->endChild($_smarty_tpl, 'basepage.tpl');
}
/* {block "mid"} */
class Block_13647505335a539095065ea0_08632246 extends Smarty_Internal_Block
{
public $subBlocks = array (
  'mid' => 
  array (
    0 => 'Block_13647505335a539095065ea0_08632246',
  ),
);
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>
 
<center>
    <body>
    <form method="POST" action="cadAtividade.php">
        <label>Experiência:</label><input type="text" name="experiencia" id="experiencia"><br>
        <label>Desempenho:</label><input type="text" name="desempenho" id="desempenho"><br>
        <label>Tipo:</label><input type="text" name="tipo" id="tipo"><br>
        <label>ID aluno:</label><input type="text" name="idAluno" id="idAluno"><br>
        <input type="submit" value="Cadastrar" id="cadastrar" name="cadastrar"></form>
    </body>
</center>




 <?php
}
}
/* {/block "mid"} */
}
