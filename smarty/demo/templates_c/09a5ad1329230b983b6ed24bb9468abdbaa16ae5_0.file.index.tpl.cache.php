<?php
/* Smarty version 3.1.30, created on 2018-01-03 16:46:14
  from "C:\wamp64\www\smarty\demo\templates\index.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_5a4d08d6376875_36228087',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '09a5ad1329230b983b6ed24bb9468abdbaa16ae5' => 
    array (
      0 => 'C:\\wamp64\\www\\smarty\\demo\\templates\\index.tpl',
      1 => 1514997963,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:basepage.tpl' => 1,
  ),
),false)) {
function content_5a4d08d6376875_36228087 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_loadInheritance();
$_smarty_tpl->inheritance->init($_smarty_tpl, true);
$_smarty_tpl->compiled->nocache_hash = '227275a4d08d633da20_42100399';
?>


<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_79245a4d08d636ee27_50716381', "lateral");
?>


<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_138535a4d08d6374736_81147900', "mid");
?>


<?php $_smarty_tpl->inheritance->endChild();
$_smarty_tpl->_subTemplateRender("file:basepage.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 9999, $_smarty_tpl->cache_lifetime, array(), 2, false);
}
/* {block "lateral"} */
class Block_79245a4d08d636ee27_50716381 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

            <section>
                    <center>
                    <br><br><br><br>
                    <form action='autentica.php' method='POST'>
                    Matrícula: <input name='matricula' type='text' size='17'><br>
                    Senha: &nbsp;&nbsp; &nbsp;<input name='senha' type='password' size='17'><br>
                    <input type='submit' value='Enviar'>
                    </form>
                    </center>
                    &nbsp
            </section>
<?php
}
}
/* {/block "lateral"} */
/* {block "mid"} */
class Block_138535a4d08d6374736_81147900 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

        <div id="cont">
            <center>
            <h2>Novidades<h2>
                <table border width="80%" >
                <tr><td colspan=2><p><center>Sample text Sample text Sample text Sample text</center></p></td></tr>
                <tr><td colspan=2><p><center>Sample text Sample text Sample text Sample text</center></p></td></tr>
                <tr><td colspan=2><p><center>Sample text Sample text Sample text Sample text</center></p></td></tr>
                <tr><td colspan=2><p><center>Sample text Sample text Sample text Sample text</center></p></td></tr>
                </table>
            </center>
        </div>
<?php
}
}
/* {/block "mid"} */
}
