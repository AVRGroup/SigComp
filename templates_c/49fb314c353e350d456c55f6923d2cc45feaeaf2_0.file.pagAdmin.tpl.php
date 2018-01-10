<?php
/* Smarty version 3.1.31, created on 2018-01-09 16:40:10
  from "/var/www/html/templates/pagAdmin.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.31',
  'unifunc' => 'content_5a54f06aa9ae05_27108928',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '49fb314c353e350d456c55f6923d2cc45feaeaf2' => 
    array (
      0 => '/var/www/html/templates/pagAdmin.tpl',
      1 => 1515433270,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5a54f06aa9ae05_27108928 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_loadInheritance();
$_smarty_tpl->inheritance->init($_smarty_tpl, true);
?>




<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_67991885a54f06aa987d7_51867603', "lateral");
?>

<?php $_smarty_tpl->inheritance->endChild($_smarty_tpl, 'basepage.tpl');
}
/* {block "lateral"} */
class Block_67991885a54f06aa987d7_51867603 extends Smarty_Internal_Block
{
public $subBlocks = array (
  'lateral' => 
  array (
    0 => 'Block_67991885a54f06aa987d7_51867603',
  ),
);
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>
 <center >    
 <body>
        <h1>Página do Administrador</h1>
        <form method="POST" action="router.php">
            <input type="submit" value="Cadastrar aluno" id="submit" name="submit"><br>
            <input type="submit" value="Excluir aluno" id="excAluno" name="submit"><br>
            <input type="submit" value="Cadastrar atividade" id="btnCadAtividade" name="submit"><br>
            <input type="submit" value="Excluir atividade" id="btnExcAtividade" name="submit">
        </form>
		
			<button onclick="window.location='consAluno.php';"> Consultar Alunos </button>		
			<button onclick="window.location='consAtividade.php';"> Consultar Atividades </button>				
    </body> </h1> 
	</center> 
	<?php
}
}
/* {/block "lateral"} */
}
