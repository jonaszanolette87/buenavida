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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
  $updateSQL = sprintf("UPDATE vendas SET id_cliente=%s, id_atendente=%s, nomecliente=%s, pontodereferencia=%s, taxadeentrega=%s,datavenda =%s,hora =%s,tipo =%s,status =%s WHERE id=%s",
  
                     
                 GetSQLValueString($_POST['id_cliente'], "int"),
				 GetSQLValueString($_POST['id_atendente'], "int"),
				 GetSQLValueString($_POST['nomecliente'], "text"),
				 GetSQLValueString($_POST['pontodereferencia'], "text"),
				 GetSQLValueString($_POST['taxadeentrega'], "text"),
                 GetSQLValueString(datausa($_POST['datacadastro']), "date"),
				 GetSQLValueString($_POST['hora'], "text"),                       
                GetSQLValueString("V", "text"),                
				 GetSQLValueString($_POST['status'], "text"),                                     
                    
                       GetSQLValueString($_POST['id'], "int"));

  mysql_select_db($database_conn, $conn);
  $Result1 = mysql_query($updateSQL, $conn) or die(mysql_error());

  $updateGoTo = "../inicio/principal.php?t=vendas";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

$colname_seleciona_vendas = "-1";
if (isset($_GET['id'])) {
  $colname_seleciona_vendas = $_GET['id'];
}
mysql_select_db($database_conn, $conn);
$query_seleciona_vendas = sprintf("SELECT * FROM vendas WHERE id = %s", GetSQLValueString($colname_seleciona_vendas, "int"));
$seleciona_vendas = mysql_query($query_seleciona_vendas, $conn) or die(mysql_error());
$row_seleciona_vendas = mysql_fetch_assoc($seleciona_vendas);
$totalRows_seleciona_vendas = mysql_num_rows($seleciona_vendas);

mysql_select_db($database_conn, $conn);



$query_seleciona_reservas_hospedadas = "SELECT r.*, c.nome as cliente FROM reservas r

LEFT JOIN clientes c 
ON r.id_cliente = c.id


WHERE status='HOSPEDADO' ORDER BY id DESC";
$seleciona_reservas_hospedadas = mysql_query($query_seleciona_reservas_hospedadas, $conn) or die(mysql_error());
$row_seleciona_reservas_hospedadas = mysql_fetch_assoc($seleciona_reservas_hospedadas);
$totalRows_seleciona_reservas_hospedadas = mysql_num_rows($seleciona_reservas_hospedadas);



mysql_select_db($database_conn, $conn);
$query_seleciona_atendentes = "SELECT * FROM usuarios ORDER BY login ASC";
$seleciona_atendentes = mysql_query($query_seleciona_atendentes, $conn) or die(mysql_error());
$row_seleciona_atendentes = mysql_fetch_assoc($seleciona_atendentes);
$totalRows_seleciona_atendentes = mysql_num_rows($seleciona_atendentes);



mysql_select_db($database_conn, $conn);
$query_seleciona_formasdepagamento = "SELECT * FROM formasdepagamento";
$seleciona_formasdepagamento = mysql_query($query_seleciona_formasdepagamento, $conn) or die(mysql_error());
$row_seleciona_formasdepagamento = mysql_fetch_assoc($seleciona_formasdepagamento);
$totalRows_seleciona_formasdepagamento = mysql_num_rows($seleciona_formasdepagamento);
?>



<table width="100%"  border="0" align="center" cellpadding="0" cellspacing="2">
    <tr>
      <th width="38"><img src="../imagens/usuarios2.png" width="30" height="30"></th>
      <th width="908" class="Titulo16"> VENDAS:</th>
      <th width="40" class="Titulo16"><a href="#" onClick="closeMessage()"><img src="../imagens/botao_fechar.png" width="25" height="25" alt="fechar" /></a></th>
    </tr>
</table>
  <hr align="center" width="100%" style="border:0;border-top:1px dashed #CECBBD;height:1px;clear:both">
  <form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
    <table width="100%" align="center">
      <tr valign="baseline">
        <td colspan="2" nowrap="nowrap">ID:<?php echo $row_seleciona_vendas['id']; ?>     ATENDENTE:
          <select name="id_atendente" id="id_atendente">
            <option>Escolha o Atendente</option>
            <?php
do {  
?>
            <option value="<?php echo $row_seleciona_atendentes['id']?>"<?php if (!(strcmp($row_seleciona_atendentes['id'], $row_seleciona_vendas['id_atendente']))) {echo "selected=\"selected\"";} ?>><?php echo $row_seleciona_atendentes['login']?></option>
            <?php
} while ($row_seleciona_atendentes = mysql_fetch_assoc($seleciona_atendentes));
  $rows = mysql_num_rows($seleciona_atendentes);
  if($rows > 0) {
      mysql_data_seek($seleciona_atendentes, 0);
	  $row_seleciona_atendentes = mysql_fetch_assoc($seleciona_atendentes);
  }
?>
          </select>
          
     
     
      SITUAÇÃO:
      <label>
      <input <?php if (!(strcmp($row_seleciona_vendas['status'],"A"))) {echo "checked=\"checked\"";} ?> type="radio" name="status" value="A" id="status" />
      ABERTA</label>
      <label>
        <input <?php if (!(strcmp($row_seleciona_vendas['status'],"F"))) {echo "checked=\"checked\"";} ?> type="radio" name="status" value="F" id="status" />
      FECHADA</label>
      
      
      
      <br>
NUMERO DA HOSPEDAGEM:
<select name="id_cliente" id="id_cliente">
          <option>Escolha o Hospede</option>
          <?php
do {  
?>
          <option value="<?php echo $row_seleciona_reservas_hospedadas['id']?>"<?php if (!(strcmp($row_seleciona_reservas_hospedadas['id'], $row_seleciona_vendas['id_cliente']))) {echo "selected=\"selected\"";} ?>><?php echo $row_seleciona_reservas_hospedadas['id'] ."-". $row_seleciona_reservas_hospedadas['cliente']?></option>
          <?php
} while ($row_seleciona_reservas_hospedadas = mysql_fetch_assoc($seleciona_reservas_hospedadas));
  $rows = mysql_num_rows($seleciona_reservas_hospedadas);
  if($rows > 0) {
      mysql_data_seek($seleciona_reservas_hospedadas, 0);
	  $row_seleciona_reservas_hospedadas = mysql_fetch_assoc($seleciona_reservas_hospedadas);
  }
?>
        </select> 
          
          
          DATA VENDA:
<?php if (   isset($row_seleciona_vendas['datavenda'])  &&  ($row_seleciona_vendas['datavenda'] !="")) { ?>
        <input name="datacadastro" type="text"  id="data_1" value="<?php echo databrasil($row_seleciona_vendas['datavenda']);?>" size="8" />
        <?php } else { ?>
        
        <input name="datacadastro" type="text"  id="data_1" value="<?php echo date("d/m/Y");?>" size="8" />
        
        <?php } ?>
        <input name="deposito" type="checkbox" id="deposito" checked="checked" />
        <label for="deposito"></label>
Est. 
<input type="checkbox" name="palmas" id="palmas" />
<label for="palmas"></label></td>
      </tr>
      
      <tr valign="baseline">
        <td colspan="2" align="left" nowrap="nowrap"><iframe width="1050px" height="250px" frameborder="0" src="../vendas_itens/index.php?id_venda=<?php echo $row_seleciona_vendas['id']?>"></iframe></td>
      </tr>
   
      <tr valign="baseline">
        <td colspan="2" align="left" nowrap="nowrap"><iframe width="1050px" height="150px" frameborder="0" src="../vendas_fechamento/index.php?id_venda=<?php echo $row_seleciona_vendas['id']?>"></iframe></td>
      </tr>
      <tr valign="baseline">
        <td width="1%" align="right" nowrap="nowrap"><input type="submit" value="CONFIRMAR" /> <input type="button" class="btn1" onclick="closeMessage()" value="Cancelar" /></td></td>
        <td width="99%">&nbsp;</td>
      </tr>
    </table>
    <input type="hidden" name="MM_update" value="form1" />
    <input type="hidden" name="id" value="<?php echo $row_seleciona_vendas['id']; ?>" />
     <input type="hidden" name="hora" value="<?php echo date('H:i:s'); ?>" />
  </form>
  <p>&nbsp;</p>
<?php
mysql_free_result($seleciona_vendas);

mysql_free_result($seleciona_reservas_hospedadas);


?>
