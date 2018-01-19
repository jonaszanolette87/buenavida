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

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
  $updateSQL = sprintf("UPDATE quartos SET nome=%s,id_categoria=%s,id_fornecedor=%s,
  valor_a=%s,valor_a_duplo=%s,valor_a_triplo=%s,valor_a_quadruplo=%s,valor_a_quintuplo=%s,valor_a_sextuplo=%s,
  valor_b=%s,valor_b_duplo=%s,valor_b_triplo=%s,valor_b_quadruplo=%s,valor_b_quintuplo=%s,valor_b_sextuplo=%s,
  valor_f=%s,valor_f_duplo=%s,valor_f_triplo=%s,valor_f_quadruplo=%s,valor_f_quintuplo=%s,valor_f_sextuplo=%s,
  valor_fs=%s,valor_fs_duplo=%s, valor_fs_triplo=%s,valor_fs_quadruplo=%s, valor_fs_quintuplo=%s,valor_fs_sextuplo=%s,
  
  observacoes=%s
  
  
  WHERE id=%s",
                       GetSQLValueString($_POST['nome'], "text"),
					   GetSQLValueString($_POST['id_categoria'], "int"),
					   GetSQLValueString($_POST['id_fornecedor'], "int"),
					   GetSQLValueString($_POST['valor_a'], "text"),
					   GetSQLValueString($_POST['valor_a_duplo'], "text"),
					   GetSQLValueString($_POST['valor_a_triplo'], "text"),
					   GetSQLValueString($_POST['valor_a_quadruplo'], "text"),
					   GetSQLValueString($_POST['valor_a_quintuplo'], "text"),
					   GetSQLValueString($_POST['valor_a_sextuplo'], "text"),
					   
					   GetSQLValueString($_POST['valor_b'], "text"),
					   GetSQLValueString($_POST['valor_b_duplo'], "text"),
					   GetSQLValueString($_POST['valor_b_triplo'], "text"),
					   GetSQLValueString($_POST['valor_b_quadruplo'], "text"),
					   GetSQLValueString($_POST['valor_b_quintuplo'], "text"),
					   GetSQLValueString($_POST['valor_b_sextuplo'], "text"),
					   
					   
					   GetSQLValueString($_POST['valor_f'], "text"),
					   GetSQLValueString($_POST['valor_f_duplo'], "text"),
					   GetSQLValueString($_POST['valor_f_triplo'], "text"),
					   GetSQLValueString($_POST['valor_f_quadruplo'], "text"),
					   GetSQLValueString($_POST['valor_f_quintuplo'], "text"),
					   GetSQLValueString($_POST['valor_f_sextuplo'], "text"),
					   
					   
					   GetSQLValueString($_POST['valor_fs'], "text"),
					   GetSQLValueString($_POST['valor_fs_duplo'], "text"),
					   GetSQLValueString($_POST['valor_fs_triplo'], "text"),
					   GetSQLValueString($_POST['valor_fs_quadruplo'], "text"),
					   GetSQLValueString($_POST['valor_fs_quintuplo'], "text"),
					   GetSQLValueString($_POST['valor_fs_sextuplo'], "text"),
					    GetSQLValueString($_POST['observacoes'], "text"),
                       
                       GetSQLValueString($_POST['id'], "int"));

  mysql_select_db($database_conn, $conn);
  $Result1 = mysql_query($updateSQL, $conn) or die(mysql_error());
  
 
  $updateGoTo = "../inicio/principal.php?t=quartos";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

$colname_seleciona_quartos = "-1";
if (isset($_GET['id'])) {
  $colname_seleciona_quartos = $_GET['id'];
}

$id = $_GET['id'];

mysql_select_db($database_conn, $conn);
$query_seleciona_quartos = sprintf("SELECT * FROM quartos WHERE id = %s", GetSQLValueString($colname_seleciona_quartos, "int"));
$seleciona_quartos = mysql_query($query_seleciona_quartos, $conn) or die(mysql_error());
$row_seleciona_quartos = mysql_fetch_assoc($seleciona_quartos);
$totalRows_seleciona_quartos = mysql_num_rows($seleciona_quartos);


mysql_select_db($database_conn, $conn);
$query_seleciona_categorias = "SELECT * FROM categorias ORDER BY nome ASC";
$seleciona_categorias = mysql_query($query_seleciona_categorias, $conn) or die(mysql_error());
$row_seleciona_categorias = mysql_fetch_assoc($seleciona_categorias);
$totalRows_seleciona_categorias = mysql_num_rows($seleciona_categorias);

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
      <th width="38"><img src="../imagens/quartos.png" alt="" width="32" height="32" align="absmiddle" /></th>
      <th width="908" class="Titulo16">ALTERA QUARTOS:</th>
      <th width="40" class="Titulo16"><a href="#" onclick="closeMessage()"><img src="../imagens/botao_fechar.png" width="25" height="25" alt="fechar" /></a></th>
    </tr>
</table>
  <hr align="center" width="100%" style="border:0;border-top:1px dashed #CECBBD;height:1px;clear:both">
<table width="100%">
  <tr>
    <td>&nbsp;
      <form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
        <table width="100%" align="center">
          <tr valign="baseline">
            <td nowrap="nowrap" align="right">ID:</td>
            <td colspan="6"><?php echo $row_seleciona_quartos['id']; ?></td>
          </tr>
          <tr valign="baseline">
            <td nowrap="nowrap" align="right">NOME:</td>
            <td colspan="6"><input name="nome" type="text" id="nome" value="<?php echo htmlentities($row_seleciona_quartos['nome'], ENT_COMPAT, 'utf-8'); ?>" size="44" /></td>
          </tr>
          <tr valign="baseline">
            <td align="right" nowrap="nowrap">CATEGORIA:</td>
            <td colspan="6"><select name="id_categoria" id="id_categoria">
              <option value="" <?php if (!(strcmp("", $row_seleciona_quartos['id_categoria']))) {echo "selected=\"selected\"";} ?>></option>
              <?php
do {  
?>
              <option value="<?php echo $row_seleciona_categorias['id']?>"<?php if (!(strcmp($row_seleciona_categorias['id'], $row_seleciona_quartos['id_categoria']))) {echo "selected=\"selected\"";} ?>><?php echo $row_seleciona_categorias['nome']?></option>
              <?php
} while ($row_seleciona_categorias = mysql_fetch_assoc($seleciona_categorias));
  $rows = mysql_num_rows($seleciona_categorias);
  if($rows > 0) {
      mysql_data_seek($seleciona_categorias, 0);
	  $row_seleciona_categorias = mysql_fetch_assoc($seleciona_categorias);
  }
?>
            </select></td>
          </tr>
          <tr valign="baseline">
            <td align="right" nowrap="nowrap">FORNECEDOR:</td>
            <td colspan="6"><select name="id_fornecedor" id="id_fornecedor">
              <option value="">Escolha  o Fornecedor</option>
              <?php
do {  
?>
              <option value="<?php echo $row_seleciona_fornecedores['id']?>"<?php if (!(strcmp($row_seleciona_fornecedores['id'], $row_seleciona_quartos['id_fornecedor']))) {echo "selected=\"selected\"";} ?>><?php echo $row_seleciona_fornecedores['nome']?></option>
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
            <td align="right" nowrap="nowrap">&nbsp;</td>
            <td>SIMPLES</td>
            <td>DUPLO</td>
            <td>TRIPLO</td>
            <td>QUADRUPLO</td>
            <td><p>QUINTUPLO</p></td>
            <td>SEXTUPLO</td>
          </tr>
          <tr valign="baseline">
            <td align="right" nowrap="nowrap">VALOR ALTA :</td>
            <td><input name="valor_a" type="text" id="valor_a" value="<?php echo htmlentities($row_seleciona_quartos['valor_a'], ENT_COMPAT, 'utf-8'); ?>" size="15" /></td>
            <td><input name="valor_a_duplo" type="text" id="valor_a_duplo" value="<?php echo htmlentities($row_seleciona_quartos['valor_a_duplo'], ENT_COMPAT, 'utf-8'); ?>" size="15" /></td>
            <td><input name="valor_a_triplo" type="text" id="valor_a_triplo" value="<?php echo htmlentities($row_seleciona_quartos['valor_a_triplo'], ENT_COMPAT, 'utf-8'); ?>" size="15" /></td>
            <td><input name="valor_a_quadruplo" type="text" id="valor_a_quadruplo" value="<?php echo htmlentities($row_seleciona_quartos['valor_a_quadruplo'], ENT_COMPAT, 'utf-8'); ?>" size="15" /></td>
            <td><input name="valor_a_quintuplo" type="text" id="valor_a_quintuplo" value="<?php echo htmlentities($row_seleciona_quartos['valor_a_quintuplo'], ENT_COMPAT, 'utf-8'); ?>" size="15" /></td>
            <td><input name="valor_a_sextuplo" type="text" id="valor_a_sextuplo" value="<?php echo htmlentities($row_seleciona_quartos['valor_a_sextuplo'], ENT_COMPAT, 'utf-8'); ?>" size="15" /></td>
          </tr>
          <tr valign="baseline">
            <td nowrap="nowrap" align="right">VALOR BAIXA:</td>
            <td><input name="valor_b" type="text" id="valor_b" value="<?php echo htmlentities($row_seleciona_quartos['valor_b'], ENT_COMPAT, 'utf-8'); ?>" size="15" /></td>
            <td><input name="valor_b_duplo" type="text" id="valor_b_duplo" value="<?php echo htmlentities($row_seleciona_quartos['valor_b_duplo'], ENT_COMPAT, 'utf-8'); ?>" size="15" /></td>
            <td><input name="valor_b_triplo" type="text" id="valor_b_triplo" value="<?php echo htmlentities($row_seleciona_quartos['valor_b_triplo'], ENT_COMPAT, 'utf-8'); ?>" size="15" /></td>
            <td><input name="valor_b_quadruplo" type="text" id="valor_b_quadruplo" value="<?php echo htmlentities($row_seleciona_quartos['valor_b_quadruplo'], ENT_COMPAT, 'utf-8'); ?>" size="15" /></td>
            <td><input name="valor_b_quintuplo" type="text" id="valor_b_quintuplo" value="<?php echo htmlentities($row_seleciona_quartos['valor_b_quintuplo'], ENT_COMPAT, 'utf-8'); ?>" size="15" /></td>
            <td><input name="valor_b_sextuplo" type="text" id="valor_b_sextuplo" value="<?php echo htmlentities($row_seleciona_quartos['valor_b_sextuplo'], ENT_COMPAT, 'utf-8'); ?>" size="15" /></td>
          </tr>
          <tr valign="baseline">
            <td align="right" nowrap="nowrap">VALOR FERIADO:</td>
            <td><input name="valor_f" type="text" id="valor_f" value="<?php echo htmlentities($row_seleciona_quartos['valor_f'], ENT_COMPAT, 'utf-8'); ?>" size="15" /></td>
            <td><input name="valor_f_duplo" type="text" id="valor_f_duplo" value="<?php echo htmlentities($row_seleciona_quartos['valor_f_duplo'], ENT_COMPAT, 'utf-8'); ?>" size="15" /></td>
            <td><input name="valor_f_triplo" type="text" id="valor_f_triplo" value="<?php echo htmlentities($row_seleciona_quartos['valor_f_triplo'], ENT_COMPAT, 'utf-8'); ?>" size="15" /></td>
            <td><input name="valor_f_quadruplo" type="text" id="valor_f_quadruplo" value="<?php echo htmlentities($row_seleciona_quartos['valor_f_quadruplo'], ENT_COMPAT, 'utf-8'); ?>" size="15" /></td>
            <td><input name="valor_f_quintuplo" type="text" id="valor_f_quintuplo" value="<?php echo htmlentities($row_seleciona_quartos['valor_f_quintuplo'], ENT_COMPAT, 'utf-8'); ?>" size="15" /></td>
            <td><input name="valor_f_sextuplo" type="text" id="valor_f_sextuplo" value="<?php echo htmlentities($row_seleciona_quartos['valor_f_sextuplo'], ENT_COMPAT, 'utf-8'); ?>" size="15" /></td>
          </tr>
          <tr valign="baseline">
            <td align="right" nowrap="nowrap">VALOR FIM DE SEMANA:</td>
            <td><input name="valor_fs" type="text" id="valor_fs" value="<?php echo htmlentities($row_seleciona_quartos['valor_fs'], ENT_COMPAT, 'utf-8'); ?>" size="15" /></td>
            <td><input name="valor_fs_duplo" type="text" id="valor_fs_duplo" value="<?php echo htmlentities($row_seleciona_quartos['valor_fs_duplo'], ENT_COMPAT, 'utf-8'); ?>" size="15" /></td>
            <td><input name="valor_fs_triplo" type="text" id="valor_fs_triplo" value="<?php echo htmlentities($row_seleciona_quartos['valor_fs_triplo'], ENT_COMPAT, 'utf-8'); ?>" size="15" /></td>
            <td><input name="valor_fs_quadruplo" type="text" id="valor_fs_quadruplo" value="<?php echo htmlentities($row_seleciona_quartos['valor_fs_quadruplo'], ENT_COMPAT, 'utf-8'); ?>" size="15" /></td>
            <td><input name="valor_fs_quintuplo" type="text" id="valor_fs_quintuplo" value="<?php echo htmlentities($row_seleciona_quartos['valor_fs_quintuplo'], ENT_COMPAT, 'utf-8'); ?>" size="15" /></td>
            <td><input name="valor_fs_sextuplo" type="text" id="valor_fs_sextuplo" value="<?php echo htmlentities($row_seleciona_quartos['valor_fs_sextuplo'], ENT_COMPAT, 'utf-8'); ?>" size="15" /></td>
          </tr>
          <tr valign="baseline">
            <td align="right" valign="top" nowrap="nowrap"><input name="id2" type="hidden" id="id" value="<?php echo $row_seleciona_quartos['id']?>" />
            OBERVAÇÕES:</td>
            <td colspan="6" valign="baseline"><textarea name="observacoes" cols="80" rows="5" id="observacoes" onkeyup="maiuscula(this.value)"></textarea></td>
          </tr>
          <tr valign="baseline">
            <td nowrap="nowrap" align="right">&nbsp;</td>
            <td colspan="6"><input type="submit" value="Confirmar" />
            <input type="button" class="btn1" onclick="closeMessage()" value="Cancelar" /></td>
          </tr>
        </table>
        <input type="hidden" name="MM_update" value="form1" />
        <input type="hidden" name="id" value="<?php echo $row_seleciona_quartos['id']; ?>" />
      </form>
    <p>&nbsp;</p></td>
  </tr>
</table>
</body>
</html>
<?php
mysql_free_result($seleciona_quartos);
?>
