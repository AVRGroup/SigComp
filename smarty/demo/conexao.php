<?php
    $servername = "localhost";
    $username = "root";
    $password = "gamifica";
    $dbname = "bd_gamificacurso";

	$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
	$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
    function protecao($string){
		$string = str_replace(" or ", "", $string);
		$string = str_replace("select ", "", $string);
		$string = str_replace("delete ", "", $string);
		$string = str_replace("create ", "", $string);
		$string = str_replace("drop ", "", $string);
		$string = str_replace("update ", "", $string);
		$string = str_replace("drop table", "", $string);
		$string = str_replace("show table", "", $string);
		$string = str_replace("applet", "", $string);
		$string = str_replace("object", "", $string);
		$string = str_replace("'", "", $string);
		$string = str_replace("#", "", $string);
		$string = str_replace("=", "", $string);
		$string = str_replace("--", "", $string);
		$string = str_replace("-", "", $string);
		$string = str_replace(";", "", $string);
		$string = str_replace("*", "", $string);
		$string = strip_tags($string);
		return $string;
    }
?>
