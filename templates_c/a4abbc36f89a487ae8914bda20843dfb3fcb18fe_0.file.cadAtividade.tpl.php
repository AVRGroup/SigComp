<?php
/* Smarty version 3.1.30, created on 2018-01-29 12:52:50
  from "C:\wamp64\www\ProjetoGamificacao-master\templates\cadAtividade.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_5a6f1922c77852_34948587',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'a4abbc36f89a487ae8914bda20843dfb3fcb18fe' => 
    array (
      0 => 'C:\\wamp64\\www\\ProjetoGamificacao-master\\templates\\cadAtividade.tpl',
      1 => 1517230331,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:basepage.tpl' => 1,
  ),
),false)) {
function content_5a6f1922c77852_34948587 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_loadInheritance();
$_smarty_tpl->inheritance->init($_smarty_tpl, true);
?>


<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_195185a6f1922c70800_65824489', "lateral");
?>


<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_27195a6f1922c761c1_94307810', "mid");
$_smarty_tpl->inheritance->endChild();
$_smarty_tpl->_subTemplateRender("file:basepage.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 2, false);
}
/* {block "lateral"} */
class Block_195185a6f1922c70800_65824489 extends Smarty_Internal_Block
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
class Block_27195a6f1922c761c1_94307810 extends Smarty_Internal_Block
{
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
