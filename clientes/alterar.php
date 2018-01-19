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

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1_altclientes")) {


    if (!isset($_FILES['fotonova1']['name']) && $_FILES['fotonova1']['name'] == ""){

		$nome_arquivo1 = $_POST['foto'];

	} else {

		$nome_arquivo1 = $_FILES['fotonova1']['name'];
	}



  $updateSQL = sprintf("UPDATE clientes SET tipo=%s, nome=%s,  endereco=%s,numero=%s,
  bairro=%s, cidade=%s, complemento=%s, cep=%s, pais=%s,
  fone1=%s, fone2=%s,  uf=%s, fone=%s, cpf=%s,
  rg=%s,passaporte=%s,  cnpj=%s, ie=%s, id_vendedor=%s,
  email=%s, senha=%s,  site=%s, cpfcnpj=%s, rginscricao=%s,
  contato=%s, datanascimento=%s,  ativo=%s, id_fornecedor=%s, limitedecredito=%s,
  aberto=%s, observacoes=%s, data_cadastro=%s WHERE id=%s",
  
                       GetSQLValueString($_POST['tipo'], "text"),
                       GetSQLValueString($_POST['nome'], "text"),
                      
                       GetSQLValueString($_POST['endereco'], "text"),
                       GetSQLValueString($_POST['numero'], "text"),

                       GetSQLValueString($_POST['bairro'], "text"),
                       GetSQLValueString($_POST['cidade'], "text"),
                       GetSQLValueString($_POST['complemento'], "text"),
                       GetSQLValueString($_POST['cep'], "text"),
					   GetSQLValueString($_POST['pais'], "text"),

                       GetSQLValueString($_POST['fone1'], "text"),
                       GetSQLValueString($_POST['fone2'], "text"),
                       GetSQLValueString($_POST['uf'], "text"),
					   GetSQLValueString($_POST['fone'], "text"),
                       GetSQLValueString($_POST['cpf'], "text"),

                       GetSQLValueString($_POST['rg'], "text"),
					   GetSQLValueString($_POST['passaporte'], "text"),
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
                       GetSQLValueString($_POST['id_fornecedor'], "int"),
                       GetSQLValueString($_POST['limitedecredito'], "double"),

                       GetSQLValueString($_POST['aberto'], "double"),
                       GetSQLValueString($_POST['observacoes'], "text"),
                       GetSQLValueString($_POST['data_cadastro'], "date"),
					   GetSQLValueString($_POST['id'], "int"));

  set_time_limit(0);
	//onde a imagem vai ficar
	$diretorio = "../site/fotos_clientes";
	$id_arquivo1 = "fotonova1";


	$nome_arquivo1 = $_FILES[$id_arquivo1]["name"];



	$arquivo_temporario1 = $_FILES[$id_arquivo1]["tmp_name"];


	move_uploaded_file($arquivo_temporario1, "$diretorio/$nome_arquivo1");
	




  mysql_select_db($database_conn, $conn);
  $Result1 = mysql_query($updateSQL, $conn) or die(mysql_error());

  $updateGoTo = "../inicio/principal.php?t=clientes";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  if(isset($_GET['t']) && ($_GET['t']=='inicial')){
	  $updateGoTo = "../inicio/principal.php";
		header(sprintf("Location: %s", $updateGoTo));  
	  }
  else{
  	header(sprintf("Location: %s", $updateGoTo));
  }
}

mysql_select_db($database_conn, $conn);
$query_seleciona_vendedores = "SELECT * FROM vendedores ORDER BY nome ASC";
$seleciona_vendedores = mysql_query($query_seleciona_vendedores, $conn) or die(mysql_error());
$row_seleciona_vendedores = mysql_fetch_assoc($seleciona_vendedores);
$totalRows_seleciona_vendedores = mysql_num_rows($seleciona_vendedores);

$colname_seleciona_clientes = "-1";
if (isset($_GET['id'])) {
  $colname_seleciona_clientes = $_GET['id'];
}
mysql_select_db($database_conn, $conn);
$query_seleciona_clientes = sprintf("SELECT * FROM clientes WHERE id = %s", GetSQLValueString($colname_seleciona_clientes, "int"));
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


<script type="text/javascript" src="../js/jquery-1.2.6.pack.js"></script>
<script type="text/javascript" src="../js/jquery.maskedinput-1.1.4.pack.js"/></script>
<script type="text/javascript">
	$(document).ready(function(){
		
		
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
      <th width="38"><img src="../imagens/clientes.png" width="28" height="28"></th>
      <th width="908" class="Titulo16">ALTERA CLIENTES:</th>
      <th width="40" class="Titulo16"><a href="#" onclick="closeMessage()"><img src="../imagens/botao_fechar.png" width="25" height="25" alt="fechar" /></a></th>
    </tr>
</table>
  <hr align="center" width="100%" style="border:0;border-top:1px dashed #CECBBD;height:1px;clear:both">
  <form action="<?php echo $editFormAction; ?>" method="post" name="form1_altclientes" id="form1_altclientes">
    <table width="100%" align="center">
      <tr valign="baseline">
        <td width="12%" align="right" nowrap="nowrap">ID:</td>
        <td colspan="3"><?php echo $row_seleciona_clientes['id']; ?></td>
      </tr>
      <tr valign="baseline">
        <td nowrap="nowrap" align="right">TIPO:</td>
        <td width="20%"><p>
          <label>
            <input <?php if (!(strcmp($row_seleciona_clientes['tipo'],"F"))) {echo "checked=\"checked\"";} ?> type="radio" name="tipo" value="F" id="tipo_0" />
            FISICA</label>
          <label>
            <input <?php if (!(strcmp($row_seleciona_clientes['tipo'],"J"))) {echo "checked=\"checked\"";} ?> type="radio" name="tipo" value="J" id="tipo_1" />
          JURIDICA</label>
          <br />
        </p></td>
        <td width="3%"> CNPJ:</td>
        <td width="65%"><input type="text" name="cnpj" id="cnpj" value="<?php echo htmlentities($row_seleciona_clientes['cnpj'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
      </tr>
      <tr valign="baseline">
        <td nowrap="nowrap" align="right">NOME:</td>
        <td><input type="text" name="nome"  onkeyup="maiuscula(this.value)" value="<?php echo htmlentities($row_seleciona_clientes['nome'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
        <td>IE:</td>
        <td><input type="text" name="ie" value="<?php echo htmlentities($row_seleciona_clientes['ie'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
      </tr>
      <tr valign="baseline">
        <td nowrap="nowrap" align="right">ENDEREÇO:</td>
        <td><input type="text" name="endereco"  onkeyup="maiuscula(this.value)" value="<?php echo htmlentities($row_seleciona_clientes['endereco'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>

        
        <td>VENDEDOR:</td>
        <td><label for="id_vendedor"></label>
          <select name="id_vendedor" id="id_vendedor">
            <option value="" <?php if (!(strcmp("", $row_seleciona_clientes['id_vendedor']))) {echo "selected=\"selected\"";} ?>></option>
            <?php
do {  
?>
            <option value="<?php echo $row_seleciona_vendedores['id']?>"<?php if (!(strcmp($row_seleciona_vendedores['id'], $row_seleciona_clientes['id_vendedor']))) {echo "selected=\"selected\"";} ?>><?php echo $row_seleciona_vendedores['nome']?></option>
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
        <td><input type="text" name="bairro"  onkeyup="maiuscula(this.value)" value="<?php echo htmlentities($row_seleciona_clientes['bairro'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
        <td>E-MAIL:</td>
        <td><input type="text" name="email"  onkeyup="maiuscula(this.value)" value="<?php echo htmlentities($row_seleciona_clientes['email'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
      </tr>
      <tr valign="baseline">
        <td nowrap="nowrap" align="right">CIDADE:</td>
        <td><input type="text" name="cidade"  onkeyup="maiuscula(this.value)" value="<?php echo htmlentities($row_seleciona_clientes['cidade'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr valign="baseline">
        <td nowrap="nowrap" align="right">COMPLEMENTO:</td>
        <td><input type="text" name="complemento"  onkeyup="maiuscula(this.value)" value="<?php echo htmlentities($row_seleciona_clientes['complemento'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
        <td>SITE:</td>
        <td><input type="text" name="site"  onkeyup="maiuscula(this.value)" value="<?php echo htmlentities($row_seleciona_clientes['site'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
      </tr>
      <tr valign="baseline">
        <td nowrap="nowrap" align="right">CEP:</td>
        <td><input type="text" name="cep" id="cep" value="<?php echo htmlentities($row_seleciona_clientes['cep'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
        <td>CONTATO:</td>
        <td><input type="text" name="contato"  onkeyup="maiuscula(this.value)" value="<?php echo htmlentities($row_seleciona_clientes['contato'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
      </tr>
      <tr valign="baseline">
        <td nowrap="nowrap" align="right">PAIS:</td>
        <td><input type="text" name="pais" id="pais" value="<?php echo htmlentities($row_seleciona_clientes['pais'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
        <td>DATA NASC.:</td>
        <td><input type="text" name="datanascimento" id="datanascimento" value="<?php echo htmlentities(databrasil($row_seleciona_clientes['datanascimento']), ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
      </tr>
      <tr valign="baseline">
        <td nowrap="nowrap" align="right">FONE1:</td>
        <td><input type="text" name="fone1" id="fone1" value="<?php echo htmlentities($row_seleciona_clientes['fone1'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
        <td>ATIVO:</td>
        <td><p>
          <label>
            <input <?php if (!(strcmp($row_seleciona_clientes['ativo'],"S"))) {echo "checked=\"checked\"";} ?> type="radio" name="ativo" value="S" id="ativo_0" />
            SIM</label>
          <label>
            <input <?php if (!(strcmp($row_seleciona_clientes['ativo'],"N"))) {echo "checked=\"checked\"";} ?> type="radio" name="ativo" value="N" id="ativo_1" />
          NÃO</label>
          <label>
            <input <?php if (!(strcmp($row_seleciona_clientes['ativo'],"M"))) {echo "checked=\"checked\"";} ?> type="radio" name="ativo" value="M" id="ativo_2" />
          NÃO MOSTRAR</label>
          <br />
        </p></td>
      </tr>
      <tr valign="baseline">
        <td nowrap="nowrap" align="right">FONE2:</td>
        <td><input type="text" name="fone2" id="fone2" value="<?php echo htmlentities($row_seleciona_clientes['fone2'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
        <td>FORNECEDOR:</td>
        <td><label for="id_fornecedor"></label>
         <select name="id_fornecedor" id="id_fornecedor">
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
        <td nowrap="nowrap" align="right">UF:</td>
        <td><input name="uf" type="text"  onkeyup="maiuscula(this.value)" value="<?php echo htmlentities($row_seleciona_clientes['uf'], ENT_COMPAT, 'utf-8'); ?>" size="5" maxlength="2" /></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr valign="baseline">
        <td nowrap="nowrap" align="right">CPF:</td>
        <td><input type="text" name="cpf" id="cpf" value="<?php echo htmlentities($row_seleciona_clientes['cpf'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
        <td>ABERTO:</td>
        <td><input type="text" name="aberto"  onkeyup="maiuscula(this.value)" value="<?php echo htmlentities($row_seleciona_clientes['aberto'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
      </tr>
      <tr valign="baseline">
        <td align="right" valign="baseline" nowrap="nowrap">RG:</td>
        <td><input type="text" name="rg" value="<?php echo htmlentities($row_seleciona_clientes['rg'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
        <td valign="baseline">OBSERVAÇÕES:</td>
        <td rowspan="2" valign="baseline"><textarea name="observacoes"  onkeyup="maiuscula(this.value)" cols="32"><?php echo htmlentities($row_seleciona_clientes['observacoes'], ENT_COMPAT, 'utf-8'); ?></textarea></td>
      </tr>
      <tr valign="baseline">
        <td align="right" nowrap="nowrap">PASSAPORTE:</td>
        <td><input name="passaporte" type="text" id="passaporte" value="<?php echo htmlentities($row_seleciona_clientes['passaporte'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
        <td>&nbsp;</td>
      </tr>
      
       <tr> <td>
           </td>
    <td>TROCAR FOTO 1 ?:
<input name="nova_foto[1]" type="radio" value="N" checked="checked" onclick="javascript:DesabilitarFoto1()" />
NÃO
<input name="nova_foto[1]" type="radio" value="S" onclick="javascript: HabilitarFoto1();" />
SIM <br />

<input class="inputon" onchange="document.images.foto.src=this.value" name="fotonova1" id="fotonova1" type='file' size="16"
disabled="disabled" />
<input name="foto" type="hidden" value="<?php echo $row_seleciona_clientes['foto']?>" />

                                                        <tr> <td>
           <?php
	echo "<pre>";



		if(!empty($row_seleciona_clientes['foto'])){

			echo "<img width='80' name='foto' src='../site/fotos_clientes/".$row_seleciona_clientes['foto']."' border='0'>";

		} else {

			echo "<img width='80' name='foto' src='../site/fotos_clientes/sem_foto.jpg' border='0'>";
		echo "</pre>";

	}
	?></td>
    <td>


<input name="foto" type="hidden" value="<?php echo $row_seleciona_clientes['foto']?>" />

<script>
function HabilitarFoto1() {

nForm = document.forms['form1_altclientes'];

if(nForm.elements['nova_foto[1]'].checked = true) {
        nForm.elements['fotonova1'].disabled = false;
		nForm.elements['fotonova1'].className= "input";
 }
}


function DesabilitarFoto1() {
	nForm.elements['fotonova1'].disabled = true;
	nForm.elements['fotonova1'].className = "inputon";

}


</script>


</td>

      </tr>
      
      <tr valign="baseline">
        <td nowrap="nowrap" align="right">&nbsp;</td>
        <td colspan="3"><input type="submit" value="Confirmar" />
        <input type="button" class="btn1" onclick="closeMessage()" value="Cancelar" /></td>
      </tr>


    </table>
    <input type="hidden" name="MM_update" value="form1_altclientes" />
    <input type="hidden" name="id" value="<?php echo $row_seleciona_clientes['id']; ?>" />
</form>
  
  
<script language='JavaScript' type='text/javascript'>
  document.form1_altclientes.nome.focus()
  
</script>
<script>


function maiuscula(valor) {
var campo=document.form1_altclientes;
campo.nome.value=campo.nome.value.toUpperCase();
campo.endereco.value=campo.endereco.value.toUpperCase();
campo.bairro.value=campo.bairro.value.toUpperCase();
campo.cidade.value=campo.cidade.value.toUpperCase();
campo.complemento.value=campo.complemento.value.toUpperCase();
campo.uf.value=campo.uf.value.toUpperCase();
campo.email.value=campo.email.value.toLowerCase();
campo.site.value=campo.site.value.toLowerCase();
campo.contato.value=campo.contato.value.toUpperCase();
campo.observacoes.value=campo.observacoes.value.toUpperCase();

}


</script>
</body>
</html>
<?php
mysql_free_result($seleciona_vendedores);

mysql_free_result($seleciona_clientes);
?>
