<?php require_once('../Connections/conn.php');

include("../funcoes/funcoes.php"); ?>
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

mysql_select_db($database_conn, $conn);
$query_seleciona_marcas = "SELECT * FROM marcas ORDER BY nome";
$seleciona_marcas = mysql_query($query_seleciona_marcas, $conn) or die(mysql_error());
$row_seleciona_marcas = mysql_fetch_assoc($seleciona_marcas);
$totalRows_seleciona_marcas = mysql_num_rows($seleciona_marcas);

mysql_select_db($database_conn, $conn);
$query_seleciona_grupos = "SELECT * FROM grupos ORDER BY nome";
$seleciona_grupos = mysql_query($query_seleciona_grupos, $conn) or die(mysql_error());
$row_seleciona_grupos = mysql_fetch_assoc($seleciona_grupos);
$totalRows_seleciona_grupos = mysql_num_rows($seleciona_grupos);


mysql_select_db($database_conn, $conn);
$query_seleciona_categorias = "SELECT * FROM categorias ORDER BY nome";
$seleciona_categorias = mysql_query($query_seleciona_categorias, $conn) or die(mysql_error());
$row_seleciona_categorias = mysql_fetch_assoc($seleciona_categorias);
$totalRows_seleciona_categorias = mysql_num_rows($seleciona_categorias);
//soma todos os destaques
mysql_select_db($database_conn, $conn);
$query_seleciona_produtosdestaques= "SELECT * FROM produtos 	WHERE destaque = 'S'";
$seleciona_produtosdestaques = mysql_query($query_seleciona_produtosdestaques, $conn) or die(mysql_error());
$row_seleciona_produtosdestaques = mysql_fetch_assoc($seleciona_produtosdestaques);
$totalRows_seleciona_produtosdestaques = mysql_num_rows($seleciona_produtosdestaques);


if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1_cadprodutos")) {
	
	$arquivo1 = $_FILES['foto1'];
	$arquivo2 = $_FILES['foto2'];
	$arquivo3 = $_FILES['foto3'];
	$arquivo4 = $_FILES['foto4'];
	
	$nome_arquivo1 = $arquivo1['name'];
	$nome_arquivo2 = $arquivo2['name'];
	$nome_arquivo3 = $arquivo3['name'];
	$nome_arquivo4 = $arquivo4['name'];
	
	$quantia = mysql_query("SELECT COUNT( * ) FROM produtos");

	if($quantia >= '100'){
			echo "Não é possivel registrar, Limite Ultrapassado";
			break;
	}
	
	
  $insertSQL = sprintf("INSERT INTO produtos (id, nome, precodevenda, precodecusto, tabela2, vendadireta, fornecedoratual, id_grupo, id_categoria, precocompra, customedio, id_marca, propriedades, descontinuado, garantia, destaque, mostraremvendadireta, observacoes, data_cadastro, foto1, foto2, foto3, foto4) VALUES (%s, %s, %s, %s, %s, %s, %s,  %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s,'$nome_arquivo1', '$nome_arquivo2', '$nome_arquivo3', '$nome_arquivo4')",
                       
					   GetSQLValueString($_POST['id'], "int"),                     
                       GetSQLValueString($_POST['nome'], "text"),
                       GetSQLValueString($_POST['precodevenda'], "text"),
                       GetSQLValueString($_POST['precodecusto'], "text"),
                       GetSQLValueString($_POST['tabela2'], "text"),
					   
                       GetSQLValueString($_POST['vendadireta'], "text"),
                       GetSQLValueString($_POST['fornecedoratual'], "text"),
                       GetSQLValueString($_POST['id_grupo'], "int"),
                       GetSQLValueString($_POST['id_categoria'], "int"),
                       GetSQLValueString($_POST['precocompra'], "text"),
                       
					   GetSQLValueString($_POST['customedio'], "text"),
                       GetSQLValueString($_POST['id_marca'], "int"),
                       GetSQLValueString($_POST['propriedades'], "text"),
                       GetSQLValueString($_POST['descontinuado'], "text"),
                       GetSQLValueString($_POST['garantia'], "text"),
                       
					   GetSQLValueString($_POST['destaque'], "text"),
                       GetSQLValueString($_POST['mostraremvendadireta'], "text"),
                       GetSQLValueString($_POST['observacoes'], "text"),
                       GetSQLValueString($_POST['data_cadastro'], "date"),
                       GetSQLValueString($_POST['foto1'], "text"),
                       
					   GetSQLValueString($_POST['foto2'], "text"),
                       GetSQLValueString($_POST['foto3'], "text"),
                       GetSQLValueString($_POST['foto4'], "text"));


// zerar o tempo limite de upload
  	set_time_limit(0);
	//onde a imagem vai ficar
	$diretorio = "../site/fotos_produtos";
	$id_arquivo1 = "foto1";
	$id_arquivo2 = "foto2";
	$id_arquivo3 = "foto3";
	$id_arquivo4 = "foto4";
	
	$nome_arquivo1 = $_FILES[$id_arquivo1]["name"];
	$nome_arquivo2 = $_FILES[$id_arquivo2]["name"];
	$nome_arquivo3 = $_FILES[$id_arquivo3]["name"];
	$nome_arquivo4 = $_FILES[$id_arquivo4]["name"];
	
	
	$arquivo_temporario1 = $_FILES[$id_arquivo1]["tmp_name"];
	$arquivo_temporario2 = $_FILES[$id_arquivo2]["tmp_name"];
	$arquivo_temporario3 = $_FILES[$id_arquivo3]["tmp_name"];
	$arquivo_temporario4 = $_FILES[$id_arquivo4]["tmp_name"];
	
	move_uploaded_file($arquivo_temporario1, "$diretorio/$nome_arquivo1");
	move_uploaded_file($arquivo_temporario2, "$diretorio/$nome_arquivo2");
	move_uploaded_file($arquivo_temporario3, "$diretorio/$nome_arquivo3");
	move_uploaded_file($arquivo_temporario4, "$diretorio/$nome_arquivo4");



  mysql_select_db($database_conn, $conn);
  $Result1 = mysql_query($insertSQL, $conn) or die(mysql_error());

  $insertGoTo = "../inicio/principal.php?pg=produtos";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<body>
<form action="<?php echo $editFormAction; ?>" method="post" enctype="multipart/form-data" name="form1_cadprodutos" id="form1_cadprodutos" onSubmit="return valida_2(this);">
<table width="100%"  border="0" align="center" cellpadding="0" cellspacing="2">
    <tr>
      <td width="30"><img src="../imagens/produtos.gif" width="28" height="28"></td>
      <td class="Titulo16"><strong><em><font color="#666666">CADASTRAR PRODUTO:</font></em></strong></td>
    </tr>
  </table>
<hr align="center" width="100%" style="border:0;border-top:1px dashed #CECBBD;height:1px;clear:both">
<table  border="0" cellpadding="1" cellspacing="2">
  <tr>
    <td width="117" bgcolor="#F0F0F0">&nbsp;NOME:</td>
    <td width="264"><input tabindex="1" name="nome" type="text" class="frm1" onkeyup="maiuscula(this.value)" onClick="clica('nome','erro4');" style="background:" id="nome" onFocus="this.className='frm2'" onBlur="this.className='frm1'" size="44" maxlength="150"></td>
    <td width="67" bgcolor="#F0F0F0"><input name="dataultimaatualizacao" type="hidden" id="dataultimaatualizacao" value="<?php echo date("Y-m-d"); ?>" /></td>
    <td width="270">&nbsp;</td>
  </tr>
  <tr>
    <td bgcolor="#F0F0F0">&nbsp;FORNECEDOR ATUAL:</td>
    <td><input tabindex="2" name="fornecedoratual" onkeyup="maiuscula(this.value)" type="text" class="frm1" onClick="clica('fornecedoratual','erro4');" style="background:" id="fornecedoratual" onFocus="this.className='frm2'" onBlur="this.className='frm1'" size="44" maxlength="150"></td>
    <td bgcolor="#F0F0F0">&nbsp;GARANTIA:</td>
    <td><input tabindex="9" name="garantia" onkeyup="maiuscula(this.value)" type="text" class="frm1" onclick="clica('garantia','erro4');" style="background:" id="garantia" onfocus="this.className='frm2'" onblur="this.className='frm1'" size="44" maxlength="150" /></td>
  </tr>
  <tr>
    <td bgcolor="#F0F0F0">&nbsp;PREÇO DE CUSTO:&nbsp; </td>
    <td><input  tabindex="3" name="precodecusto" type="text" class="frm1" onClick="clica('precodecusto','erro6');" onkeypress="reais(this,event)" onkeydown="backspace(this,event)" style="text-align: right; background:" id="precodecusto" onFocus="this.className='frm2'" onBlur="this.className='frm1'" size="44" maxlength="8"></td>
    <td bgcolor="#F0F0F0">&nbsp;DESTAQUE:</td>
    <td>
    
    <?php if( $totalRows_seleciona_produtosdestaques < 9){?>
    
     <label>
      <input tabindex="10" type="radio" name="destaque" value="S" id="descontinuado" />
      SIM</label>
      <label>
        <input tabindex="11" name="destaque" type="radio" id="descontinuado" value="N" checked="checked" />
      NÃO</label>
      
     <?php } else   {    

      echo "JÁ EXISTEM 9 DESTAQUES";

     ?>

	 <?php }  ?>
      
      </td>
  </tr>
  <tr>
    <td bgcolor="#F0F0F0">&nbsp;CONSUMIDOR(R$):</td>
    <td><input tabindex="4" name="precodevenda" type="text" class="frm1" onclick="clica('precodevenda','erro6');" onkeypress="reais(this,event)" onkeydown="backspace(this,event)" style="text-align: right; background:" id="precodevenda" onfocus="this.className='frm2'" onblur="this.className='frm1'" size="44" maxlength="8" /></td>
    <td bgcolor="#F0F0F0">&nbsp;MOSTRAR EM VENDA DIRETA:</td>
    <td><label>
      <input tabindex="12" type="radio" name="mostraremvendadireta" value="S" id="mostraremvendadireta_0" />
      SIM</label><label><input tabindex="13" name="mostraremvendadireta" type="radio" id="mostraremvendadireta_1" value="N" checked="checked" />
      NÃO</label></td>
  </tr>
  <tr>
    <td bgcolor="#F0F0F0">&nbsp;COORPORATIVO(R$):</td>
    <td><input tabindex="5" name="tabela2" type="text" class="frm1" onclick="clica('tabela2','erro6');" onkeypress="reais(this,event)" onkeydown="backspace(this,event)" style="text-align: right; background:" id="tabela2" onfocus="this.className='frm2'" onblur="this.className='frm1'" size="44" maxlength="8" /></td>
    <td bgcolor="#F0F0F0">&nbsp;MARCA:</td>
    <td><select tabindex="14" name="id_marca" id="id_marca">
      <option value=""></option>
      <?php
do {  
?>
      <option value="<?php echo $row_seleciona_marcas['id']?>"><?php echo $row_seleciona_marcas['nome']?></option>
      <?php
} while ($row_seleciona_marcas = mysql_fetch_assoc($seleciona_marcas));
  $rows = mysql_num_rows($seleciona_marcas);
  if($rows > 0) {
      mysql_data_seek($seleciona_marcas, 0);
	  $row_seleciona_marcas = mysql_fetch_assoc($seleciona_marcas);
  }
?>
    </select></td>
  </tr>
  <tr>
    <td bgcolor="#F0F0F0"> &nbsp;VENDA DIRETA(R$):</td>
    <td><input tabindex="6" name="vendadireta" type="text" class="frm1" onclick="clica('tabela2','erro6');" onkeypress="reais(this,event)" onkeydown="backspace(this,event)" style="text-align: right; background:" id="vendadireta" onfocus="this.className='frm2'" onblur="this.className='frm1'" size="44" maxlength="8" /></td>
    <td bgcolor="#F0F0F0">&nbsp;FOTO 1:</td>
    <td><input tabindex="15" name="foto1" type="file" class="frm1" onclick="clica('foto','erro4');" style="background:" id="foto1" onfocus="this.className='frm2'" onblur="this.className='frm1'" size="30" maxlength="150" /></td>
  </tr>
  <tr>
    <td bgcolor="#F0F0F0">&nbsp;GRUPO:</td>
    <td><p>
      <select tabindex="7" name="id_grupo" id="id_grupo">
        <option value=""></option>
        <?php
do {  
?>
        <option value="<?php echo $row_seleciona_grupos['id']?>"><?php echo $row_seleciona_grupos['nome']?></option>
        <?php
} while ($row_seleciona_grupos = mysql_fetch_assoc($seleciona_grupos));
  $rows = mysql_num_rows($seleciona_grupos);
  if($rows > 0) {
      mysql_data_seek($seleciona_grupos, 0);
	  $row_seleciona_grupos = mysql_fetch_assoc($seleciona_grupos);
  }
?>
      </select>
      <br />
    </p></td>
    <td bgcolor="#F0F0F0">&nbsp;FOTO 2:</td>
    <td><label for="id_marca">
      <input tabindex="16" name="foto2" type="file" class="frm1" onclick="clica('foto2','erro4');" style="background:" id="foto2" onfocus="this.className='frm2'" onblur="this.className='frm1'" size="30" maxlength="150" />
    </label></td>
  </tr>
  <tr>
    <td bgcolor="#F0F0F0">&nbsp;CATEGORIA:</td>
    <td><label for="id_grupo">
      <select tabindex="8" name="id_categoria" id="id_categoria">
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
      </select>
    </label></td>
    <td bgcolor="#F0F0F0">&nbsp;FOTO 3:</td>
    <td><input tabindex="17" name="foto3" type="file" class="frm1" onclick="clica('foto3','erro4');" style="background:" id="foto3" onfocus="this.className='frm2'" onblur="this.className='frm1'" size="30" maxlength="150" /></td>
  </tr>
  <tr>
    <td bgcolor="#F0F0F0">&nbsp;</td>
    <td>&nbsp;</td>
    <td bgcolor="#F0F0F0">&nbsp;FOTO 4:</td>
    <td><input tabindex="18" name="foto4" type="file" class="frm1" onclick="clica('foto4','erro4');" style="background:" id="foto4" onfocus="this.className='frm2'" onblur="this.className='frm1'" size="30" maxlength="150" /></td>
  </tr>
  <tr>
    <td height="8" bgcolor="#F0F0F0">&nbsp;PROPRIEDADES:</td>
    <td height="8"><textarea  tabindex="19" onkeyup="maiuscula(this.value)" name="propriedades" id="propriedades" cols="50" rows="5" class="frm1"></textarea></td>
    <td height="8">&nbsp;OBSERVAÇÕES:</td>
    <td height="8"><textarea tabindex="20"  onkeyup="maiuscula(this.value)" name="observacoes" id="observacoes" cols="50" rows="5" class="frm1"></textarea></td>
  </tr>
  <tr>
    <td height="8" bgcolor="#F0F0F0">&nbsp;</td>
    <td height="8" colspan="3">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="4"><table border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td><input name="adicionar" type="submit" class="btn1" value="Adicionar"></td>
        <td>&nbsp;</td>
        <td><input type="button" class="btn1" onclick="closeMessage()" value="Cancelar" /></td>
      </tr>
    </table>
      <input name="adiciona" type="hidden" id="adiciona" value="form1_cadprodutos" />
      <input type="hidden" name="MM_insert" value="form1_cadprodutos" /></td>
    </tr>
</table>
</form>
<script language='JavaScript' type='text/javascript'>
  document.form1_cadprodutos.nome.focus()
  
</script>
<script>


function maiuscula(valor) {
var campo=document.form1_cadprodutos;
campo.nome.value=campo.nome.value.toUpperCase();
campo.fornecedoratual.value=campo.fornecedoratual.value.toUpperCase();
campo.garantia.value=campo.garantia.value.toUpperCase();
campo.propriedades.value=campo.propriedades.value.toUpperCase();
campo.observacoes.value=campo.observacoes.value.toUpperCase();
}
</script>

</body>
</html>