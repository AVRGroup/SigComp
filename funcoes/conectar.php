<?php

   $vServidor = "localhost";
   $vUsuario = "warcraft";
   $vSenha = "wow";

   $vConexao = mysql_connect($vServidor,$vUsuario,$vSenha);
   if ($vConexao)
   {

	}
   else
   {
   	echo "Problema ao conectar com o Servidor de Banco de Dados, favor entrar em contato com o Suporte!";
	}
   if (mysql_select_db("db_warcraft"))
   {

	}
   else
   {
   	echo "Problema ao abrir a conex�o com o Banco de Dados, favor entrar em contato com o Suporte!";
	}
?>