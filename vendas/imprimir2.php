<?php 

include("../Connections/conn.php");
include("../funcoes/funcoes.php");
// busca os dados no banco de dados




mysql_select_db($database_conn, $conn);
$query_seleciona_vendas = "SELECT v.*,v.nomecliente as cliente, c.nome as nomecliente, c.endereco as endereco, c.bairro as bairro , c.Cep as cep , ci.Cidade as cidade, e .Estado as estado, c.fone1 as telefone, c.cnpj as cnpj, u.login as atendente, vf.descontototal as descontototal, v.pontodereferencia as pontodereferencia

FROM vendas v 



LEFT JOIN reservas r
ON v.id_cliente = r.id

INNER JOIN clientes c 
ON r.id_cliente = c.id


LEFT JOIN cidades ci
ON c.ID_Cidade = ci.ID


LEFT JOIN usuarios u
ON v.id_atendente = u.id

LEFT JOIN estados e
ON c.ID_Estado = e.ID

LEFT JOIN vendas_fechamento vf
ON vf.id_venda= v.id



WHERE v.id =   ".$_GET['id'];

$seleciona_vendas = mysql_query($query_seleciona_vendas, $conn) or die(mysql_error());
$row_seleciona_vendas = mysql_fetch_assoc($seleciona_vendas);



mysql_select_db($database_conn, $conn);
$query_seleciona_vendas_itens = "SELECT vi.*,p.nome as produto FROM vendas_itens vi


LEFT JOIN produtos p
ON vi.id_produto = p.id


WHERE id_venda = ".$_GET['id'];
$seleciona_vendas_itens = mysql_query($query_seleciona_vendas_itens, $conn) or die(mysql_error());

$qtd_linhas_servicos =  mysql_num_rows($seleciona_vendas_itens);

$row_seleciona_vendas_itens = mysql_fetch_assoc($seleciona_vendas_itens);



	

?>
<style type="text/css">
#tudo #topo1 {
	border-bottom-width: thin;
	border-bottom-color: #000;
}
#tudo #topo3 {
	clear: both;
	background-color: #D6D6D6;
	text-align: center;
	padding: 5px;
	border-top-width: thin;
	border-right-width: thin;
	border-bottom-width: thin;
	border-left-width: thin;
	border-top-color: #000;
	border-right-color: #000;
	border-bottom-color: #000;
	border-left-color: #000;
}

#tudo #topo1 #campo_N{
	float: left;
	padding: 5px;
}
#tudo #topo2 #campo_anoprestacao{
	float: left;
	border-right-width: thin;
	border-right-style: solid;
	border-right-color: #000;
	border-bottom-width: thin;
	border-bottom-style: solid;
	border-bottom-color: #000;
	border-top-width: thin;
	border-top-style: solid;
	border-top-color: #000;
	padding: 5px;
	width: 150px;
}
#tudo #topo3 #campo{
	float: left;
	border-right-width: thin;
	border-right-style: solid;
	border-right-color: #000;
	border-bottom-width: thin;
	border-bottom-style: solid;
	border-bottom-color: #000;
	border-top-width: thin;
	border-left-width: thin;
	border-top-style: solid;
	border-left-style: solid;
	border-top-color: #000;
	border-left-color: #000;
	padding: 5px;
}
body {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 14px;
}
#tudo #topo2 #campo_natureza {
	padding: 5px;
	float: left;
	width: 273px;
	border-top-width: thin;
	border-right-width: thin;
	border-bottom-width: thin;
	border-left-width: thin;
	border-top-style: solid;
	border-bottom-style: solid;
	border-top-color: #000;
	border-right-color: #000;
	border-bottom-color: #000;
	border-left-color: #000;
}
#topo1 #both {
	clear: both;
}
#tudo {
	margin: auto;
	position: relative;
	width: 840px;
	height: auto;
}
#tudo #topo1 #campo_N {
	float: left;
	padding-top: 10px;
	padding-right: 10px;
	padding-left: 70px;
}
#tudo #topo1 #campo_cabecalho {
	float: left;
	padding-top: 10px;
	padding-right: 10px;
	padding-left: 10px;
	font-size: 14px;
}
#tudo #topo1 #campo_logo {
	float: left;
}
#tudo #topo2 {
	clear: both;
}

#tudo #topo #campo_tomador {
	clear: both;
	padding: 5px;
	background-color: #CCC;
	height: 12px;
	width: 796px;
	text-align: center;
	color: #000;
	border: thin solid #000;
}
#tudo #topo #campo_razaosocial {
	padding: 5px;
	clear: both;
	border-top-width: thin;
	border-right-width: thin;
	border-bottom-width: thin;
	border-left-width: thin;
	border-top-style: solid;
	border-top-color: #000;
	border-right-color: #000;
	border-bottom-color: #000;
	border-left-color: #000;
}
#tudo #topo #campo_endereco {
	width: 593px;
	float: left;
	padding: 5px;
}
#tudo #topo #campo_cep {
	float: left;
	padding: 5px;
	width: 222px;
}
#tudo #topo #campo_cnpj {
	padding: 5px;
	float: left;
	border-top-width: thin;
	border-right-width: thin;
	border-bottom-width: thin;
	border-left-width: thin;
	border-top-style: solid;
	border-right-style: solid;
	border-top-color: #000;
	border-right-color: #000;
	border-bottom-color: #000;
	border-left-color: #000;
	width: 200px;
}
#tudo #topo #campo_cgf {
	padding: 5px;
	float: left;
	width: 200px;
	border-top-width: thin;
	border-right-width: thin;
	border-bottom-width: thin;
	border-left-width: thin;
	border-top-style: solid;
	border-right-style: solid;
	border-top-color: #000;
	border-right-color: #000;
	border-bottom-color: #000;
	border-left-color: #000;
}
#tudo #topo #campo_cpbs {
	padding: 5px;
	float: left;
	width: 406px;
	height: 32px;
	border-top-width: thin;
	border-right-width: thin;
	border-bottom-width: thin;
	border-left-width: thin;
	border-top-style: solid;
	border-top-color: #000;
	border-right-color: #000;
	border-bottom-color: #000;
	border-left-color: #000;
}
#tudo #topo #campo_bairro {
	float: left;
	width: 300px;
	padding-top: 5px;
	padding-right: 5px;
	padding-bottom: 5px;
	padding-left: 5px;
}
#tudo #topo #campo_municipio {
	padding: 5px;
	float: left;
	width: 300px;
}
#tudo #topo #campo_estado {
	padding: 5px;
	float: left;
	width: 206px;
}
#tudo #topo_servicos {
	clear: both;
}
#tudo #topo #campo_informacoes {
	padding: 5px;
	height: 400px;
	border-bottom-width: thin;
	border-bottom-style: solid;
	border-bottom-color: #000;
}
#tudo #topo2 #campo_anoprestacao {
	padding: 5px;
	float: left;
	border: thin solid #000;
	width: 250px;
}
#tudo #topo2 #campo_dataemissao {
	padding: 5px;
	float: left;
	border-top-width: thin;
	border-right-width: thin;
	border-bottom-width: thin;
	border-left-width: thin;
	border-top-style: solid;
	border-right-style: solid;
	border-top-color: #000;
	border-right-color: #000;
	border-bottom-color: #000;
	border-left-color: #000;
	border-bottom-style: solid;
}
#tudo #topo2 #campo_datavencimento {
	padding: 5px;
	float: left;
	border-top-width: thin;
	border-right-width: thin;
	border-bottom-width: thin;
	border-left-width: thin;
	border-top-style: solid;
	border-right-style: solid;
	border-bottom-style: solid;
	border-top-color: #000;
	border-right-color: #000;
	border-bottom-color: #000;
	border-left-color: #000;
}
#tudo #topo2 #both {
	clear: both;
}
#tudo #topo #topo #campo_recebemos {
	float: left;
	padding: 10px;
	border: thin solid #000;
	margin: 10px;
}
#tudo #topo #topo #campo_assinatura {
	float: left;
	padding: 10px;
	border: thin solid #000;
	margin: 10px;
}
#tudo #topo_servicos {
	height: auto;
}
#tudo #topo #topo #both {
	clear: both;
}
</style>

<div id="tudo">
<div id="topo1">
<div id="campo_logo">
<img src="../imagens/logomarca-pnsf.png" width="241" height="90"   /> 
</div>
<div id="campo_cabecalho">RUA CARLOS RIBEIRO, Nº 7, <br />
  BAIRRO DE FÁTIMA | CEP 60.040-420 <br />
  FORTALEZA | CEARÁ | BRASIL <br />
  FONES: +55 (85) 3077.2727 | 99988-6869  <br />
  contato@pousadansfatima.com.br</div>
  <div id="campo_N">
   <strong>ORCAMENTO<br />
      </strong>N.:<?php echo $row_seleciona_vendas['id']; ?><br>
      
      
      Data da Emiss. :</strong><?php echo databrasil($row_seleciona_vendas['datavenda']); ?><br>
    Atendente: <?php echo $row_seleciona_vendas['atendente'];?>
  </div>
  

  
  
  <div id="both"></div>
</div>

<div id="topo2">
  <div id="both"></div>
</div>

<div id="topo3">
<div id="campo_tomador">
 
         <strong>Cliente </strong></div><div id="both"></div>
</div>
<div id="topo">
<div id="campo_razaosocial"><strong>Nome : </strong><?php echo "<font color=blue>".$row_seleciona_vendas['nomecliente']."</font>"; ?><?php echo $row_seleciona_vendas['cliente']; ?> 





<?php if (isset($row_seleciona_vendas['cnpj']) && $row_seleciona_vendas['cnpj'] != "") {
	
	echo "<b>CNPJ:</b>". $row_seleciona_vendas['cnpj'];
	}?>
<strong>Telefone : </strong><?php echo $row_seleciona_vendas['telefone']; ?></div>
<div id="both"></div>
<div id="campo_endereco"><strong>Endereço : </strong><?php echo $row_seleciona_vendas['endereco']; ?><strong> Numero : </strong><?php echo $row_seleciona_vendas['numero']; ?></div>

<div id="campo_endereco"><strong>Ponto de Referência : </strong><?php echo $row_seleciona_vendas['pontodereferencia']; ?></div>


<div id="both"></div>
<div id="campo_cep"><strong>CEP :</strong> <?php echo $row_seleciona_vendas['cep']; ?>
</div>
<div id="both"></div>
<div id="both"></div>

<div id="campo_bairro"><strong>Bairro : 
</strong><?php echo $row_seleciona_vendas['bairro']; ?></div>

<div id="campo_municipio"><strong>Municipio : </strong><?php echo $row_seleciona_vendas['cidade']; ?></div>

<div id="campo_estado"><strong>Estado : </strong><?php echo $row_seleciona_vendas['estado']; ?> </div>
  <div id="both"></div>
</div>
<div id="both"></div>
<div id="topo_servicos">
  
<table width="100%" border="0" cellpadding="2" cellspacing="2" style="border-collapse: collapse;">
<tr bgcolor="#CCCCCC">
<td><strong>Cod.</strong></td>
<td align="center"><strong>Qtd.</strong></td>
<td align="center" bgcolor="#CCCCCC"><strong>Discriminação do produto</strong></td>
<td align="right"><strong>Valor Unit.</strong></td>
<td align="right"><strong>Sub. Total</strong></td>
</tr>
<?php do { ?>
<tr>

<td> <?php echo $row_seleciona_vendas_itens['id_produto']; ?></td>
<td align="center"> <?php echo $row_seleciona_vendas_itens['qtd']; ?></td>
<td> <?php echo $row_seleciona_vendas_itens['produto'];
echo  $row_seleciona_vendas_itens['Discriminacao']; ?></td>
<td align="right"> <?php echo "R$ ".number_format( $row_seleciona_vendas_itens['precovenda'],2,',','.');  ?></td>
<td align="right"> <?php echo "R$ ".number_format($row_seleciona_vendas_itens['qtd']*$row_seleciona_vendas_itens['precovenda'],2,',','.'); 

$t = $t + $row_seleciona_vendas_itens['qtd']*$row_seleciona_vendas_itens['precovenda'];
?>

</td>

</tr> <?php } while ($row_seleciona_vendas_itens = mysql_fetch_assoc($seleciona_vendas_itens)); ?>

  <?php 
  if ($qtd_linhas_servicos < 8 ){
	  
	  $linhas = 10 - $qtd_linhas_servicos;
	  
	  for ($i= 1;$i<=$linhas;$i++){
		  
		echo "
		 <tr><td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
     
      <td ></td>
      <td ></td>
    </tr>";
		 
		  
		  }
	  
	  
	  
	  
	  }
  ?>
  <tr >
  <td colspan="6"><hr></td>
  
  </tr>
<tr>
  <td rowspan="4">&nbsp; </td>
      <td rowspan="4">&nbsp; </td>
      <td rowspan="4">www.pousadansfatima.com.br</td>
     
      <td align="left">Anterior:</td>
      <td align="right">&nbsp;</td>
    </tr>
<tr>
  <td align="left">Entrega:</td>
  <td align="right"><?php echo  "R$ ".number_format($row_seleciona_vendas['taxadeentrega'],2,',','.');
  
  
  ?></td>
</tr>
<tr>
  <td align="left">Desconto:</td>
  <td align="right"><?php echo  "R$ ".number_format($row_seleciona_vendas['descontototal'],2,',','.');
  
  
  ?></td>
</tr>
<tr>
  <td align="left"><strong>TOTAL : &nbsp;</strong></td>
  <td align="right"><?php 
  $t = $t + $row_seleciona_vendas['taxadeentrega'] - $row_seleciona_vendas['descontototal']  ;
  
  
  echo "R$ ".number_format($t,2,',','.'); 
  

  ?></td>
</tr>
</table>

 <div id="both"></div>
</div>
</div>
<br />
<br />
