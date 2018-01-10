<?php
/* Smarty version 3.1.31, created on 2018-01-04 13:45:27
  from "/var/www/html/templates/alterar.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.31',
  'unifunc' => 'content_5a4e2ff766fa63_40359810',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '0413f2e2a17e1086e04c828b7a515440f8813da3' => 
    array (
      0 => '/var/www/html/templates/alterar.tpl',
      1 => 1515005233,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5a4e2ff766fa63_40359810 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_loadInheritance();
$_smarty_tpl->inheritance->init($_smarty_tpl, true);
?>



<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_658799815a4e2ff766c198_41663089', "mid");
$_smarty_tpl->inheritance->endChild($_smarty_tpl, 'basepage.tpl');
}
/* {block "mid"} */
class Block_658799815a4e2ff766c198_41663089 extends Smarty_Internal_Block
{
public $subBlocks = array (
  'mid' => 
  array (
    0 => 'Block_658799815a4e2ff766c198_41663089',
  ),
);
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
			<td class="td_r">Senha:</td>
			<td>
			  <input name="senha" type="password" id="senha" size="30" maxlength="30" required="required" value="">*
			</td>
		  </tr>
		  <tr>
			<td colspan='2'class="td_c">* dados obrigatórios 
			</td>
		  </tr>
		  <tr>
			<td colspan='2' class="td_c">
			  <input type="hidden" name="form_operacao" value="consulta">
			  <input name="alterar" type="button" value="Alterar" onClick="define_operacao('alt');">
                          <input name="exclusao" type="button" value="Excluir" onClick="define_operacao('exc');">
						  
						    <li><a href="pagAluno.php"> Voltar</a></li>
			</td>
		  </tr>
		  </table>
	  </form>
	  </center><?php
}
}
/* {/block "mid"} */
}
