<?php
/* Smarty version 3.1.30, created on 2018-01-04 13:11:35
  from "/var/www/html/smarty/demo/templates/index.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_5a4e2807ae1ed8_69621596',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'a7d74f6122e3437f953b409fca5e739504d3e242' => 
    array (
      0 => '/var/www/html/smarty/demo/templates/index.tpl',
      1 => 1515071557,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:basepage.tpl' => 1,
  ),
),false)) {
function content_5a4e2807ae1ed8_69621596 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_loadInheritance();
$_smarty_tpl->inheritance->init($_smarty_tpl, true);
$_smarty_tpl->compiled->nocache_hash = '1802880655a4e2807ace4a3_39858002';
?>


<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_11853411725a4e2807add113_60664951', "lateral");
?>


<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_12730294105a4e2807ae0ac8_38851399', "mid");
?>


<?php $_smarty_tpl->inheritance->endChild();
$_smarty_tpl->_subTemplateRender("file:basepage.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 9999, $_smarty_tpl->cache_lifetime, array(), 2, false);
}
/* {block "lateral"} */
class Block_11853411725a4e2807add113_60664951 extends Smarty_Internal_Block
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
class Block_12730294105a4e2807ae0ac8_38851399 extends Smarty_Internal_Block
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
