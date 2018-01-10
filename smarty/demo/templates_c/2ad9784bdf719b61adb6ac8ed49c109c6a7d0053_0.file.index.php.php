<?php
/* Smarty version 3.1.30, created on 2018-01-03 18:20:58
  from "C:\wamp64\www\smarty\demo\index.php" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_5a4d1f0a06ffa5_95772031',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '2ad9784bdf719b61adb6ac8ed49c109c6a7d0053' => 
    array (
      0 => 'C:\\wamp64\\www\\smarty\\demo\\index.php',
      1 => 1515000068,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5a4d1f0a06ffa5_95772031 (Smarty_Internal_Template $_smarty_tpl) {
echo '<?php
';?>/**
 * Example Application
 *
 * @package Example-application
 */

require 'guestbook/setup.php';

$smarty = new Smarty;

//$smarty->force_compile = true;
$smarty->debugging = false;
$smarty->caching = true;
$smarty->cache_lifetime = 120;



 /* $smarty->assign ("var",$ree);


$smarty->assign("Name", "Fred Irving Johnathan Bradley Peppergill", true);
$smarty->assign("FirstName", array("John", "Mary", "James", "Henry"));
$smarty->assign("LastName", array("Doe", "Smith", "Johnson", "Case"));
$smarty->assign("Class", array(array("A", "B", "C", "D"), array("E", "F", "G", "H"), array("I", "J", "K", "L"),
                               array("M", "N", "O", "P")));

$smarty->assign("contacts", array(array("phone" => "1", "fax" => "2", "cell" => "3"),
                                  array("phone" => "555-4444", "fax" => "555-3333", "cell" => "760-1234")));

$smarty->assign("option_values", array("NY", "NE", "KS", "IA", "OK", "TX"));
$smarty->assign("option_output", array("New York", "Nebraska", "Kansas", "Iowa", "Oklahoma", "Texas"));
$smarty->assign("option_selected", "NE");
*/ 
$smarty->display('index.tpl');

<?php }
}
