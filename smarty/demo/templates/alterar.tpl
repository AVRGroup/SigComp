
{extends 'basepage.tpl'}

{block name = "mid" } 
        <script LANGUAGE="JavaScript">
          function define_operacao(operacao){
            if (operacao == "alt") {
               document.form_alteracao_exclusao_receitas.form_operacao.value = "alteracao";
            }
            if (operacao == "exc") {
               document.form_alteracao_exclusao_receitas.form_operacao.value = "exclusao";
            }
            document.form_alteracao_exclusao_receitas.submit();
          }
          </script>

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
	  </center>{/block}