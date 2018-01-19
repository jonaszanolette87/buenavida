<?php
require_once('../Connections/conn.php'); 
 
	function retorna( $id )
	{
		$id = (int)$id;
		$id_contasapagar = $_GET['id_contasapagar'];

 
 
		$sql = "SELECT sum(valortotal) as valortotal
			FROM `contasapagar_pagamento` WHERE `id_contasapagar` = {$id_contasapagar} ";
		$query = mysql_query( $sql );
		
		$sql2 = "SELECT valor 
			FROM `contasapagar` WHERE `id` = {$id_contasapagar} ";
		$query2 = mysql_query( $sql2 );
		$dados2 = mysql_fetch_object( $query2 );
 
		$arr = Array();
		if( mysql_num_rows( $query ) )
		{
			while( $dados = mysql_fetch_object( $query ) )
			{
				$arr['valortotal'] = $dados2->valor - $dados->valortotal;
				
			}
		}
		else
			$arr[] = 'valortotal: não encontrado';
			
		
		
		
		return json_encode( $arr );
	}
 
/* só se for enviado o parâmetro, que devolve o combo */
if( isset($_GET['id']) )
{
	echo retorna( $_GET['id'] );
}
 