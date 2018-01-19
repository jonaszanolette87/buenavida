<?php require_once('../Connections/conn.php');
include("../funcoes/funcoes.php") ?>
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

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1_altfornecedores")) {
  $updateSQL = sprintf("UPDATE fornecedores SET tipo=%s, nome=%s, endereco=%s, bairro=%s, cidade=%s, complemento=%s, cep=%s, fone1=%s, fone2=%s, uf=%s, fone=%s, cpf=%s, rg=%s, cnpj=%s, ie=%s, id_vendedor=%s, email=%s, senha=%s, site=%s, cpfcnpj=%s, rginscricao=%s, contato=%s, datanascimento=%s, ativo=%s, id_tabela=%s, comissao=%s, comissao2=%s, aberto=%s, observacoes=%s, data_cadastro=%s WHERE id=%s",
                       GetSQLValueString($_POST['tipo'], "text"),
                       GetSQLValueString($_POST['nome'], "text"),
                       GetSQLValueString($_POST['endereco'], "text"),
                       GetSQLValueString($_POST['bairro'], "text"),
                       GetSQLValueString($_POST['cidade'], "text"),
					   
                       GetSQLValueString($_POST['complemento'], "text"),
                       GetSQLValueString($_POST['cep'], "text"),
                       GetSQLValueString($_POST['fone1'], "text"),
                       GetSQLValueString($_POST['fone2'], "text"),            
					   GetSQLValueString($_POST['uf'], "text"),
                       
					   GetSQLValueString($_POST['fone'], "text"),
                       GetSQLValueString($_POST['cpf'], "text"),
                       GetSQLValueString($_POST['rg'], "text"),
                       GetSQLValueString($_POST['cnpj'], "text"),
					   GetSQLValueString($_POST['ie'], "text"),
                       
					   GetSQLValueString($_POST['id_vendedor'], "int"),
                       GetSQLValueString($_POST['email'], "text"),
                       GetSQLValueString($_POST['senha'], "text"),
                       GetSQLValueString($_POST['site'], "text"),					   
                       GetSQLValueString($_POST['cpfcnpj'], "text"),
					   
                       GetSQLValueString($_POST['rginscricao'], "text"),
                       GetSQLValueString($_POST['contato'], "text"),
                       GetSQLValueString(datausa($_POST['datanascimento']), "date"),
                       GetSQLValueString($_POST['ativo'], "text"),					   
                       GetSQLValueString($_POST['id_tabela'], "text"),
					   
                       GetSQLValueString($_POST['comissao'], "double"),
					   GetSQLValueString($_POST['comissao2'], "double"),
                       GetSQLValueString($_POST['aberto'], "double"),
                       GetSQLValueString($_POST['observacoes'], "text"),
					   GetSQLValueString($_POST['data_cadastro'], "date"),
					   
                       GetSQLValueString($_POST['id'], "int"));

  mysql_select_db($database_conn, $conn);
  $Result1 = mysql_query($updateSQL, $conn) or die(mysql_error());

  $updateGoTo = "../inicio/principal.php?t=fornecedores";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

mysql_select_db($database_conn, $conn);
$query_seleciona_vendedores = "SELECT * FROM vendedores ORDER BY nome ASC";
$seleciona_vendedores = mysql_query($query_seleciona_vendedores, $conn) or die(mysql_error());
$row_seleciona_vendedores = mysql_fetch_assoc($seleciona_vendedores);
$totalRows_seleciona_vendedores = mysql_num_rows($seleciona_vendedores);

$colname_seleciona_fornecedores = "-1";
if (isset($_GET['id'])) {
  $colname_seleciona_fornecedores = $_GET['id'];
}
mysql_select_db($database_conn, $conn);
$query_seleciona_fornecedores = sprintf("SELECT * FROM fornecedores WHERE id = %s", GetSQLValueString($colname_seleciona_fornecedores, "int"));
$seleciona_fornecedores = mysql_query($query_seleciona_fornecedores, $conn) or die(mysql_error());
$row_seleciona_fornecedores = mysql_fetch_assoc($seleciona_fornecedores);
$totalRows_seleciona_fornecedores = mysql_num_rows($seleciona_fornecedores);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>


<script type="text/javascript" src="../js/jquery-1.2.6.pack.js"></script>
<script type="text/javascript" src="../js/jquery.maskedinput-1.1.4.pack.js"/></script>
<script type="text/javascript">
	$(document).ready(function(){
		
		$("#fone1").mask("(99)9999-9999");
		$("#fone2").mask("(99)9999-9999");
		$("#cep").mask("99999-999");
		$("#datanascimento").mask("99/99/9999");
		$("#cpf").mask("999.999.999-99");
		$("#cnpj").mask("99.999.999/9999-99");
		
	    
	});
</script>


</head>

<body>


<table width="100%"  border="0" align="center" cellpadding="0" cellspacing="2">
    <tr>
      <th width="38"><img src="../imagens/fornecedores.png" width="28" height="28"></th>
      <th width="908" class="Titulo16">ALTERA FORNECEDOR:</th>
      <th width="40" class="Titulo16"><a href="#" onclick="closeMessage()"><img src="../imagens/botao_fechar.png" width="25" height="25" alt="fechar" /></a></th>
    </tr>
</table>
  <hr align="center" width="100%" style="border:0;border-top:1px dashed #CECBBD;height:1px;clear:both">
  <form action="<?php echo $editFormAction; ?>" method="post" name="form1_altfornecedores" id="form1_altfornecedores">
    <table width="100%" align="center">
      <tr valign="baseline">
        <td width="12%" align="right" nowrap="nowrap">ID:</td>
        <td colspan="3"><?php echo $row_seleciona_fornecedores['id']; ?></td>
      </tr>
      <tr valign="baseline">
        <td nowrap="nowrap" align="right">TIPO:</td>
        <td width="20%"><p>
          <label>
            <input <?php if (!(strcmp($row_seleciona_fornecedores['tipo'],"F"))) {echo "checked=\"checked\"";} ?> type="radio" name="tipo" value="F" id="tipo_0" />
            FISICA</label>
          <label>
            <input <?php if (!(strcmp($row_seleciona_fornecedores['tipo'],"J"))) {echo "checked=\"checked\"";} ?> type="radio" name="tipo" value="J" id="tipo_1" />
          JURIDICA</label>
          <br />
        </p></td>
        <td width="3%"> CNPJ:</td>
        <td width="65%"><input type="text" name="cnpj" id="cnpj" value="<?php echo htmlentities($row_seleciona_fornecedores['cnpj'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
      </tr>
      <tr valign="baseline">
        <td nowrap="nowrap" align="right">NOME:</td>
        <td><input type="text" name="nome"  onkeyup="maiuscula(this.value)" value="<?php echo htmlentities($row_seleciona_fornecedores['nome'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
        <td>IE:</td>
        <td><input type="text" name="ie" value="<?php echo htmlentities($row_seleciona_fornecedores['ie'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
      </tr>
      <tr valign="baseline">
        <td nowrap="nowrap" align="right">ENDEREÇO:</td>
        <td><input type="text" name="endereco"  onkeyup="maiuscula(this.value)" value="<?php echo htmlentities($row_seleciona_fornecedores['endereco'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
        <td>VENDEDOR:</td>
        <td><label for="id_vendedor"></label>
          <select name="id_vendedor" id="id_vendedor">
            <option value="" <?php if (!(strcmp("", $row_seleciona_fornecedores['id_vendedor']))) {echo "selected=\"selected\"";} ?>></option>
            <?php
do {  
?>
            <option value="<?php echo $row_seleciona_vendedores['id']?>"<?php if (!(strcmp($row_seleciona_vendedores['id'], $row_seleciona_fornecedores['id_vendedor']))) {echo "selected=\"selected\"";} ?>><?php echo $row_seleciona_vendedores['nome']?></option>
            <?php
} while ($row_seleciona_vendedores = mysql_fetch_assoc($seleciona_vendedores));
  $rows = mysql_num_rows($seleciona_vendedores);
  if($rows > 0) {
      mysql_data_seek($seleciona_vendedores, 0);
	  $row_seleciona_vendedores = mysql_fetch_assoc($seleciona_vendedores);
  }
?>
        </select></td>
      </tr>
      <tr valign="baseline">
        <td nowrap="nowrap" align="right">BAIRRO:</td>
        <td><input type="text" name="bairro"  onkeyup="maiuscula(this.value)" value="<?php echo htmlentities($row_seleciona_fornecedores['bairro'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
        <td>E-MAIL:</td>
        <td><input type="text" name="email"  onkeyup="maiuscula(this.value)" value="<?php echo htmlentities($row_seleciona_fornecedores['email'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
      </tr>
      <tr valign="baseline">
        <td nowrap="nowrap" align="right">CIDADE:</td>
        <td><input type="text" name="cidade"  onkeyup="maiuscula(this.value)" value="<?php echo htmlentities($row_seleciona_fornecedores['cidade'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
        <td>SENHA:</td>
        <td><input type="password" name="senha" value="<?php echo htmlentities($row_seleciona_fornecedores['senha'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
      </tr>
      <tr valign="baseline">
        <td nowrap="nowrap" align="right">COMPLEMENTO:</td>
        <td><input type="text" name="complemento"  onkeyup="maiuscula(this.value)" value="<?php echo htmlentities($row_seleciona_fornecedores['complemento'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
        <td>SITE:</td>
        <td><input type="text" name="site"  onkeyup="maiuscula(this.value)" value="<?php echo htmlentities($row_seleciona_fornecedores['site'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
      </tr>
      <tr valign="baseline">
        <td nowrap="nowrap" align="right">CEP:</td>
        <td><input type="text" name="cep" id="cep" value="<?php echo htmlentities($row_seleciona_fornecedores['cep'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
        <td>CONTATO:</td>
        <td><input type="text" name="contato"  onkeyup="maiuscula(this.value)" value="<?php echo htmlentities($row_seleciona_fornecedores['contato'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
      </tr>
      <tr valign="baseline">
        <td nowrap="nowrap" align="right">FONE1:</td>
        <td><input type="text" name="fone1" id="fone1" value="<?php echo htmlentities($row_seleciona_fornecedores['fone1'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
        <td>DATA NASC.:</td>
        <td><input type="text" name="datanascimento" id="datanascimento" value="<?php echo htmlentities(databrasil($row_seleciona_fornecedores['datanascimento']), ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
      </tr>
      <tr valign="baseline">
        <td nowrap="nowrap" align="right">FONE2:</td>
        <td><input type="text" name="fone2" id="fone2" value="<?php echo htmlentities($row_seleciona_fornecedores['fone2'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
        <td>ATIVO:</td>
        <td><p>
          <label>
            <input <?php if (!(strcmp($row_seleciona_fornecedores['ativo'],"S"))) {echo "checked=\"checked\"";} ?> type="radio" name="ativo" value="S" id="ativo_0" />
            SIM</label>
          <label>
            <input <?php if (!(strcmp($row_seleciona_fornecedores['ativo'],"N"))) {echo "checked=\"checked\"";} ?> type="radio" name="ativo" value="N" id="ativo_1" />
          NÃO</label>
          <br />
        </p></td>
      </tr>
      <tr valign="baseline">
        <td nowrap="nowrap" align="right">&nbsp;</td>
        <td>&nbsp;</td>
        <td>TABELA:</td>
        <td><label for="id_tabela"></label>
          <select name="id_tabela" id="id_tabela">
           
            <option value="C" <?php if (!(strcmp("C", $row_seleciona_fornecedores['id_tabela']))) {echo "selected=\"selected\"";} ?>>CONSUMIDOR</option>
            <option value="O" <?php if (!(strcmp("O", $row_seleciona_fornecedores['id_tabela']))) {echo "selected=\"selected\"";} ?>>COORPORATIVO</option>
             <option value="" <?php if (!(strcmp("", $row_seleciona_fornecedores['id_tabela']))) {echo "selected=\"selected\"";} ?>></option>
        </select></td>
      </tr>
      <tr valign="baseline">
        <td nowrap="nowrap" align="right">UF:</td>
        <td><input name="uf" type="text"  onkeyup="maiuscula(this.value)" value="<?php echo htmlentities($row_seleciona_fornecedores['uf'], ENT_COMPAT, 'utf-8'); ?>" size="5" maxlength="2" /></td>
        <td>COMISSAO:</td>
        <td><input type="text" name="comissao" value="<?php echo htmlentities($row_seleciona_fornecedores['comissao'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
      </tr>
      <tr valign="baseline">
        <td nowrap="nowrap" align="right">CPF:</td>
        <td><input type="text" name="cpf" id="cpf" value="<?php echo htmlentities($row_seleciona_fornecedores['cpf'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
        <td>COMISSAO 2:</td>
        <td><input type="text" name="comissao2"  onkeyup="maiuscula(this.value)" value="<?php echo htmlentities($row_seleciona_fornecedores['comissao2'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
      </tr>
      <tr valign="baseline">
        <td rowspan="2" align="right" nowrap="nowrap">RG:</td>
        <td rowspan="2"><input type="text" name="rg" value="<?php echo htmlentities($row_seleciona_fornecedores['rg'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
        <td>OBSERVAÇÕES:</td>
        <td rowspan="2"><textarea name="observacoes"  onkeyup="maiuscula(this.value)" cols="32"><?php echo htmlentities($row_seleciona_fornecedores['observacoes'], ENT_COMPAT, 'utf-8'); ?></textarea></td>
      </tr>
      <tr valign="baseline">
        <td>&nbsp;</td>
      </tr>
      <tr valign="baseline">
        <td nowrap="nowrap" align="right">&nbsp;</td>
        <td colspan="3"><input type="submit" value="Confirmar" />
        <input type="button" class="btn1" onclick="closeMessage()" value="Cancelar" /></td>
      </tr>
    </table>
    <input type="hidden" name="MM_update" value="form1_altfornecedores" />
    <input type="hidden" name="id" value="<?php echo $row_seleciona_fornecedores['id']; ?>" />
</form>
  
  
<script language='JavaScript' type='text/javascript'>
  document.form1_altfornecedores.nome.focus()
  
</script>
<script>


function maiuscula(valor) {
var campo=document.form1_altfornecedores;
campo.nome.value=campo.nome.value.toUpperCase();
campo.endereco.value=campo.endereco.value.toUpperCase();
campo.bairro.value=campo.bairro.value.toUpperCase();
campo.cidade.value=campo.cidade.value.toUpperCase();
campo.complemento.value=campo.complemento.value.toUpperCase();
campo.uf.value=campo.uf.value.toUpperCase();
campo.email.value=campo.email.value.toLowerCase();
campo.site.value=campo.site.value.toLowerCase();
campo.contato.value=campo.contato.value.toUpperCase();
campo.observacoes.value=campo.obse
