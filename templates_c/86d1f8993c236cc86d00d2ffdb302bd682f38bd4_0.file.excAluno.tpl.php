<?php
/* Smarty version 3.1.30, created on 2018-01-29 12:52:49
  from "C:\wamp64\www\ProjetoGamificacao-master\templates\excAluno.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_5a6f1921015065_37289515',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '86d1f8993c236cc86d00d2ffdb302bd682f38bd4' => 
    array (
      0 => 'C:\\wamp64\\www\\ProjetoGamificacao-master\\templates\\excAluno.tpl',
      1 => 1517230304,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:basepage.tpl' => 1,
  ),
),false)) {
function content_5a6f1921015065_37289515 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_loadInheritance();
$_smarty_tpl->inheritance->init($_smarty_tpl, true);
?>



<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_251725a6f192100dfa9_13090484', "lateral");
?>

	
<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_97255a6f1921013b58_33089298', "mid");
$_smarty_tpl->inheritance->endChild();
$_smarty_tpl->_subTemplateRender("file:basepage.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 2, false);
}
/* {block "lateral"} */
class Block_251725a6f192100dfa9_13090484 extends Smarty_Internal_Block
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
class Block_97255a6f1921013b58_33089298 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>
 
<center>
    <body>
        <form method="POST" action="excAluno.php">
        <label>Matrícula:</label><input type="text" name="matricula" id="matricula"><br>
        <input type="submit" value="Deletar" id="deleta" name="deleta"></form>

    </body>
</center>




 <?php
}
}
/* {/block "mid"} */
}
