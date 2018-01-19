<link rel="stylesheet" href="../funcoes/modal-message/modal-message.css" type="text/css">
<script type="text/javascript" src="../funcoes/modal-message/ajax.js"></script>
<script type="text/javascript" src="../funcoes/modal-message/modal-message.js"></script>
<script type="text/javascript" src="../funcoes/modal-message/ajax-dynamic-content.js"></script>

<script type="text/javascript">
messageObj = new DHTML_modalMessage();	// We only create one object of this class
messageObj.setShadowOffset(5);	// Large shadow


function displayMessage(url,xx,yy)
{
	messageObj.setSource(url);
	messageObj.setCssClassMessageBox(false);
	messageObj.setSize(xx,yy);
	messageObj.setShadowDivVisible(false);	// Enable shadow for these boxes
	messageObj.display();

}

function closeMessage()
{
	messageObj.close();	

}


</script>

﻿<?php 

include("../Connections/conn.php");
include("../funcoes/funcoes.php");
// busca os dados no banco de dados

if (isset($_POST['excel'])){
// definimos o tipo de arquivo
header("Content-type: application/msexcel");

// Como será gravado o arquivo
header("Content-Disposition: attachment; filename=relatorio_clientes.xls");
// busca os dados no banco de dados
}
include("../Connections/conn.php");
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
	
	$busca = mysql_query("SELECT * FROM clientes ORDER BY email ASC
	
	
	
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
<tr><td colspan="32"><img src="../imagens/logomarca-pnsf.png" alt="" width="210" height="100" align="left" />
  <p><strong>Pousada Nossa Senhora de Fátima</strong><br />

RUA CARLOS RIBEIRO, Nº 7, <br />
BAIRRO DE FÁTIMA | CEP 60.040-420 <br />
FORTALEZA | CEARÁ | BRASIL <br />
FONES: +55 (85) 3077.2727 | 99988-6869<br />
</td>
</tr>
<tr>
  <td height="34" colspan="32" align="center" bgcolor="#95B9E4"><strong>RELATÓRIO DE ANIVERSARIANTES</strong></td></tr>
<tr align="center">
  <td colspan="32"></td></tr>
  <tr bgcolor="#EAEAEB">
    <th width="2%"><strong>ID</strong></th>
     <th width="8%"><strong>NOME DO CLIENTE</strong></th>
    
    <th width="8%"><strong>DATA DE NASCIMENTO</strong></th>
  
    <th width="8%"><strong>TELEFONE</strong></th>
    <th width="3%"><strong>EMAIL</strong></th>
   

    <th width="8%"><strong>ALTERAR</strong></th>
    <th width="3%"><strong>EXCLUIR</strong></th>
   
 
   
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
  
    <td><?php echo $resultado['datanascimento'];?></td>
   
    <td><?php echo $resultado['fone1']; ?></td>
    <td><?php echo $resultado['email'];?></td>
  
   
    <td><?php if ($alterarclientes == "1"){?>
                <a href="#&quot;"  onclick="displayMessage('../clientes/alterar.php?id=<?php echo $resultado['id']; ?>','990','650');return false"><img src="../imagens/alterar.png" width="20" height="20" alt="alt" /></a>
                <?php  } else {  ?>
              <?php } ?></td>
              <td><?php if ($excluirclientes == "1"){?>
                <a href="#"  onclick="displayMessage('../clientes/excluir.php?id=<?php echo $resultado['id']; ?>','500','450');return false"><img src="../imagens/del.png" width="20" height="20" alt="exc" /></a>
                <?php  } else {  ?>
              <?php } ?></td>
            
  
  </tr>
  
  
<?php }  ?>
  <tr align="center" bgcolor="#A7A7A7">
 
  </tr>
</table>

	
	