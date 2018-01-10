<?php
/* Smarty version 3.1.30, created on 2018-01-03 19:02:51
  from "C:\wamp64\www\smarty\demo\templates\pagAluno.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_5a4d28dba01bd6_37810554',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '5856bde9ec0d62b1d391d3ebdfeec031f754fd8e' => 
    array (
      0 => 'C:\\wamp64\\www\\smarty\\demo\\templates\\pagAluno.tpl',
      1 => 1515006167,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:basepage.tpl' => 1,
  ),
),false)) {
function content_5a4d28dba01bd6_37810554 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_loadInheritance();
$_smarty_tpl->inheritance->init($_smarty_tpl, true);
?>



<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_94105a4d28db9f2a67_10332069', "lateral");
?>

<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_293955a4d28db9ffa74_08201251', "mid");
$_smarty_tpl->inheritance->endChild();
$_smarty_tpl->_subTemplateRender("file:basepage.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 2, false);
}
/* {block "lateral"} */
class Block_94105a4d28db9f2a67_10332069 extends Smarty_Internal_Block
{
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
class Block_293955a4d28db9ffa74_08201251 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>
 
<div id="cont">
			<div id="imgp">
				<div id="simgp">
					<table border>
					    <tr><td><img src="uploads/<?php echo $_smarty_tpl->tpl_vars['matricula']->value;?>
/perfil" height="250" width="auto"></td></tr>
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
