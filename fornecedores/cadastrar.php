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

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1_cadfornecedores")) {
  $insertSQL = sprintf("INSERT INTO fornecedores (id, tipo, nome, endereco, bairro, cidade, complemento, cep, fone1, fone2,  uf,  cpf, rg, cnpj, ie, id_vendedor, email, senha, site, contato, datanascimento, ativo, id_tabela, comissao, comissao2, aberto, observacoes, data_cadastro) VALUES ( %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['id'], "int"),
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
					   GetSQLValueString($_POST['cpf'], "text"), 
					   GetSQLValueString($_POST['rg'], "text"),					                         
                       GetSQLValueString($_POST['cnpj'], "text"),					   
                       GetSQLValueString($_POST['ie'], "text"),
					   
                       GetSQLValueString($_POST['id_vendedor'], "int"),					   
                       GetSQLValueString($_POST['email'], "text"),
                       GetSQLValueString($_POST['senha'], "text"),
                       GetSQLValueString($_POST['site'], "text"),  					     
                       GetSQLValueString($_POST['contato'], "text"),
					   
                       GetSQLValueString(datausa($_POST['datanascimento']), "date"),					   
                       GetSQLValueString($_POST['ativo'], "text"),
                       GetSQLValueString($_POST['id_tabela'], "int"),
                       GetSQLValueString($_POST['comissao'], "double"),
					   GetSQLValueString($_POST['comissao2'], "double"),
                       GetSQLValueString($_POST['aberto'], "double"),
					   
                       GetSQLValueString($_POST['observacoes'], "text"),					   
                       GetSQLValueString($_POST['data_cadastro'], "date"));

  mysql_select_db($database_conn, $conn);
  $Result1 = mysql_query($insertSQL, $conn) or die(mysql_error());

  $insertGoTo = "../inicio/principal.php?t=fornecedores";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}

mysql_select_db($database_conn, $conn);
$query_seleciona_vendedores = "SELECT * FROM vendedores ORDER BY nome ASC";
$seleciona_vendedores = mysql_query($query_seleciona_vendedores, $conn) or die(mysql_error());
$row_seleciona_vendedores = mysql_fetch_assoc($seleciona_vendedores);
$totalRows_seleciona_vendedores = mysql_num_rows($seleciona_vendedores);
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
      <th width="908" class="Titulo16">CADASTRA FORNECEDOR:</th>
      <th width="40" class="Titulo16"><a href="#" onclick="closeMessage()"><img src="../imagens/botao_fechar.png" width="25" height="25" alt="fechar" /></a></th>
    </tr>
</table>
  <hr align="center" width="100%" style="border:0;border-top:1px dashed #CECBBD;height:1px;clear:both">
  <form action="<?php echo $editFormAction; ?>" method="post" name="form1_cadfornecedores" id="form1_cadfornecedores" >
    <table width="100%" align="center">
      <tr valign="baseline">
        <td width="14%" align="right" nowrap="nowrap">TIPO:</td>
        <td width="22%" valign="baseline"><p>
          <label>
            <input name="tipo" type="radio" id="tipo_0" value="F" checked="checked" />
            Fisica</label>
          <label>
            <input type="radio" name="tipo" value="J" id="tipo_1" />
          Juridica</label>
          <br />
        </p></td>
        <td width="7%" valign="baseline">CNPJ:        </td>
        <td width="57%" valign="baseline"><input type="text" name="cnpj" value="" size="32" id="cnpj" /></td>
      </tr>
      <tr valign="baseline">
        <td nowrap="nowrap" align="right">NOME:</td>
        <td><input type="text" name="nome" value="" size="32" onkeyup="maiuscula(this.value)" /></td>
        <td>IE:</td>
        <td><input type="text" name="ie" value="" size="32" /></td>
      </tr>
      <tr valign="baseline">
        <td nowrap="nowrap" align="right">ENDEREÇO:</td>
        <td><input type="text" name="endereco" value="" size="32"  onkeyup="maiuscula(this.value)"  /></td>
        <td>VENDEDOR:</td>
        <td><label for="id_vendedor"></label>
          <select name="id_vendedor" id="id_vendedor">
            <option value=""></option>
            <?php
do {  
?>
            <option value="<?php echo $row_seleciona_vendedores['id']?>"><?php echo $row_seleciona_vendedores['nome']?></option>
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
        <td><input type="text" name="bairro" value="" size="32"  onkeyup="maiuscula(this.value)"  /></td>
        <td>E-MAIL:</td>
        <td><input type="text" name="email" value="" size="32"  onkeyup="maiuscula(this.value)"  /></td>
      </tr>
      <tr valign="baseline">
        <td nowrap="nowrap" align="right">CIDADE:</td>
        <td><input type="text" name="cidade" value="" size="32"  onkeyup="maiuscula(this.value)"  /></td>
        <td>SENHA:</td>
        <td><input type="password" name="senha" value="" size="32" /></td>
      </tr>
      <tr valign="baseline">
        <td nowrap="nowrap" align="right">COMPLEMENTO:</td>
        <td><input type="text" name="complemento" value="" size="32"  onkeyup="maiuscula(this.value)"  /></td>
        <td>SITE:</td>
        <td><input type="text" name="site" value="" size="32"  onkeyup="maiuscula(this.value)"  /></td>
      </tr>
      <tr valign="baseline">
        <td nowrap="nowrap" align="right">CEP:</td>
        <td><input type="text" name="cep" id="cep" value="" size="32" /></td>
        <td>CONTATO:</td>
        <td><input type="text" name="contato" value="" size="32"  onkeyup="maiuscula(this.value)"  /></td>
      </tr>
      <tr valign="baseline">
        <td nowrap="nowrap" align="right">FONE1:</td>
        <td><input type="text" name="fone1" id="fone1" value="" size="32" /></td>
        <td>DATA NASC.:</td>
        <td><input type="text" name="datanascimento" id="datanascimento" value="" size="32" /></td>
      </tr>
      <tr valign="baseline">
        <td nowrap="nowrap" align="right">FONE2:</td>
        <td><input type="text" name="fone2" id="fone2" value="" size="32" /></td>
        <td>ATIVO:</td>
        <td><p>
          <label>
            <input type="radio" name="ativo" value="S" id="ativo_0" />
            SIM</label>
          <label>
            <input name="ativo" type="radio" id="ativo_1" value="N" checked="checked" />
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
            <option value="" selected="selected"></option>
            <option value="C" >CONSUMIDOR</option>
            <option value="O">COORPORATIVO</option>
        </select></td>
      </tr>
      <tr valign="baseline">
        <td nowrap="nowrap" align="right">UF:</td>
        <td><input type="text" name="uf" value="" size="32"  onkeyup="maiuscula(this.value)"  /></td>
        <td>COMISSAO:</td>
        <td><input type="text" name="comissao" value="" size="32" /></td>
      </tr>
      <tr valign="baseline">
        <td nowrap="nowrap" align="right">CPF:</td>
        <td>
        
        
        
        
       <input type="text" name="cpf" id="cpf" onchange="valida_cpf(this.value)" size="32" /></td>
        <td>COMISSAO 2:</td>
        <td><input type="text" name="comissao2" value="" size="32" /></td>
      </tr>
      <tr valign="baseline">
        <td nowrap="nowrap" align="right"><p>RG:</p></td>
        <td><input type="text" name="rg" value="" size="32" /></td>
        <td>OBSERVAÇÕES:</td>
        <td rowspan="2"><textarea name="observacoes" cols="32"  onkeyup="maiuscula(this.value)" ></textarea></td>
      </tr>
      <tr valign="baseline">
        <td nowrap="nowrap" align="right">&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr valign="baseline">
        <td nowrap="nowrap" align="right">&nbsp;</td>
        <td colspan="3"><input type="hidden" name="data_cadastro" value="" size="32" /></td>
      </tr>
      <tr valign="baseline">
        <td nowrap="nowrap" align="right">&nbsp;</td>
        <td colspan="3"><input type="submit" value="Cadastrar" />
        <input type="button" class="btn1" onclick="closeMessage()" value="Cancelar" /></td>
      </tr>
    </table>
    <input type="hidden" name="MM_insert" value="form1_cadfornecedores" />
</form>

<script language='JavaScript' type='text/javascript'>
  document.form1_cadfornecedores.nome.focus()
  
</script>
<script>


function maiuscula(valor) {
var campo=document.form1_cadfornecedores;
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

<script>

function Verifica_CPF(cpf)
      {
      var numeros, digitos, soma, i, resultado, digitos_iguais;
      digitos_iguais = 1;
      if (cpf.length < 11)
            return false;
      for (i = 0; i < cpf.length - 1; i++)
            if (cpf.charAt(i) != cpf.charAt(i + 1))
                  {
                  digitos_iguais = 0;
                  break;
                  }
      if (!digitos_iguais)
            {
            numeros = cpf.substring(0,9);
            digitos = cpf.substring(9);
            soma = 0;
            for (i = 10; i > 1; i--)
                  soma += numeros.charAt(10 - i) * i;
            resultado = soma % 11 < 2 ? 0 : 11 - soma % 11;
            if (resultado != digitos.charAt(0))
                  return false;
            numeros = cpf.substring(0,10);
            soma = 0;
            for (i = 11; i > 1; i--)
                  soma += numeros.charAt(11 - i) * i;
            resultado = soma % 11 < 2 ? 0 : 11 - soma % 11;
            if (resultado != digitos.charAt(1))
                  return false;
            return true;
            }
      else
            return false;
      }

 

</script>
<script>

function valida_cpf(cpf){
      var numeros, digitos, soma, i, resultado, digitos_iguais;
      digitos_iguais = 1;
      if (cpf.length < 11)
            return false;
      for (i = 0; i < cpf.length - 1; i++)
            if (cpf.charAt(i) != cpf.charAt(i + 1))
                  {
                  digitos_iguais = 0;
                  break;
                  }
      if (!digitos_iguais)
            {
            numeros = cpf.substring(0,9);
            digitos = cpf.substring(9);
            soma = 0;
            for (i = 10; i > 1; i--)
                  soma += numeros.charAt(10 - i) * i;
            resultado = soma % 11 < 2 ? 0 : 11 - soma % 11;
            if (resultado != digitos.charAt(0))
                  return false;
            numeros = cpf.substring(0,10);
            soma = 0;
            for (i = 11; i > 1; i--)
                  soma += numeros.charAt(11 - i) * i;
            resultado = soma % 11 < 2 ? 0 : 11 - soma % 11;
            if (resultado != digitos.charAt(1))
                  return false;
            return true;
            }
      else
            return false;
}
</script>
  
</body>
</html>
