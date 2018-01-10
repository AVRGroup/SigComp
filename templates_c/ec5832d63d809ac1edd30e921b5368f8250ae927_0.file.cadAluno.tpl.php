<?php
/* Smarty version 3.1.31, created on 2018-01-08 15:38:41
  from "/var/www/html/templates/cadAluno.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.31',
  'unifunc' => 'content_5a5390819dee09_14713326',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'ec5832d63d809ac1edd30e921b5368f8250ae927' => 
    array (
      0 => '/var/www/html/templates/cadAluno.tpl',
      1 => 1515087487,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5a5390819dee09_14713326 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_loadInheritance();
$_smarty_tpl->inheritance->init($_smarty_tpl, true);
?>



<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_18888193075a5390819dbe11_90945692', "mid");
$_smarty_tpl->inheritance->endChild($_smarty_tpl, 'basepage.tpl');
}
/* {block "mid"} */
class Block_18888193075a5390819dbe11_90945692 extends Smarty_Internal_Block
{
public $subBlocks = array (
  'mid' => 
  array (
    0 => 'Block_18888193075a5390819dbe11_90945692',
  ),
);
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>
 <center >     
    <body>
        <form method="POST" action="cadAluno.php">
        <label>Nome:</label><input type="text" name="nome" id="nome"><br>
        <label>Matrícula:</label><input type="text" name="matricula" id="matricula"><br>
        <label>Grade:</label><input type="text" name="grade" id="grade"><br>
        <label>Código do Curso:</label><input type="text" name="codCurso" id="codCurso"><br>
        <input type="submit" value="Cadastrar" id="cadastrar" name="cadastrar"></form>
    </body>  </center> <?php
}
}
/* {/block "mid"} */
}
