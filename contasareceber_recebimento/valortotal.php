<?php
require_once('../Connections/conn.php'); 
 
	function retorna( $id )
	{
		$id = (int)$id;
		$id_contasareceber = $_GET['id_contasareceber'];

 
 
		$sql = "SELECT sum(valortotal) as valortotal
			FROM `contasareceber` WHERE `id_contasareceber` = {$id_contasareceber} ";
		$query = mysql_query( $sql );
 
 
		$arr = Array();
		if( mysql_num_rows( $query ) )
		{
			while( $dados = mysql_fetch_object( $query ) )
			{
				$arr['valortotal'] = $dados->valortotal;
				
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
 