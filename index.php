<?php
/**
 * Example Application
 *
 * @package Example-application
 */

require 'guestbook/setup.php';

/*include ('/usr/local/lib/php/Smarty/Smarty.class.php') or die('e morreu');*/
//require '/usr/local/lib/smarty-3.1.30/libs/Smart.class.php';

try{
	$smarty = new Smarty;
}catch(Exception $erro){
	echo $erro->getMessage();
}

//$smarty->testInstall();


//$smarty->force_compile = true;

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
?>
