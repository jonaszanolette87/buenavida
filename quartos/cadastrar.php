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

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1_cadquartos")) {
  $insertSQL = sprintf("INSERT INTO quartos (id, nome, id_categoria, id_fornecedor,
  valor_a, valor_a_duplo, valor_a_triplo, valor_a_quadruplo, valor_a_quintuplo, valor_a_sextuplo,     
  valor_b, valor_b_duplo, valor_b_triplo, valor_b_quadruplo, valor_b_quintuplo, valor_b_sextuplo, 
  valor_f, valor_f_duplo, valor_f_triplo, valor_f_quadruplo, valor_f_quintuplo, valor_f_sextuplo,
  valor_fs, valor_fs_duplo, valor_fs_triplo,  valor_fs_quadruplo, valor_fs_quintuplo,valor_fs_sextuplo, observacoes) VALUES (%s, %s, %s,   %s, %s, %s, %s, %s,   %s, %s, 
  %s, %s, %s, %s, %s, 
  %s, %s,    %s, %s, %s,
   %s, %s,    %s, %s, %s, 
   %s, %s, %s, %s)",
                       GetSQLValueString($_POST['id'], "int"),
                       GetSQLValueString($_POST['nome'], "text"),
					   GetSQLValueString($_POST['id_categoria'], "text"),					   
					   GetSQLValueString($_POST['id_fornecedor'], "text"),
					   
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
						 
						 
					   GetSQLValueString($_POST['observacoes'], "text"));

  mysql_select_db($database_conn, $conn);
  $Result1 = mysql_query($insertSQL, $conn) or die(mysql_error());
  

  $insertGoTo = "../inicio/principal.php?t=quartos";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}


mysql_select_db($database_conn, $conn);
$query_seleciona_fornecedores = "SELECT * FROM fornecedores ORDER BY nome ASC";
$seleciona_fornecedores = mysql_query($query_seleciona_fornecedores, $conn) or die(mysql_error());
$row_seleciona_fornecedores = mysql_fetch_assoc($seleciona_fornecedores);
$totalRows_seleciona_fornecedores = mysql_num_rows($seleciona_fornecedores);


mysql_select_db($database_conn, $conn);
$query_seleciona_categorias = "SELECT * FROM categorias ORDER BY nome ASC";
$seleciona_categorias = mysql_query($query_seleciona_categorias, $conn) or die(mysql_error());
$row_seleciona_categorias = mysql_fetch_assoc($seleciona_categorias);
$totalRows_seleciona_categorias = mysql_num_rows($seleciona_categorias);
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
      <th width="908" class="Titulo16">CADASTRA QUARTOS:</th>
      <th width="40" class="Titulo16"><a href="#" onclick="closeMessage()"><img src="../imagens/botao_fechar.png" width="25" height="25" alt="fechar" /></a></th>
    </tr>
</table>
  <hr align="center" width="100%" style="border:0;border-top:1px dashed #CECBBD;height:1px;clear:both">
<table width="100%">
  <tr>
    <td>
      <form action="<?php echo $editFormAction; ?>" method="post" name="form1_cadquartos" id="form1_cadquartos">
        <table width="100%" align="center">
          <tr valign="baseline">
            <td align="right" nowrap="nowrap">NOME:</td>
            <td colspan="6"><input name="nome" type="text" id="nome" onkeyup="maiuscula(this.value)" value="" size="44" /></td>
          </tr>
          <tr valign="baseline">
            <td align="right" nowrap="nowrap">CATEGORIA:</td>
            <td colspan="6"><select tabindex="7" name="id_categoria" id="id_categoria">
              <option value=""></option>
              <?php
do {  
?>
              <option value="<?php echo $row_seleciona_categorias['id']?>"><?php echo $row_seleciona_categorias['nome']?></option>
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
            <td colspan="6"><select tabindex="7" name="id_categoria2" id="id_categoria2">
              <option value=""></option>
              <?php
do {  
?>
              <option value="<?php echo $row_seleciona_fornecedores['id']?>"><?php echo $row_seleciona_fornecedores['nome']?></option>
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
            <td>QUINTUPLO</td>
            <td>SEXTUPLO</td>
          </tr>
          <tr valign="baseline">
            <td align="right" nowrap="nowrap">VALOR ALTA :</td>
            <td><input name="valor_a" type="text" id="valor_a" onkeyup="maiuscula(this.value)" value="" size="15" /></td>
            <td><input name="valor_a_duplo" type="text" id="valor_a_duplo" onkeyup="maiuscula(this.value)" value="" size="15" /></td>
            <td><input name="valor_a_triplo" type="text" id="valor_a_triplo" onkeyup="maiuscula(this.value)" value="" size="15" /></td>
            <td><input name="valor_a_quadruplo" type="text" id="valor_a_quadruplo" onkeyup="maiuscula(this.value)" value="" size="15" /></td>
            <td><input name="valor_a_quintuplo" type="text" id="valor_a_quintuplo" onkeyup="maiuscula(this.value)" value="" size="15" /></td>
            <td><input name="valor_a_sextuplo" type="text" id="valor_a_sextuplo" onkeyup="maiuscula(this.value)" value="" size="15" /></td>
          </tr>
          <tr valign="baseline">
            <td align="right" nowrap="nowrap">VALOR BAIXA:</td>
            <td><input name="valor_b" type="text" id="valor_b" onkeyup="maiuscula(this.value)" value="" size="15" /></td>
            <td><input name="valor_b_duplo" type="text" id="valor_b_duplo" onkeyup="maiuscula(this.value)" value="" size="15" /></td>
            <td><input name="valor_b_triplo" type="text" id="valor_b_triplo" onkeyup="maiuscula(this.value)" value="" size="15" /></td>
            <td><input name="valor_b_quadruplo" type="text" id="valor_b_quadruplo" onkeyup="maiuscula(this.value)" value="" size="15" /></td>
            <td><input name="valor_b_quintuplo" type="text" id="valor_b_quintuplo" onkeyup="maiuscula(this.value)" value="" size="15" /></td>
            <td><input name="valor_b_sextuplo" type="text" id="valor_b_sextuplo" onkeyup="maiuscula(this.value)" value="" size="15" /></td>
          </tr>
          <tr valign="baseline">
            <td align="right" nowrap="nowrap">VALOR FERIADO:</td>
            <td><input name="valor_f" type="text" id="valor_f" onkeyup="maiuscula(this.value)" value="" size="15" /></td>
            <td><input name="valor_f_duplo" type="text" id="valor_f_duplo" onkeyup="maiuscula(this.value)" value="" size="15" /></td>
            <td><input name="valor_f_triplo" type="text" id="valor_f_triplo" onkeyup="maiuscula(this.value)" value="" size="15" /></td>
            <td><input name="valor_f_quadruplo" type="text" id="valor_f_quadruplo" onkeyup="maiuscula(this.value)" value="" size="15" /></td>
            <td><input name="valor_f_quintuplo" type="text" id="valor_f_quintuplo" onkeyup="maiuscula(this.value)" value="" size="15" /></td>
            <td><input name="valor_f_sextuplo" type="text" id="valor_f_sextuplo" onkeyup="maiuscula(this.value)" value="" size="15" /></td>
          </tr>
          <tr valign="baseline">
            <td align="right" nowrap="nowrap">VALOR FIM DE SEMANA:</td>
            <td><input name="valor_fs" type="text" id="valor_fs" onkeyup="maiuscula(this.value)" value="" size="15" /></td>
            <td><input name="valor_fs_duplo" type="text" id="valor_fs_duplo" onkeyup="maiuscula(this.value)" value="" size="15" /></td>
            <td><input name="valor_fs_triplo" type="text" id="valor_fs_triplo" onkeyup="maiuscula(this.value)" value="" size="15" /></td>
            <td><input name="valor_fs_quadruplo" type="text" id="valor_fs_quadruplo" onkeyup="maiuscula(this.value)" value="" size="15" /></td>
            <td><input name="valor_fs_quintuplo" type="text" id="valor_fs_quintuplo" onkeyup="maiuscula(this.value)" value="" size="15" /></td>
            <td><input name="valor_fs_sextuplo" type="text" id="valor_fs_sextuplo" onkeyup="maiuscula(this.value)" value="" size="15" /></td>
          </tr>
          <tr valign="baseline">
            <td align="right" valign="top" nowrap="nowrap">OBSERVAÇÕES:</td>
            <td colspan="6" valign="baseline"><textarea name="observacoes" cols="80" rows="5" id="observacoes" onkeyup="maiuscula(this.value)"></textarea></td>
          </tr>
          <tr valign="baseline">
            <td nowrap="nowrap" align="right">&nbsp;</td>
            <td colspan="6"><input type="submit" value="Cadastrar" />
            <input type="button" class="btn1" onclick="closeMessage()" value="Cancelar" /></td>
          </tr>
        </table>
        <input type="hidden" name="MM_insert" value="form1_cadquartos" />
      </form>
    <p>&nbsp;</p></td>
  </tr>
</table>

<script language='JavaScript' type='text/javascript'>
  document.form1_cadquartos.nome.focus()
  
</script>
<script>


function maiuscula(valor) {
var campo=document.form1_cadquartos;
campo.nome.value=campo.nome.value.toUpperCase();

}


</script>

</body>
</html>
