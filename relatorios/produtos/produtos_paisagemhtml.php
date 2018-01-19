<?php 

include("../../Connections/conn.php");
include("../../funcoes/funcoes.php");
// busca os dados no banco de dados

if (isset($_POST['excel'])){
// definimos o tipo de arquivo
header("Content-type: application/msexcel");

// Como será gravado o arquivo
header("Content-Disposition: attachment; filename=relatorio_clientes.xls");
// busca os dados no banco de dados
}
include("../../Connections/conn.php");
// busca os dados no banco de dados
mysql_select_db($database_conn, $conn);






if (isset($_POST['status']) && $_POST['status'] !='' && isset($_POST['data_inicial']) && $_POST['data_inicial'] !='' && isset($_POST['data_final']) && $_POST['data_final'] !='' && isset($_POST['fornecedor']) && $_POST['fornecedor'] !='' && isset($_POST['apt']) && $_POST['apt'] !=''  ){
	
	$status = $_POST['status'];
	$fornecedor = $_POST['fornecedor'];
	$apt = $_POST['apt'];
	
	$data_inicial = $_POST['data_inicial'];
	$data_final = $_POST['data_final'];
	
	echo  "data inicial: ".$data_inicial ;
	echo  "data final: ".$data_final;
	
	
	
	$busca = mysql_query("SELECT r.*, q.nome as apt, f.nome as fornecedor, f.comissao as comissao, c.nome as cliente FROM reservas r
	
	
	LEFT JOIN 	quartos q
	ON r.id_quarto = q.id
	
		LEFT JOIN 	fornecedores f
	ON r.id_fornecedor = f.id
	
	LEFT JOIN 	clientes c
	ON r.id_cliente = c.id
	
	
	
	WHERE status='$status' AND id_fornecedor='$fornecedor' AND id_quarto='$apt'  AND chegada  BETWEEN '$data_inicial' AND '$data_final' ORDER BY chegada ASC
	");

}


else if (isset($_POST['status']) && $_POST['status'] !='' && isset($_POST['data_inicial']) && $_POST['data_inicial'] !='' && isset($_POST['data_final']) && $_POST['data_final'] !='' && isset($_POST['fornecedor']) && $_POST['fornecedor'] !='' ){
	
	$status = $_POST['status'];
	$fornecedor = $_POST['fornecedor'];
	
	
	$data_inicial = $_POST['data_inicial'];
	$data_final = $_POST['data_final'];
	
	
			
	
	$busca = mysql_query("SELECT r.*, q.nome as apt, f.nome as fornecedor, f.comissao as comissao, c.nome as cliente FROM reservas r
	LEFT JOIN 	quartos q
	ON r.id_quarto = q.id
	
		LEFT JOIN 	fornecedores f
	ON r.id_fornecedor = f.id
	
	
	LEFT JOIN 	clientes c
	ON r.id_cliente = c.id
	
	WHERE status='$status' AND id_fornecedor='$fornecedor'   AND chegada  BETWEEN '$data_inicial' AND '$data_final' ORDER BY chegada ASC ");
	
	}





else if (isset($_POST['status']) && $_POST['status'] !=''){
	
	
	$status = $_POST['status'];
	
		
	
	$busca = mysql_query("SELECT r.*, q.nome as apt, f.nome as fornecedor, f.comissao as comissao, c.nome as cliente FROM reservas r
	LEFT JOIN 	quartos q
	ON r.id_quarto = q.id
	
		LEFT JOIN 	fornecedores f
	ON r.id_fornecedor = f.id
	
	
	LEFT JOIN 	clientes c
	ON r.id_cliente = c.id
	
	WHERE status='$status' ");
	
	}
	
	else if (isset($_POST['data_inicial']) && $_POST['data_inicial'] !='' && isset($_POST['data_final']) && $_POST['data_final'] !='' ){
	
	
	
	$data_inicial = datausa($_POST['data_inicial']);
	$data_final = datausa($_POST['data_final']);
	
	
	
	$busca = mysql_query("SELECT r.*, q.nome as apt, f.nome as fornecedor, f.comissao as comissao, c.nome as cliente FROM reservas r 
	LEFT JOIN 	quartos q
	ON r.id_quarto = q.id
	
	
		LEFT JOIN 	fornecedores f
	ON r.id_fornecedor = f.id
	
	LEFT JOIN 	clientes c
	ON r.id_cliente = c.id
	
	
	WHERE  chegada  BETWEEN '$data_inicial' AND '$data_final'
	");

}
else 
{
	
	//$data_inicial = datausa($_POST['data_inicial']);
	//$data_final = datausa($_POST['data_final']);
	
	$busca = mysql_query("SELECT r.*, q.nome as apt, f.nome as fornecedor, f.comissao as comissao, c.nome as cliente FROM reservas r 
	LEFT JOIN 	quartos q
	ON r.id_quarto = q.id
	
	
		LEFT JOIN 	fornecedores f
	ON r.id_fornecedor = f.id
	
	
	LEFT JOIN 	clientes c
	ON r.id_cliente = c.id
	
	
	
	");

	}
?>
<style type="text/css">
body {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 7pt;
}
body p {
	font-size: 12pt;
}
td {
	font-size: 9pt;
}
tr {
	font-size: 9px;
}
</style>

<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<table width="100%" border="1" cellpadding="1" cellspacing="1" style="border-collapse: collapse" >
<tr><td colspan="32">
  
  <img src="http://pousadaviannas.com.br/imagens/logo-viannas.png" width="100" height="100" align=left />
  <p><strong>POUSADA VIANNAS</strong><br />
Rua Ministro Joaquim Bastos, 484, Bairro de Fátima
Fortaleza - Ceará
CEP: 60415-040 Tel. +55 (85) 3272-5273</p></td>
</tr>
<tr>
  <td height="34" colspan="32" align="center" bgcolor="#95B9E4"><strong>RELATÓRIO DE PRODUTOS</strong></td></tr>
<tr align="center">
  <td colspan="32"><strong><br>
  </strong><br>   
   <br></td></tr>
  <tr bgcolor="#EAEAEB">
    <th width="2%"><strong>ID</strong></th>
     <th width="8%"><strong>PRODUTO</strong></th>
    
    <th width="8%"><strong>QTD</strong></th>
  
    <th width="8%">&nbsp;</th>
    <th width="3%">&nbsp;</th>
    <th width="3%">&nbsp;</th>
    <th width="6%">&nbsp;</th>
    <th width="6%">&nbsp;</th>
    <th width="6%">&nbsp;</th>
    <th width="6%">&nbsp;</th>

    <th width="8%">&nbsp;</th>
    <th width="8%">&nbsp;</th>
    
    <th width="8%">&nbsp;</th>
    <th width="8%">&nbsp;</th>

   
   
  </tr>
  
  <?php 
  $contador =0;
  $totalnoites = 0;
   $totalqtd_pass = 0;
    $totalcomissao = 0;
	 $totalvalor_retido = 0;
	  $totalcobro_adiantamento = 0;
   
  while ($resultado = mysql_fetch_array($busca)){
  ?>
  
  <tr align="center">
    <td><?php echo $resultado['id'];?></td>
    <td><?php echo $resultado['fornecedor'];?></td>
  
    <td><?php echo $resultado['id_reserva'];?></td>
   
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
   
    <td>&nbsp;</td>
    <td>&nbsp;</td>

    <td>&nbsp;</td>
    <td>&nbsp;</td>
   
   
   <?php $totalnoites = $totalnoites +  $resultado['n_noites'];?>
   <?php $totalvalor_reserva = $totalvalor_reserva +  $resultado['valor_reserva'];?>
   <?php $totalvalor_realocacao= $totalvalor_realocacao +  $resultado['valor_realocacao'];?>
  
  
  
   <?php $totalqtd_pass = $totalqtd_pass +  $resultado['qtd_pass'];?>
   <?php $totalcomissao = $totalcomissao +  $resultado['comissao'];?>
   <?php $totalvalor_retido = $totalvalor_retido +  $resultado['valor_retido'];?>
   <?php $contador = $contador +  1;?>
   
   <?php $totalcobro_adiantamentoT= $totalcobro_adiantamentoT +  $resultado['cobro_adiantamento'];?>
   <?php $totalcobro_adiantamento= $totalcobro_adiantamentoT/$contador ;?>
  </tr>
  
  
<?php }  ?>
  <tr align="center" bgcolor="#A7A7A7">
  <td colspan="8"><strong>TOTAIS</strong></td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>

  
  <td>&nbsp;</td>
  <td>&nbsp;</td>

  <td>&nbsp;</td>
  <td>&nbsp;</td>
  </tr>
</table>

	
	