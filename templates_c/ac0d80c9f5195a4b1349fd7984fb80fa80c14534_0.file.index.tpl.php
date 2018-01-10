<?php
/* Smarty version 3.1.31, created on 2018-01-04 13:19:57
  from "/var/www/html/templates/index.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.31',
  'unifunc' => 'content_5a4e29fd08e527_01149382',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'ac0d80c9f5195a4b1349fd7984fb80fa80c14534' => 
    array (
      0 => '/var/www/html/templates/index.tpl',
      1 => 1514997963,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5a4e29fd08e527_01149382 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_loadInheritance();
$_smarty_tpl->inheritance->init($_smarty_tpl, true);
?>


<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_2027049025a4e29fd08b6a6_09906697', "lateral");
?>


<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_4931910565a4e29fd08d542_26909863', "mid");
?>


<?php $_smarty_tpl->inheritance->endChild($_smarty_tpl, 'basepage.tpl');
}
/* {block "lateral"} */
class Block_2027049025a4e29fd08b6a6_09906697 extends Smarty_Internal_Block
{
public $subBlocks = array (
  'lateral' => 
  array (
    0 => 'Block_2027049025a4e29fd08b6a6_09906697',
  ),
);
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
class Block_4931910565a4e29fd08d542_26909863 extends Smarty_Internal_Block
{
public $subBlocks = array (
  'mid' => 
  array (
    0 => 'Block_4931910565a4e29fd08d542_26909863',
  ),
);
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
