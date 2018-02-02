<?php
/* Smarty version 3.1.30, created on 2018-02-01 23:58:29
  from "C:\wamp64\www\ProjetoGamificacao-master\templates\alterar.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_5a73a9a5db55d3_66493790',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'fca63c6a146b3bf1914a18fd31c69345878cbfc0' => 
    array (
      0 => 'C:\\wamp64\\www\\ProjetoGamificacao-master\\templates\\alterar.tpl',
      1 => 1517529507,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:basepage.tpl' => 1,
  ),
),false)) {
function content_5a73a9a5db55d3_66493790 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_loadInheritance();
$_smarty_tpl->inheritance->init($_smarty_tpl, true);
?>



<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_56245a73a9a5da6014_01175539', "lateral");
?>


<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_68655a73a9a5db22d7_57133800', "mid");
$_smarty_tpl->inheritance->endChild();
$_smarty_tpl->_subTemplateRender("file:basepage.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 2, false);
}
/* {block "lateral"} */
class Block_56245a73a9a5da6014_01175539 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>
             
<section>
			<center>
				<h1>Página do Aluno</h1>
				<button onclick="window.location='pagAluno.php';"> Perfil</button>
				<form action="router.php" method="post" enctype="multipart/form-data">
				<input type="submit" value="Alterar Dados" name="submit"><br>
				<input type="submit" value="Enviar Certificados" name="submit"><br>
				<input type="submit" value="Trocar Perfil" name="submit"><br>
				<br><input type="submit" value="Logout" id="logout" name="submit">
				</form>		
			</center>
				
				
</section> 
<?php
}
}
/* {/block "lateral"} */
/* {block "mid"} */
class Block_68655a73a9a5db22d7_57133800 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>
 
        <?php echo '<script'; ?>
 LANGUAGE="JavaScript">
          function define_operacao(operacao){
            if (operacao == "alt") {
               document.form_alteracao_exclusao_receitas.form_operacao.value = "alteracao";
            }
            if (operacao == "exc") {
               document.form_alteracao_exclusao_receitas.form_operacao.value = "exclusao";
            }
            document.form_alteracao_exclusao_receitas.submit();
          }
          <?php echo '</script'; ?>
>

<center>
			<div id="content">
            <div class="innertube">
            <h1>Descrição:</h1>
            <p>&nbsp;</p>
            <p><strong>Aluno</strong></p>
            <p>&nbsp;</p>
            <form method="POST" action="alterar.php" name="form_alteracao_exclusao_receitas">
            <table width="600">
			<tr>
			<td class="td_r">Senha atual:</td>
			<td>
			  <input name="senhaA" type="password" id="senhaA" size="30" maxlength="30" required="required" value="">*
			</td>
		  </tr>
			<tr>
			<td class="td_r">Nova senha:</td>
			<td>
			  <input name="senhaN" type="password" id="senhaN" size="30" maxlength="30" required="required" value="">*
			</td>
		  </tr>
		  <tr>
			<td class="td_r">Repita a senha:</td>
			<td>
			  <input name="senhaC" type="password" id="senhaC" size="30" maxlength="30" required="required" value="">*
			</td>
		  </tr>
		  <tr>
			<td colspan='2'class="td_c">* dados obrigatórios 
			</td>
		  </tr>
		  <tr>
			<td colspan='2' class="td_c">
			  <input type="hidden" name="form_operacao" value="consulta">
			  <center><input name="alterar" type="button" value="Alterar" onClick="define_operacao('alt');"></center>

			</td>
		  </tr>
		  </table>
	  </form>
	  </center><?php
}
}
/* {/block "mid"} */
}
