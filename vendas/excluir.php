<?php require_once('../Connections/conn.php'); ?>
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

if ((isset($_POST["exclui"])) && ($_POST["exclui"] == "f3")) {



	  
	  
mysql_select_db($database_conn, $conn);
$seleciona_vendas_itens = sprintf("SELECT vi.*, p.nome as produto, p.id as id, vi.qtd as qtd FROM vendas_itens vi

LEFT JOIN produtos p
ON vi.id_produto = p.id



WHERE id_venda = %s",  GetSQLValueString($_POST['id'], "int"));


$vendas_itens = mysql_query($seleciona_vendas_itens, $conn) or die(mysql_error());
$row_seleciona_vendas_itens = mysql_fetch_assoc($vendas_itens);

  do {
  
   $qtd = $row_seleciona_vendas_itens['qtd']; 
 	$id_produto =  $row_seleciona_vendas_itens['id'];  
	  
	
	$updateSQL2 =  "UPDATE produtos SET  estoque= estoque + '$qtd' WHERE id = '$id_produto'";
	
	 $Result2 = mysql_query($updateSQL2, $conn) or die(mysql_error());
	
  } while ($row_seleciona_vendas_itens = mysql_fetch_assoc($vendas_itens));
  
  
  
  $deleteSQL = sprintf("DELETE FROM vendas WHERE id=%s",
                       GetSQLValueString($_POST['id'], "int"));

   
  
  
  mysql_select_db($database_conn, $conn);
  $Result1 = mysql_query($deleteSQL, $conn) or die(mysql_error());
  
  
  
  
  
  

  $deleteGoTo = "../inicio/principal.php?pg=vendas";
  if (isset($_SERVER['QUERY_STRING'])) {
    $deleteGoTo .= (strpos($deleteGoTo, '?')) ? "&" : "?";
    $deleteGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $deleteGoTo));
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<link href="../css/estilos.css" rel="stylesheet" type="text/css" />
</head>

<body>
<?php 
$id = $_GET['id'];

mysql_select_db($database_conn, $conn);

$seleciona_vendas = "SELECT * FROM vendas WHERE id = '$id'";
$vendas = mysql_query($seleciona_vendas , $conn) or die(mysql_error());
$row_vendas = mysql_fetch_assoc($vendas);

$totalRows_vendas = mysql_num_rows($vendas);
mysql_free_result($vendas);



$seleciona_vendas_itens = "SELECT vi.*, p.nome as produto, p.id as id, vi.qtd as qtd FROM vendas_itens vi

LEFT JOIN produtos p
ON vi.id_produto = p.id



WHERE id_venda = '$id'";


$vendas_itens = mysql_query($seleciona_vendas_itens, $conn) or die(mysql_error());
$row_vendas_itens = mysql_fetch_assoc($vendas_itens);

mysql_free_result($vendas_itens);



?>
<form name="f3" id="f3" method="post" action="../vendas/excluir.php">
<table width="100%"  border="0" align="center" cellpadding="0" cellspacing="2">
    <tr>
      <th width="40"><img src="../imagens/venda2.png" width="30" height="30"></th>
      <th width="894" ><strong><em><font >EXCLUIR VENDA</font></em></strong></th>
      <th width="36" ><a href="#" onclick="closeMessage()"><img src="../imagens/botao_fechar.png" width="25" height="25" alt="fechar" /></a></th>
    </tr>
  </table>
  <hr align="center" width="100%" style="border:0;border-top:1px dashed #CECBBD;height:1px;clear:both"><table width="100%" cellpadding="1" cellspacing="2">
  <tr>
    <td>      <p>Confirma a Exclus&atilde;o da venda:<br>
      <strong> ID:<?php echo $row_vendas['id']?> DATA:<?php echo $row_vendas['datavenda']?></strong></p>
   
       
        <br>
        <input name="exclui" type="hidden" id="exclui" value="f3">
        <input name="id" type="hidden" id="id" value="<?php echo $row_vendas['id']?>">
      </p></td>
    </tr>
  <tr>
    <td>
<table border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><input name="Entrar" type="submit" class="btn1" id="Entrar" value="CONFIRMAR"></td>
    <td>&nbsp;</td>
    <td><input name="Entrar" type="button" class="btn1" id="Entrar" onclick="closeMessage()" value="CANCELAR"></td>
  </tr>
</table>	</td>
    </tr>
</table>
</form>
</body>
</html>