<?php
/* Smarty version 3.1.30, created on 2018-01-26 16:33:30
  from "C:\wamp64\www\ProjetoGamificacao-master\templates\pagAdmin.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_5a6b585a24ddd8_87203009',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '9dd990b0ab5c173233969160e435747bf0485ae9' => 
    array (
      0 => 'C:\\wamp64\\www\\ProjetoGamificacao-master\\templates\\pagAdmin.tpl',
      1 => 1516984403,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:basepage.tpl' => 1,
  ),
),false)) {
function content_5a6b585a24ddd8_87203009 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_loadInheritance();
$_smarty_tpl->inheritance->init($_smarty_tpl, true);
?>




<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_202525a6b585a24b580_67862876', "lateral");
?>

<?php $_smarty_tpl->inheritance->endChild();
$_smarty_tpl->_subTemplateRender("file:basepage.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 2, false);
}
/* {block "lateral"} */
class Block_202525a6b585a24b580_67862876 extends Smarty_Internal_Block
{
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
		<form method="POST" action="router.php">
			<br><input type="submit" value="Logout" id="logout" name="submit">
		</form>							
    </body> </h1> 
	</center> 
	<?php
}
}
/* {/block "lateral"} */
}
