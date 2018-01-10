<?php
/* Smarty version 3.1.31, created on 2018-01-04 17:14:44
  from "/var/www/html/templates/pagAluno.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.31',
  'unifunc' => 'content_5a4e6104026b78_37418291',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '0375be7fb55d87ac18e9590ef016dd09e48b1f71' => 
    array (
      0 => '/var/www/html/templates/pagAluno.tpl',
      1 => 1515079440,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5a4e6104026b78_37418291 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_loadInheritance();
$_smarty_tpl->inheritance->init($_smarty_tpl, true);
?>



<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_6999982785a4e6104022684_08241635', "lateral");
?>

<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_6301410125a4e61040242a5_76602957', "mid");
$_smarty_tpl->inheritance->endChild($_smarty_tpl, 'basepage.tpl');
}
/* {block "lateral"} */
class Block_6999982785a4e6104022684_08241635 extends Smarty_Internal_Block
{
public $subBlocks = array (
  'lateral' => 
  array (
    0 => 'Block_6999982785a4e6104022684_08241635',
  ),
);
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>
             
<section>

				
				<form action="router.php" method="post" enctype="multipart/form-data">
				<input type="submit" value="Alterar Dados" name="submit"><br>
				<input type="submit" value="Enviar Certificados" name="submit"><br>
				<input type="submit" value="Trocar Perfil" name="submit"><br>
				</form>
				 <ul>
                    <li><a href='index.php'>Logout</a><br></li>
                </ul>
				
				
</section> 
<?php
}
}
/* {/block "lateral"} */
/* {block "mid"} */
class Block_6301410125a4e61040242a5_76602957 extends Smarty_Internal_Block
{
public $subBlocks = array (
  'mid' => 
  array (
    0 => 'Block_6301410125a4e61040242a5_76602957',
  ),
);
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>
 
<div id="cont">
			<div id="imgp">
				<div id="simgp">
					<table border>
					    <tr><td><img src="<?php echo $_smarty_tpl->tpl_vars['foto']->value;?>
" height="250" width="auto"></td></tr>
					</table>
				</div>
			</div>
			<div id="infp">
				<p class="cent"><h1><?php echo $_smarty_tpl->tpl_vars['nome']->value;?>
, Título do aluno</h1></p>
				<p ><h2>Classe, <?php echo $_smarty_tpl->tpl_vars['nivel']->value;?>
</h2></p>
			</div>
		</div>
        <div id="lin">
			<center>Sobre fulano</center>
		</div>
		<div id="cont3">
			<div id="gp">
				<div id="sgp">
                    <h2>Atributos<h2>
                    <table border>
                        <tr><td><img src="g_img.png" width="300px" height="auto"></td></tr>
                    </table>
				</div>
			</div>
			<div id="infg">
				<div id="sinfg">
                    <h2>Achievements<h2>
                    <table border>
                        <tr><td><img src="g_img.png" width="100px" height="100px"></td><td class="long"><p>Nome</p><p>Descrição da conquista</p></td></tr>
                        <tr><td><img src="g_img.png" width="100px" height="100px"></td><td class="long"><p>Nome</p><p>Descrição da conquista</p></td></tr>
                        <tr><td><img src="g_img.png" width="100px" height="100px"></td><td class="long"><p>Nome</p><p>Descrição da conquista</p></td></tr>
                        <tr><td><img src="g_img.png" width="100px" height="100px"></td><td class="long"><p>Nome</p><p>Descrição da conquista</p></td></tr>
                    </table>
				</div>
			</div>
		</div>

<?php
}
}
/* {/block "mid"} */
}
