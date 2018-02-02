<?php
/* Smarty version 3.1.30, created on 2018-01-29 12:52:53
  from "C:\wamp64\www\ProjetoGamificacao-master\templates\consAtividade.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_5a6f1925408900_83375008',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '7787ce38bc8c1a316b30c4cb9caf24b6072f8caa' => 
    array (
      0 => 'C:\\wamp64\\www\\ProjetoGamificacao-master\\templates\\consAtividade.tpl',
      1 => 1517230349,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:basepage.tpl' => 1,
  ),
),false)) {
function content_5a6f1925408900_83375008 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_loadInheritance();
$_smarty_tpl->inheritance->init($_smarty_tpl, true);
?>



<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_21805a6f19253ef777_18024035', "lateral");
?>

	
<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_21575a6f19253f4ce3_78333277', "head");
?>


<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_319065a6f19254074d4_20844893', "mid");
$_smarty_tpl->inheritance->endChild();
$_smarty_tpl->_subTemplateRender("file:basepage.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 2, false);
}
/* {block "lateral"} */
class Block_21805a6f19253ef777_18024035 extends Smarty_Internal_Block
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
/* {block "head"} */
class Block_21575a6f19253f4ce3_78333277 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>


<center>
        <h1>Atividades</h1>
		</center>


<?php
}
}
/* {/block "head"} */
/* {block "mid"} */
class Block_319065a6f19254074d4_20844893 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>
 
<center>
	<?php 
     include 'consHelper2.php'; 
	?>

</center>


 <?php
}
}
/* {/block "mid"} */
}
