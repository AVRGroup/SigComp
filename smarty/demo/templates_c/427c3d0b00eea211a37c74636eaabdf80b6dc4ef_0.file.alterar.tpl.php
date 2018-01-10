<?php
/* Smarty version 3.1.30, created on 2018-01-03 18:47:19
  from "C:\wamp64\www\smarty\demo\templates\alterar.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_5a4d25376ea5e3_93756533',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '427c3d0b00eea211a37c74636eaabdf80b6dc4ef' => 
    array (
      0 => 'C:\\wamp64\\www\\smarty\\demo\\templates\\alterar.tpl',
      1 => 1515005233,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:basepage.tpl' => 1,
  ),
),false)) {
function content_5a4d25376ea5e3_93756533 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_loadInheritance();
$_smarty_tpl->inheritance->init($_smarty_tpl, true);
?>



<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_129465a4d25376e86d9_03142402', "mid");
$_smarty_tpl->inheritance->endChild();
$_smarty_tpl->_subTemplateRender("file:basepage.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 2, false);
}
/* {block "mid"} */
class Block_129465a4d25376e86d9_03142402 extends Smarty_Internal_Block
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
