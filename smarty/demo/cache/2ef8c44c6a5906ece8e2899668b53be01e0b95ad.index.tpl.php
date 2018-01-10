<?php
/* Smarty version 3.1.30, created on 2018-01-03 20:37:08
  from "C:\wamp64\www\smarty\demo\templates\index.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_5a4d3ef42a1308_77342936',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '09a5ad1329230b983b6ed24bb9468abdbaa16ae5' => 
    array (
      0 => 'C:\\wamp64\\www\\smarty\\demo\\templates\\index.tpl',
      1 => 1514997963,
      2 => 'file',
    ),
    '8db5a76bd37a4df0101dc6c322baacf7c41cb37a' => 
    array (
      0 => 'C:\\wamp64\\www\\smarty\\demo\\templates\\basepage.tpl',
      1 => 1514994451,
      2 => 'file',
    ),
  ),
  'cache_lifetime' => 120,
),true)) {
function content_5a4d3ef42a1308_77342936 (Smarty_Internal_Template $_smarty_tpl) {
?>
<html> 
	<head>
	<meta http-equiv="Content-Type" content="text/html"; charset="utf-8">
	<title></title>
    <link rel="stylesheet" type="text/css" href="estilopag.css">
	</head>
	
<body>

 <header id="header"> 
		<center>
        <h1>GAMIFICAÇÃO</h1>
		</center>
		
    </header>
	<div id="wrapper">
        <nav id="nav"> 
		
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

        </nav>
		
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

    </div>
</body>
</html><?php }
}
