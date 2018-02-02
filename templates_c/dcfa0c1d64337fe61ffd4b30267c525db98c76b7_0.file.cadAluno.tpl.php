<?php
/* Smarty version 3.1.30, created on 2018-01-29 12:52:49
  from "C:\wamp64\www\ProjetoGamificacao-master\templates\cadAluno.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_5a6f1921424ea9_57162773',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'dcfa0c1d64337fe61ffd4b30267c525db98c76b7' => 
    array (
      0 => 'C:\\wamp64\\www\\ProjetoGamificacao-master\\templates\\cadAluno.tpl',
      1 => 1517230289,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:basepage.tpl' => 1,
  ),
),false)) {
function content_5a6f1921424ea9_57162773 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_loadInheritance();
$_smarty_tpl->inheritance->init($_smarty_tpl, true);
?>



<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_238755a6f1921414d43_39923818', "lateral");
?>


<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_204165a6f192141c379_31134266', "mid");
$_smarty_tpl->inheritance->endChild();
$_smarty_tpl->_subTemplateRender("file:basepage.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 2, false);
}
/* {block "lateral"} */
class Block_238755a6f1921414d43_39923818 extends Smarty_Internal_Block
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
/* {block "mid"} */
class Block_204165a6f192141c379_31134266 extends Smarty_Internal_Block
{
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
