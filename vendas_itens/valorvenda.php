﻿<?php
require_once('../Connections/conn.php'); 
 
	function retorna( $id )
	{
		$id = (int)$id;
 
		$sql = "SELECT `id`, `nome`, `precovenda`
			FROM `produtos` WHERE `id` = {$id} ";
		$query = mysql_query( $sql );
 
 
		$arr = Array();
		if( mysql_num_rows( $query ) )
		{
			while( $dados = mysql_fetch_object( $query ) )
			{
				$arr['precovenda'] = $dados->precovenda;
				
			}
		}
		else
			$arr[] = 'endereco: não encontrado';
 
		return json_encode( $arr );
	}
 
/* só se for enviado o parâmetro, que devolve o combo */
if( isset($_GET['id']) )
{
	echo retorna( $_GET['id'] );
}
 

?>