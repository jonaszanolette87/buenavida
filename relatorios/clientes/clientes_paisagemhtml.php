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
	
	$data_inicial = $_POST['data_inicial'];
	$data_final = $_POST['data_final'];
	
	echo  "data inicial: ".$data_inicial ;
	echo  "data final: ".$data_final;
	
	
	
	$busca = mysql_query("SELECT * FROM clientes ORDER BY nome ASC");

}

else if (isset($_POST['status']) && $_POST['status'] !=''){
	
	
	$status = $_POST['status'];
	
		
	
	$busca = mysql_query("SELECT * FROM clientes ORDER BY nome ASC ");
	
	}
	
	else if (isset($_POST['data_inicial']) && $_POST['data_inicial'] !='' && isset($_POST['data_final']) && $_POST['data_final'] !='' ){
	
	
	
	$data_inicial = datausa($_POST['data_inicial']);
	$data_final = datausa($_POST['data_final']);
	
	
	
	$busca = mysql_query("SELECT * FROM clientes ORDER BY nome ASC
	");

}
else 
{
	
	//$data_inicial = datausa($_POST['data_inicial']);
	//$data_final = datausa($_POST['data_final']);
	
	$busca = mysql_query("SELECT * FROM clientes ORDER BY nome ASC
	
	
	
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
<tr><td colspan="32"><img src="../../imagens/logomarca-pnsf.png" alt="" width="400" height="150" align="left" />
  <p>RUA ALMIRANTE TAMANDARE, Nº 1273, <br />
    BAIRRO DE CENTRO | CEP 97.573-000 <br />
    SANTANA DO LIVRAMENTO | RS | BRASIL <br />
    FONE: +55 (55) 3242 - 1006 </p></td>
</tr>
<tr>
  <td height="34" colspan="32" align="center" bgcolor="#95B9E4"><strong>RELATÓRIO DE CLIENTES</strong></td></tr>
<tr align="center">
  <td colspan="32"><strong><br>
</strong><strong>FORNECEDOR</strong>:
     <?php if ($_POST['fornecedor'] == "" ){echo "TODOS";} else echo $_POST['fornecedor'];  ?>
     <br>
   <br>   
   <br></td></tr>
  <tr bgcolor="#EAEAEB">
    <th width="2%"><strong>ID</strong></th>
     <th width="8%"><strong>NOME DO CLIENTE</strong></th>
    
    <th width="8%"><strong>ENDEREÇO</strong></th>
  
    <th width="8%"><strong>TELEFONE</strong></th>
    <th width="3%"><strong>EMAIL</strong></th>
   

   
   
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
    <td><?php echo $resultado['nome'];?></td>
  
    <td><?php echo $resultado['endereco'];?></td>
   
    <td><?php echo $resultado['fone1']; ?></td>
    <td><?php echo $resultado['email'];?></td>
  
   
   
  
  </tr>
  
  
<?php }  ?>
  <tr align="center" bgcolor="#A7A7A7">
 
  </tr>
</table>

	
	