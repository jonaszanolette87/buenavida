<?php require_once('../Connections/conn.php'); 
include("../funcoes/funcoes.php");?>
<?php

if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}
?>
<style type="text/css">
#botoes #botao1 {
	margin: 5px;
	padding: 5px;
	float: left;
	height: 200px;
	width: 150px;
	background-color: #D6D6D6;
	border-radius:5px;
}
#botoes #botao1:hover {
	box-shadow: 1px 2px 6px rgba(0, 0, 0, 0.5);
	-moz-box-shadow: 1px 2px 6px rgba(0, 0, 0, 0.5);
	-webkit-box-shadow: 1px 2px 6px rgba(0, 0, 0, 0.5);
}
#botoes #botao1 #nome {
	font-family: Tahoma, Geneva, sans-serif;
	font-weight: bold;
	color: #266298;
	text-align: center;
	width: 150px;
}
#botoes #botao1 #foto {
	height: auto;
	width: auto;
	border-radius: 5px;
	text-align: center;
}
</style>

<div id="botoes">
<div id="botao1">
  <div id="foto">
  <p>&nbsp;</p>
  <p><a href="../inicio/principal.php?t=clientes"><img src="../imagens/clientes.png" width="81" height="90" /></a></p>
</div>
<div id="nome">Central de Clientes</div>
</div>

<div id="botao1">
<div id="foto">
  <p>&nbsp;</p>
  <p><a href="../inicio/principal.php?t=colaboradores"><img src="../imagens/colaboradores.png" width="81" height="90" /></a></p>
</div>
<div id="nome">Central de Colaboradores</div>
</div>
<div id="botao1">
<div id="foto">
  <p>&nbsp;</p>
  <p><a href="../inicio/principal.php?t=fornecedores"><img src="../imagens/fornecedores.png" width="81" height="90" /></a></p>
</div>
<div id="nome">Central de Fornecedores</div>
</div>
<div id="botao1">
  <div id="foto">
  <p>&nbsp;</p>
  <p><a href="../inicio/principal.php?t=produtos"><img src="../imagens/produtos.png" width="87" height="90" /></a></p>
</div>
<div id="nome">Central de Produtos</div>
</div>

<div id="botao1">
  <div id="foto">
  <p>&nbsp;</p>
  <p><a href="../inicio/principal.php?t=vendas"><img src="../imagens/vendas.png" width="87" height="90" /></a></p>
</div>
<div id="nome">Central de Vendas</div>
</div>
<div id="botao1">
  <div id="foto">
  <p>&nbsp;</p>
  <p><a href="../inicio/principal.php?t=configuracoes"><img src="../imagens/configuracao.png" width="81" height="90" /></a></p>
</div>
<div id="nome">Configuracoes do sistema</div>
</div>

<div id="botao1">
  <div id="foto">
  <p>&nbsp;</p>
  <p><a href="../inicio/principal.php?t=usuarios"><img src="../imagens/usuarios2.png" width="81" height="82" /></a></p>
</div>
<div id="nome">Usuarios</div>
</div>

<div id="botao1">
  <div id="foto">
  <p><a href="../inicio/principal.php?t=reservas"><br>
    <img src="../imagens/campainha.png" width="115" height="101" /></a></p>
</div>
<div id="nome">Reservas</div>
</div>


<div id="botao1">
  <div id="foto">
  <p><a href="../inicio/principal.php?t=mapa_de_reservas"><img src="../imagens/mapadereservas.png" width="115" height="116" /></a></p>
</div>
<div id="nome">Mapa de Reservas</div>
</div>

<div id="botao1">
  <div id="foto">
  <p>&nbsp;</p>
  <p><a href="../inicio/principal.php?t=quartos"><img src="../imagens/quartos.png" width="115" height="88" /></a></p>
</div>
<div id="nome">Quartos</div>
</div>

<div id="botao1">
  <div id="foto">
  <p>&nbsp;</p>
  <p><a href="../inicio/principal.php?t=contas_a_pagar"><img src="../imagens/contasapagar.png" width="115" height="76" /></a></p>
</div>
<div id="nome">Contas a pagar</div>
</div>

<div id="botao1">
  <div id="foto">
  <p><a href="../inicio/principal.php?t=contas_a_receber"><img src="../imagens/contasareceber.png" width="115" height="124" /></a></p>
</div>
<div id="nome">Contas a Receber</div>
</div>

<div id="botao1">
  <div id="foto">
  <p><br>
  </p>
  <p><a href="../inicio/principal.php?t=movimento_diario"><img src="../imagens/caixa.png" width="115" height="76" /></a></p>
</div>
<div id="nome">Movimento Diário</div>
</div>


<div id="botao1">
  <div id="foto">
  <p><?php
  
  mysql_select_db($database_conn, $conn);
  $sql_aniver = "SELECT nome, email , fone1
  FROM clientes WHERE DAY(datanascimento) = ".date('d')." AND  MONTH(datanascimento)=".date('m') ;
  
  $result_niver = mysql_query($sql_aniver,$conn) or die (mysql_error());
  
  $linha = mysql_fetch_assoc($result_niver);
 
  	
	
	
	do {
		
		echo $linha['nome']."<br>";
		echo $linha['email']."<br>";
		echo $linha['fone1']."<br>";
		echo "<hr>";
		
  } while ($linha = mysql_fetch_assoc($result_niver)); ?>
  
 
  </p>
  <p>&nbsp;</p>
</div>
<div id="nome"><a href="../inicio/principal.php?t=aniversariantes">Aniversariantes</a>
<?php echo date("d/m/Y");?>

</div>
</div>

<div id="botao1">
  <div id="foto">
 <a href="../inicio/principal.php?t=tarifas"><img src="../imagens/cifrao.png" width="115" height="125" /></a></p>
</div>
<div id="nome">Tarifas</div>
</div>

<div id="both"></div>

</div>
