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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1_altreservas")) {
  $updateSQL = sprintf("UPDATE reservas SET id_fornecedor=%s, id_reserva=%s, id_cliente=%s, data_reserva=%s, hospede=%s,
  chegada=%s, saida=%s, n_noites=%s, qtd_pass=%s, id_quarto=%s,
  valor_reserva=%s,formadepagamento=%s,cafedamanha=%s, comissao=%s, valor_retido=%s ,
   cobro_adiantamento=%s,formadepagamento_checkin =%s,status=%s,checkout=%s, observacoes=%s  WHERE id=%s",
                      
					   GetSQLValueString($_POST['id_fornecedor'], "text"),
                       GetSQLValueString($_POST['id_reserva'], "text"),
					   GetSQLValueString($_POST['id_cliente'], "int"),
					   GetSQLValueString($_POST['data_reserva'], "text"),
					   GetSQLValueString($_POST['hospede'], "text"),

                       GetSQLValueString($_POST['chegada'], "text"),
					   GetSQLValueString($_POST['saida'], "text"),
					   GetSQLValueString($_POST['n_noites'], "text"),
					   GetSQLValueString($_POST['qtd_pass'], "text"),
					   GetSQLValueString($_POST['id_quarto'], "int"),
					   
					   GetSQLValueString($_POST['valor_reserva'], "text"),
			           GetSQLValueString($_POST['formadepagamento'], "text"),
                       GetSQLValueString($_POST['cafedamanha'], "text"),
					   GetSQLValueString($_POST['comissao'], "text"),					   
					   GetSQLValueString($_POST['valor_retido'], "text"),
					   
					   GetSQLValueString($_POST['cobro_adiantamento'], "text"),
					   GetSQLValueString($_POST['formadepagamento_checkin'], "text"),
					   GetSQLValueString($_POST['status'], "text"),
					   GetSQLValueString($_POST['observacoes'], "text"),
					   
					    GetSQLValueString($_POST['checkout'], "text"),
                       GetSQLValueString($_POST['id'], "int"));

  mysql_select_db($database_conn, $conn);
  $Result1 = mysql_query($updateSQL, $conn) or die(mysql_error());
  
  
  
   if ($_POST['n_noites']  == 1) {



$dia_chegada = $_POST['chegada'];
//$dia = substr($dia_chegada,0,2);
//$mes = substr($dia_chegada,3,2);
//$ano= substr($dia_chegada,6,4);
//$dia_chegada =  $ano."-".$mes."-".$dia;




//$dia_chegada = date('Y-m-d', strtotime($_POST['chegada']))   ;

//$dia = date('Y-m-d', strtotime($dia_chegada. "+".$i." days"));

   $insertSQL2 = sprintf("UPDATE reservas_dias SET id_reserva=%s,dia=%s,status=%s,id_quarto=%s    WHERE id_reserva=%s",


  // UPDATE INTO reservas_dias (id,id_reserva, dia, status, id_quarto) VALUES (%s,%s, %s, %s, %s )",


                       GetSQLValueString($_POST['id'], "int"),
					   GetSQLValueString($dia_chegada, "date"),
                       GetSQLValueString($_POST['status'], "text"),
					   GetSQLValueString($_POST['id_quarto'], "text"),
					   GetSQLValueString($_POST['id'], "int")


						);

  mysql_select_db($database_conn, $conn);
  $Result2 = mysql_query($insertSQL2, $conn) or die(mysql_error());
  }


   if ($_POST['n_noites'] >1) { 
	  
	  $diarias = $_POST['n_noites'];
	  		
			for ($i=0;$i<$diarias;$i++) {
	  
	
$dia_chegada = $_POST['chegada'];

$dia = date('Y-m-d', strtotime($dia_chegada. "+".$i." days"));
	   
   $updateSQL2 = sprintf("UPDATE reservas_dias SET  id_quarto=%s WHERE id_reserva=%s",
                       
					  
					   GetSQLValueString($_POST['id_quarto'], "int"),
					    GetSQLValueString($_POST['id'], "int")
					  
						
						);

  mysql_select_db($database_conn, $conn);
  $Result2 = mysql_query($updateSQL2, $conn) or die(mysql_error());
  }
 }  
 
  $updateGoTo = "../inicio/principal.php?t=reservas";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

$colname_seleciona_reservas = "-1";
if (isset($_GET['id'])) {
  $colname_seleciona_reservas = $_GET['id'];
}

$id = $_GET['id'];


$colname_seleciona_reservas_dias = "-1";
if (isset($_GET['id_reserva'])) {
  $colname_seleciona_reservas_dias = $_GET['id_reserva'];
}

$id_reserva = $_GET['id_reserva'];

mysql_select_db($database_conn, $conn);
$query_seleciona_reservas = sprintf("SELECT * FROM reservas WHERE id = %s", GetSQLValueString($colname_seleciona_reservas, "int"));
$seleciona_reservas = mysql_query($query_seleciona_reservas, $conn) or die(mysql_error());
$row_seleciona_reservas = mysql_fetch_assoc($seleciona_reservas);
$totalRows_seleciona_reservas = mysql_num_rows($seleciona_reservas);

mysql_select_db($database_conn, $conn);
$query_seleciona_reservas_dias = sprintf("SELECT * FROM reservas_dias WHERE id = %s", GetSQLValueString($colname_seleciona_reservas_dias, "int"));
$seleciona_reservas_dias = mysql_query($query_seleciona_reservas_dias, $conn) or die(mysql_error());
$row_seleciona_reservas_dias = mysql_fetch_assoc($seleciona_reservas_dias);
$totalRows_seleciona_reservas_dias = mysql_num_rows($seleciona_reservas_dias);


mysql_select_db($database_conn, $conn);
$query_seleciona_quartos = sprintf("SELECT * FROM quartos ");
$seleciona_quartos = mysql_query($query_seleciona_quartos, $conn) or die(mysql_error());
$row_seleciona_quartos = mysql_fetch_assoc($seleciona_quartos);
$totalRows_seleciona_quartos = mysql_num_rows($seleciona_quartos);


mysql_select_db($database_conn, $conn);
$query_seleciona_clientes = "SELECT * FROM clientes ORDER BY nome ASC";
$seleciona_clientes = mysql_query($query_seleciona_clientes, $conn) or die(mysql_error());
$row_seleciona_clientes = mysql_fetch_assoc($seleciona_clientes);
$totalRows_seleciona_clientes = mysql_num_rows($seleciona_clientes);

mysql_select_db($database_conn, $conn);
$query_seleciona_fornecedores = "SELECT * FROM fornecedores ORDER BY nome";
$seleciona_fornecedores = mysql_query($query_seleciona_fornecedores, $conn) or die(mysql_error());
$row_seleciona_fornecedores = mysql_fetch_assoc($seleciona_fornecedores);
$totalRows_seleciona_fornecedores = mysql_num_rows($seleciona_fornecedores);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<link href="../css/estilos.css" rel="stylesheet" type="text/css" />
</head>

<body>
<table width="100%"  border="0" align="center" cellpadding="0" cellspacing="2">
    <tr>
      <th width="40"><img src="../imagens/campainha.png" alt="" width="30" height="30" align="absmiddle" /></th>
      <th width="1217" class="Titulo16">ALTERA RESERVAS:</th>
      <th width="66" class="Titulo16"><a href="#" onclick="closeMessage()"><img src="../imagens/botao_fechar.png" width="25" height="25" alt="fechar" /></a></th>
    </tr>
</table>
  <hr align="center" width="100%" style="border:0;border-top:1px dashed #CECBBD;height:1px;clear:both">
<table width="100%">
  <tr>
    <td>&nbsp;
      <form action="<?php echo $editFormAction; ?>" method="post" name="form1_altreservas" id="form1_altreservas">
        <table width="100%" align="center">
          <tr valign="baseline">
            <td nowrap="nowrap" align="right">ID:</td>
            <td><?php echo $row_seleciona_reservas['id']; ?></td>
          </tr>
          <tr valign="baseline">
            <td nowrap="nowrap" align="right">FORNECEDOR:</td>
            <td><select name="id_fornecedor" id="id_fornecedor">
              <option value="">Escolha  o Fornecedor</option>
              <?php
do {  
?>
              <option value="<?php echo $row_seleciona_fornecedores['id']?>"<?php if (!(strcmp($row_seleciona_fornecedores['id'], $row_seleciona_reservas['id_fornecedor']))) {echo "selected=\"selected\"";} ?>><?php echo $row_seleciona_fornecedores['nome']?></option>
              <?php
} while ($row_seleciona_fornecedores = mysql_fetch_assoc($seleciona_fornecedores));
  $rows = mysql_num_rows($seleciona_fornecedores);
  if($rows > 0) {
      mysql_data_seek($seleciona_fornecedores, 0);
	  $row_seleciona_fornecedores = mysql_fetch_assoc($seleciona_fornecedores);
  }
?>
            </select></td>
          </tr>
          <tr valign="baseline">
            <td align="right" nowrap="nowrap">ID_RESERVA:</td>
            <td><input name="id_reserva" type="text" id="id_reserva" value="<?php echo htmlentities($row_seleciona_reservas['id_reserva'], ENT_COMPAT, 'utf-8'); ?>" size="44" /></td>
          </tr>
          <tr valign="baseline">
            <td align="right" nowrap="nowrap">DATA DA RESERVA:</td>
            <td><input name="data_reserva" type="text" id="data_reserva" value="<?php echo htmlentities($row_seleciona_reservas['data_reserva'], ENT_COMPAT, 'utf-8'); ?>" size="44" /></td>
          </tr>
          <tr valign="baseline">
            <td align="right" nowrap="nowrap">NOME DO CLIENTE:</td>
            <td><select name="id_cliente" id="id_cliente">
           <option value="">Escolha  o Cliente</option>
             <?php
do {  
?>
             <option value="<?php echo $row_seleciona_clientes['id']?>"<?php if (!(strcmp($row_seleciona_clientes['id'], $row_seleciona_reservas['id_cliente']))) {echo "selected=\"selected\"";} ?>><?php echo $row_seleciona_clientes['nome']?></option>
             <?php
} while ($row_seleciona_clientes = mysql_fetch_assoc($seleciona_clientes));
  $rows = mysql_num_rows($seleciona_clientes);
  if($rows > 0) {
      mysql_data_seek($seleciona_clientes, 0);
	  $row_seleciona_clientes = mysql_fetch_assoc($seleciona_clientes);
  }
?>
          </select></td>
          </tr>
          <tr valign="baseline">
            <td align="right" nowrap="nowrap">NOME HOSPEDE:</td>
            <td><input name="hospede" type="text" id="hospede" value="<?php echo htmlentities($row_seleciona_reservas['hospede'], ENT_COMPAT, 'utf-8'); ?>" size="44" /></td>
          </tr>
          <tr valign="baseline">
            <td align="right" nowrap="nowrap">DATA DA CHEGADA:</td>
            <td><input name="chegada" type="date" id="chegada" value="<?php echo htmlentities($row_seleciona_reservas['chegada'], ENT_COMPAT, 'utf-8'); ?>" size="44" /></td>
          </tr>
          <tr valign="baseline">
            <td align="right" nowrap="nowrap">DATA DA SAIDA:</td>
            <td><input name="saida" type="date" id="saida" value="<?php echo htmlentities($row_seleciona_reservas['saida'], ENT_COMPAT, 'utf-8'); ?>" size="44" /></td>
          </tr>
          <tr valign="baseline">
            <td align="right" nowrap="nowrap">N DE NOITES:</td>
            <td><input name="n_noites" type="number" id="n_noites" value="<?php echo htmlentities($row_seleciona_reservas['n_noites'], ENT_COMPAT, 'utf-8'); ?>" size="44" /></td>
          </tr>
          <tr valign="baseline">
            <td align="right" nowrap="nowrap">PESSOAS:</td>
            <td><input name="qtd_pass" type="number" id="qtd_pass" value="<?php echo htmlentities($row_seleciona_reservas['qtd_pass'], ENT_COMPAT, 'utf-8'); ?>" size="44" /></td>
          </tr>
          <tr valign="baseline">
            <td align="right" nowrap="nowrap">NOME APT:</td>
            <td><select name="id_quarto" id="id_quarto">
              <option value="" <?php if (!(strcmp("", $row_seleciona_reservas['id_quarto']))) {echo "selected=\"selected\"";} ?>></option>
              <?php
do {  
?>
              <option value="<?php echo $row_seleciona_quartos['id']?>"<?php if (!(strcmp($row_seleciona_quartos['id'], $row_seleciona_reservas['id_quarto']))) {echo "selected=\"selected\"";} ?>><?php echo $row_seleciona_quartos['nome']?></option>
              <?php
} while ($row_seleciona_quartos = mysql_fetch_assoc($seleciona_quartos));
  $rows = mysql_num_rows($seleciona_quartos);
  if($rows > 0) {
      mysql_data_seek($seleciona_quartos, 0);
	  $row_seleciona_quartos = mysql_fetch_assoc($seleciona_quartos);
  }
?>
            </select></td>
          </tr>
          <tr valign="baseline">
            <td align="right" nowrap="nowrap">VALOR DA RESERVA:</td>
            <td><input name="valor_reserva" type="text" id="valor_reserva" value="<?php echo htmlentities($row_seleciona_reservas['valor_reserva'], ENT_COMPAT, 'utf-8'); ?>" size="44" /></td>
          </tr>
          <tr valign="baseline">
            <td align="right" nowrap="nowrap">FORMA DE PAGAMENTO:</td>
            <td><select name="formadepagamento" id="formadepagamento">
              <option value="" <?php if (!(strcmp("", $row_seleciona_reservas['formadepagamento']))) {echo "selected=\"selected\"";} ?>></option>
              <option value="E" <?php if (!(strcmp("E", $row_seleciona_reservas['formadepagamento']))) {echo "selected=\"selected\"";} ?>>ESPECIE</option>
              <option value="C" <?php if (!(strcmp("C", $row_seleciona_reservas['formadepagamento']))) {echo "selected=\"selected\"";} ?>>CARTAO</option>
              <option value="B" <?php if (!(strcmp("B", $row_seleciona_reservas['formadepagamento']))) {echo "selected=\"selected\"";} ?>>BOLETO BANCARIO</option>
              <option value="D" <?php if (!(strcmp("D", $row_seleciona_reservas['formadepagamento']))) {echo "selected=\"selected\"";} ?>>DEPOSITO</option>
              <option value="O" <?php if (!(strcmp("O", $row_seleciona_reservas['formadepagamento']))) {echo "selected=\"selected\"";} ?>>OUTROS</option>
             
            </select></td>
          </tr>
          <tr valign="baseline">
            <td align="right" nowrap="nowrap">CAFE DA MANHA:</td>
            <td><label>
              <input <?php if (!(strcmp($row_seleciona_reservas['cafedamanha'],"S"))) {echo "checked=\"checked\"";} ?> type="radio" name="cafedamanha" value="S" id="tipo_0" />
              SIM</label>
              <label>
                <input <?php if (!(strcmp($row_seleciona_reservas['cafedamanha'],"N"))) {echo "checked=\"checked\"";} ?> type="radio" name="cafedamanha" value="N" id="tipo_1" />
            NÃO</label></td>
          </tr>
          <tr valign="baseline">
            <td align="right" nowrap="nowrap">VALOR ADIANTADO:</td>
            <td><input name="valor_retido" type="text" id="valor_retido" value="<?php echo htmlentities($row_seleciona_reservas['valor_retido'], ENT_COMPAT, 'utf-8'); ?>" size="20" /></td>
          </tr>
          <tr valign="baseline">
            <td align="right" nowrap="nowrap">COBRAR NO CHECKIN:</td>
            <td><input name="cobro_adiantamento" type="text" id="cobro_adiantamento" value="<?php echo htmlentities($row_seleciona_reservas['cobro_adiantamento'], ENT_COMPAT, 'utf-8'); ?>" size="20" /></td>
          </tr>
          <tr valign="baseline">
            <td align="right" nowrap="nowrap">FORMA DE PAGAMENTO NO CHECK IN:</td>
            <td><select name="formadepagamento_checkin" id="formadepagamento_checkin">
              <option value="" <?php if (!(strcmp("", $row_seleciona_reservas['formadepagamento_checkin']))) {echo "selected=\"selected\"";} ?>></option>
              <option value="E" <?php if (!(strcmp("E", $row_seleciona_reservas['formadepagamento_checkin']))) {echo "selected=\"selected\"";} ?>>ESPECIE</option>
              <option value="C" <?php if (!(strcmp("C", $row_seleciona_reservas['formadepagamento_checkin']))) {echo "selected=\"selected\"";} ?>>CARTAO</option>
              <option value="B" <?php if (!(strcmp("B", $row_seleciona_reservas['formadepagamento_checkin']))) {echo "selected=\"selected\"";} ?>>BOLETO BANCARIO</option>
              <option value="D" <?php if (!(strcmp("D", $row_seleciona_reservas['formadepagamento_checkin']))) {echo "selected=\"selected\"";} ?>>DEPOSITO</option>
              <option value="O" <?php if (!(strcmp("O", $row_seleciona_reservas['formadepagamento_checkin']))) {echo "selected=\"selected\"";} ?>>OUTROS</option>
            </select></td>
          </tr>
          <tr valign="baseline">
            <td align="right" nowrap="nowrap">STATUS:</td>
            
            <td><select name="status" id="status">
            
             <option value="" <?php if (!(strcmp("", $row_seleciona_reservas['status']))) {echo "selected=\"selected\"";} ?>></option>
              
             
              <option value="CONFIRMADO" <?php if (!(strcmp("CONFIRMADO", $row_seleciona_reservas['status']))) {echo "selected=\"selected\"";} ?>>CONFIRMADO</option>
              <option value="EM MANUTENCAO" <?php if (!(strcmp("PRE RESERVADO", $row_seleciona_reservas['status']))) {echo "selected=\"selected\"";} ?>>PRE RESERVADO</option>
              <option value="LIVRE" <?php if (!(strcmp("OCUPADO", $row_seleciona_reservas['status']))) {echo "selected=\"selected\"";} ?>>OCUPADO</option>
              <option value="PRE RESERVADO" <?php if (!(strcmp("BLOQUEADO", $row_seleciona_reservas['status']))) {echo "selected=\"selected\"";} ?>>BLOQUEADO</option>
              
             
              <option value="OCUPADO" <?php if (!(strcmp("EM MANUTENCAO", $row_seleciona_reservas['status']))) {echo "selected=\"selected\"";} ?>>EM MANUTENCAO</option>
              
               <option value="BLOQUEADO" <?php if (!(strcmp("CANCELADO", $row_seleciona_reservas['status']))) {echo "selected=\"selected\"";} ?>>CANCELADO</option>
              
              
            </select></td>
          </tr>
          <tr valign="baseline">
            <td nowrap="nowrap" align="right">OBSERVAÇÕES:</td>
            <td><textarea name="observacoes" cols="44" id="observacoes"><?php echo htmlentities($row_seleciona_reservas['observacoes'], ENT_COMPAT, 'utf-8'); ?></textarea></td>
          </tr>
          <tr valign="baseline">
            <td nowrap="nowrap" align="right">&nbsp;</td>
            <td><input name="id2" type="hidden" id="id" value="<?php echo $row_seleciona_reservas['id']?>" />
            <input name="id_permissao" type="hidden" id="id_permissao" value="<?php echo $row_permissoes['id']?>" />
            
            <input name="checkout" type="hidden" id="checkout" value="<?php  $date = date('Y-m-d H:i:s');  echo $date;
			?>" />
            
            
            </td>
          </tr>
          <tr valign="baseline">
            <td nowrap="nowrap" align="right">&nbsp;</td>
            <td><input type="submit" value="Confirmar" />
            <input type="button" class="btn1" onclick="closeMessage()" value="Cancelar" /></td>
          </tr>
        </table>
        <input type="hidden" name="MM_update" value="form1_altreservas" />
        <input type="hidden" name="id" value="<?php echo $row_seleciona_reservas['id']; ?>" />
      </form>
   </td>
  </tr>
</table>


<script>


function maiuscula(valor) {
var campo=document.form1_altreservas;
campo.hospede.value = campo.hospede.value.toUpperCase();
campo.fornecedor.value = campo.fornecedor.value.toUpperCase();
campo.local_realocado.value = campo.local_realocado.value.toUpperCase();
campo.observacoes.value = campo.observacoes.value.toUpperCase();


}


</script>
</body>
</html>
<?php
mysql_free_result($seleciona_reservas);
mysql_free_result($seleciona_reservas_dias);
?>
