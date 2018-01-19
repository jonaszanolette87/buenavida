<?php
require_once('../Connections/conn.php'); 
 
	function retorna( $id )
	{
		$id = (int)$id;
		

 
 
		$sql = "SELECT sum(valortotal) as valortotal
		FROM `compras_itens_materiasprimas` WHERE `id_compra` = {$id} ";
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
			$arr[] = 'valortotal: não sencontrado';
			
		
		
		
		return json_encode( $arr );
	}
 
/* só se for enviado o parâmetro, que devolve o combo */
if( isset($_GET['id']) )
{
	echo retorna( $_GET['id'] );
}
 