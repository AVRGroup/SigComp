<?php
/* Smarty version 3.1.30, created on 2018-01-04 12:17:33
  from "C:\wamp64\www\Smarty\demo\templates\index.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_5a4e1b5d6c2704_66248620',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '544e2a243138710bb0b213ac0ce174a12b08b474' => 
    array (
      0 => 'C:\\wamp64\\www\\Smarty\\demo\\templates\\index.tpl',
      1 => 1514997963,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:basepage.tpl' => 1,
  ),
),false)) {
function content_5a4e1b5d6c2704_66248620 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_loadInheritance();
$_smarty_tpl->inheritance->init($_smarty_tpl, true);
$_smarty_tpl->compiled->nocache_hash = '298555a4e1b5d3abc51_82581724';
?>


<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_189245a4e1b5d693923_22976286', "lateral");
?>


<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_45335a4e1b5d6bbd66_74207033', "mid");
?>


<?php $_smarty_tpl->inheritance->endChild();
$_smarty_tpl->_subTemplateRender("file:basepage.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 9999, $_smarty_tpl->cache_lifetime, array(), 2, false);
}
/* {block "lateral"} */
class Block_189245a4e1b5d693923_22976286 extends Smarty_Internal_Block
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
class Block_45335a4e1b5d6bbd66_74207033 extends Smarty_Internal_Block
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
