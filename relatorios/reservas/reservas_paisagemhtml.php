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






if (isset($_POST['status']) && $_POST['status'] !='' && isset($_POST['data_inicial']) && $_POST['data_inicial'] !='' && isset($_POST['data_final']) && $_POST['data_final'] !='' && isset($_POST['id_fornecedor']) && $_POST['id_fornecedor'] !='' && isset($_POST['apt']) && $_POST['apt'] !=''  ){
	
	$status = $_POST['status'];
	$id_fornecedor = $_POST['id_fornecedor'];
	$apt = $_POST['apt'];
	
	$data_inicial = $_POST['data_inicial'];
	$data_final = $_POST['data_final'];
	
	echo  "data inicial: ".$data_inicial ;
	echo  "data final: ".$data_final;
	
	
	
	$busca = mysql_query("SELECT r.*, q.nome as apt, f.nome as fornecedor, f.comissao as comissao, c.nome as cliente 
	
	FROM reservas r
	
	
	LEFT JOIN 	quartos q
	ON r.id_quarto = q.id
	
    LEFT JOIN 	fornecedores f
	ON r.id_fornecedor = f.id
	
	LEFT JOIN 	clientes c
	ON r.id_cliente = c.id
	
	
	
	WHERE status='$status' AND id_fornecedor='$id_fornecedor' AND id_quarto='$apt'  AND chegada  
	
	BETWEEN '$data_inicial' AND '$data_final' ORDER BY chegada ASC
	");

}


else if (isset($_POST['status']) && $_POST['status'] !='' && isset($_POST['data_inicial']) && $_POST['data_inicial'] !='' && isset($_POST['data_final']) && $_POST['data_final'] !='' && isset($_POST['id_fornecedor']) && $_POST['id_fornecedor'] !='' ){
	
	$status = $_POST['status'];
	$id_fornecedor = $_POST['id_fornecedor'];
	
	
	$data_inicial = $_POST['data_inicial'];
	$data_final = $_POST['data_final'];
	
	
			
	
	$busca = mysql_query("SELECT r.*, q.nome as apt, f.nome as fornecedor, f.comissao as comissao, c.nome as cliente 
	
	FROM reservas r
	
	
	LEFT JOIN 	quartos q
	ON r.id_quarto = q.id
	
	LEFT JOIN 	fornecedores f
	ON r.id_fornecedor = f.id
	
	
	LEFT JOIN 	clientes c
	ON r.id_cliente = c.id
	
	WHERE status='$status' AND r.id_fornecedor='$id_fornecedor'   AND chegada  BETWEEN '$data_inicial' AND '$data_final' ORDER BY chegada ASC ");
	
	}


else if (isset($_POST['status']) && $_POST['status'] !='' && isset($_POST['data_inicial']) && $_POST['data_inicial'] !='' && isset($_POST['data_final']) && $_POST['data_final'] !=''  ){
	
	$status = $_POST['status'];

	
	
	$data_inicial = $_POST['data_inicial'];
	$data_final = $_POST['data_final'];
	
	
			
	
	$busca = mysql_query("SELECT r.*, q.nome as apt, f.nome as fornecedor, f.comissao as comissao, c.nome as cliente FROM reservas r
	LEFT JOIN 	quartos q
	ON r.id_quarto = q.id
	
		LEFT JOIN 	fornecedores f
	ON r.id_fornecedor = f.id
	
	
	LEFT JOIN 	clientes c
	ON r.id_cliente = c.id
	
	WHERE status='$status'  AND chegada  BETWEEN '$data_inicial' AND '$data_final' ORDER BY chegada ASC ");
	
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
	
	
	WHERE  r.chegada  BETWEEN '$data_inicial' AND '$data_final'
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
  
  <img src="../../imagens/logomarca-pnsf.png" width="400" height="150" align=left />
  <p>RUA ALMIRANTE TAMANDARE, Nº 1273, <br />
    BAIRRO DE CENTRO | CEP 97.573-000 <br />
    SANTANA DO LIVRAMENTO | RS | BRASIL <br />
    FONE: +55 (55) 3242 - 1006 </p></td>
</tr>
<tr>
  <td height="34" colspan="32" align="center" bgcolor="#95B9E4"><strong>RELATÓRIO DE RESERVA</strong></td></tr>
<tr align="center">
  <td colspan="32"><strong><br>
    DATA INICIAL</strong>:
  
  <?php  echo substr($_POST['data_inicial'],8,2)."/".substr($_POST['data_inicial'],5,2)."/".substr($_POST['data_inicial'],0,4);?>
  a 
    <strong>DATA FINAL</strong>:
	<?php  echo substr($_POST['data_final'],8,2)."/".substr($_POST['data_final'],5,2)."/".substr($_POST['data_final'],0,4);?>
	 
     <strong>STATUS</strong>:	  <?php if ($_POST['status'] == "") {    echo "TODOS";} else echo $_POST['status']; ?>
     <strong> FORNECEDOR</strong>:
     <?php if ($_POST['id_fornecedor'] == "" ){echo "TODOS";} else echo $_POST['id_fornecedor'];  ?>
     <strong> APT</strong>:		  
     <?php if ($_POST['apt'] == "") {       echo "TODOS";} else echo $_POST['apt']; ?>
     
     <br>
   <br>   
   <br></td></tr>
  <tr bgcolor="#EAEAEB">
    <th width="2%"><strong>ID</strong></th>
     <th width="8%"><strong>FORNECEDOR</strong></th>
    
    <th width="8%"><strong>ID RESERVA</strong></th>
  
    <th width="8%"><strong>DATA RESERVA</strong></th>
    <th width="3%"><strong>NOME HOSPEDE </strong></th>
    <th width="3%">APT</th>
    <th width="6%"><strong>DATA DA CHEGADA</strong></th>
    <th width="6%"><strong>DATA DA SAIDA </strong></th>
    <th width="6%"><strong>N DE NOITES </strong></th>
    <th width="6%"><strong>QTD DE PAX</strong></th>

    <th width="8%"><strong>VALOR RETIDO</strong></th>
    <th width="8%">VALOR DE RESERVA</th>
    
    <th width="8%"><strong>COMISSÃO</strong></th>
    <th width="8%"><strong>COBRO ADIANTAMENTO</strong></th>

   
   
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
   
    <td><?php echo $resultado['data_reserva']; ?></td>
    <td><?php if(isset($resultado['cliente'])){ echo $resultado['cliente']; } else { echo $resultado['hospede'];}?></td>
    <td><?php echo $resultado['apt'];?></td>
    <td><?php  echo substr($resultado['chegada'],8,2)."/".substr($resultado['chegada'],5,2)."/".substr($resultado['chegada'],0,4);?></td>
    <td><?php echo substr($resultado['saida'],8,2)."/".substr($resultado['saida'],5,2)."/".substr($resultado['saida'],0,4);?></td>
    <td><?php echo $resultado['n_noites'];?></td>
    <td><?php echo $resultado['qtd_pass'];?></td>
   
    <td>R$ <?php echo number_format($resultado['valor_retido'], 2, ',', '.');?></td>
    <td>R$ <?php echo number_format($resultado['valor_reserva'], 2, ',', '.');?></td>

    <td>R$ <?php $comissao = ($resultado['valor_reserva']* $resultado['comissao'])/100; echo $comissao;
	
?></td>
    <td><?php //echo ($resultado['valor_retido']/$resultado['valor_reserva']);?>%</td>
   
   
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
  <td><?php echo $totalnoites; ?></td>
  <td><?php echo $totalqtd_pass; ?></td>

  
  <td>R$ <?php echo number_format($totalvalor_retido, 2, ',', '.'); ?></td>
  <td>R$ <?php echo number_format($totalvalor_reserva, 2, ',', '.');?></td>

  <td>R$ <?php echo number_format($totalcomissao, 2, ',', '.'); ?></td>
  <td>Media <?php echo ceil($totalcobro_adiantamento); ?>%</td>
  </tr>
</table>

	
	