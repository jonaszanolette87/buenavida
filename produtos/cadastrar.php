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
$query_seleciona_fornecedores = "SELECT * FROM fornecedores ORDER BY nome";
$seleciona_fornecedores = mysql_query($query_seleciona_fornecedores, $conn) or die(mysql_error());
$row_seleciona_fornecedores = mysql_fetch_assoc($seleciona_fornecedores);
$totalRows_seleciona_fornecedores = mysql_num_rows($seleciona_fornecedores);

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
$query_seleciona_subgrupos = "SELECT * FROM subgrupos ORDER BY nome ASC";
$seleciona_subgrupos = mysql_query($query_seleciona_subgrupos, $conn) or die(mysql_error());
$row_seleciona_subgrupos = mysql_fetch_assoc($seleciona_subgrupos);
$totalRows_seleciona_subgrupos = mysql_num_rows($seleciona_subgrupos);

mysql_select_db($database_conn, $conn);
$query_seleciona_tamanhos = "SELECT * FROM tamanhos ORDER BY nome";
$seleciona_tamanhos = mysql_query($query_seleciona_tamanhos, $conn) or die(mysql_error());
$row_seleciona_tamanhos = mysql_fetch_assoc($seleciona_tamanhos);
$totalRows_seleciona_tamanhos = mysql_num_rows($seleciona_tamanhos);

mysql_select_db($database_conn, $conn);
$query_seleciona_cores = "SELECT * FROM cores ORDER BY nome";
$seleciona_cores = mysql_query($query_seleciona_cores, $conn) or die(mysql_error());
$row_seleciona_cores = mysql_fetch_assoc($seleciona_cores);
$totalRows_seleciona_cores = mysql_num_rows($seleciona_cores);



//soma todos os destaques
mysql_select_db($database_conn, $conn);
$query_seleciona_produtosdestaques= "SELECT * FROM produtos WHERE destaque = 'S'";
$seleciona_produtosdestaques = mysql_query($query_seleciona_produtosdestaques, $conn) or die(mysql_error());
$row_seleciona_produtosdestaques = mysql_fetch_assoc($seleciona_produtosdestaques);
$totalRows_seleciona_produtosdestaques = mysql_num_rows($seleciona_produtosdestaques);


if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1_cadprodutos")) {
	
	$arquivo1 = $_FILES['foto1'];
	//$arquivo2 = $_FILES['foto2'];
	//$arquivo3 = $_FILES['foto3'];
	//$arquivo4 = $_FILES['foto4'];
	
	$nome_arquivo1 = $arquivo1['name'];
	//$nome_arquivo2 = $arquivo2['name'];
	//$nome_arquivo3 = $arquivo3['name'];
	//$nome_arquivo4 = $arquivo4['name'];
	
	$arquivo1 = $_FILES['imagem1'];	
	$nome_imagem1 = $arquivo1['name'];
	
	$arquivo2 = $_FILES['imagem2'];	
	$nome_imagem2 = $arquivo1['name'];
	
	$arquivo3 = $_FILES['imagem3'];	
	$nome_imagem3 = $arquivo1['name'];
	
	$arquivo4 = $_FILES['imagem4'];	
	$nome_imagem4 = $arquivo1['name'];
	
	$arquivo5 = $_FILES['imagem5'];	
	$nome_imagem5 = $arquivo1['name'];
	
	$arquivo6 = $_FILES['imagem6'];	
	$nome_imagem6 = $arquivo1['name'];
	
	$arquivo7 = $_FILES['imagem7'];	
	$nome_imagem7 = $arquivo1['name'];
	
	$arquivo8 = $_FILES['imagem8'];	
	$nome_imagem8 = $arquivo1['name'];
	
	$arquivo9 = $_FILES['imagem9'];	
	$nome_imagem9 = $arquivo1['name'];
	
	
	$quantia = mysql_query("SELECT COUNT( * ) FROM produtos");

	if($quantia >= '50'){
			echo "Não é possivel registrar, Limite Ultrapassado";
			break;
	}
	
	
  $insertSQL = sprintf("INSERT INTO produtos 
  (id, nome, referencia, codigodebarra, precovenda,
  estoque,  estoqueminimo, estoquemaximo, precocusto,lucrobruto, 
   id_grupo, id_subgrupo, id_marca, propriedades, descontinuado, 
  destaque, observacoes, data_cadastro, foto1) VALUES 
  (%s, %s, %s, %s, %s,  
   %s, %s, %s, %s, %s,%s,
   %s, %s, %s,
   %s, %s,%s,%s,'$nome_arquivo1')",
                       
					   GetSQLValueString($_POST['id'], "int"),                     
                       GetSQLValueString($_POST['nome'], "text"),
                       GetSQLValueString($_POST['referencia'], "text"),                      
					   GetSQLValueString($_POST['codigodebarra'], "text"),                      
					   GetSQLValueString($_POST['precovenda'], "text"),
					   
					   GetSQLValueString($_POST['estoque'], "text"),
					  
					   GetSQLValueString($_POST['estoqueminimo'], "text"),
					   GetSQLValueString($_POST['estoquemaximo'], "text"),
                       GetSQLValueString($_POST['precocusto'], "text"),
					   GetSQLValueString($_POST['lucrobruto'], "double"),
					   
                                              
					   GetSQLValueString($_POST['id_grupo'], "int"),
					   GetSQLValueString($_POST['id_subgrupo'], "int"),
                       GetSQLValueString($_POST['id_marca'], "int"),
                       GetSQLValueString($_POST['propriedades'], "text"),
                       GetSQLValueString($_POST['descontinuado'], "text"),
					   
                       GetSQLValueString($_POST['destaque'], "text"),                       
					   GetSQLValueString($_POST['observacoes'], "text"),
                       GetSQLValueString($_POST['data_cadastro'], "date"),
                       GetSQLValueString($_POST['foto1'], "text"));
	// zerar o tempo limite de upload
  	set_time_limit(0);
	//onde a imagem vai ficar
	$diretorio = "../site/fotos_produtos";
	$id_arquivo1 = "foto1";
	//$id_arquivo2 = "foto2";
	//$id_arquivo3 = "foto3";
	//$id_arquivo4 = "foto4";
	
	$nome_arquivo1 = $_FILES[$id_arquivo1]["name"];
	//$nome_arquivo2 = $_FILES[$id_arquivo2]["name"];
	//$nome_arquivo3 = $_FILES[$id_arquivo3]["name"];
	//$nome_arquivo4 = $_FILES[$id_arquivo4]["name"];
	
	
	$arquivo_temporario1 = $_FILES[$id_arquivo1]["tmp_name"];
	//$arquivo_temporario2 = $_FILES[$id_arquivo2]["tmp_name"];
	//$arquivo_temporario3 = $_FILES[$id_arquivo3]["tmp_name"];
	//$arquivo_temporario4 = $_FILES[$id_arquivo4]["tmp_name"];
	
	move_uploaded_file($arquivo_temporario1, "$diretorio/$nome_arquivo1");
	//move_uploaded_file($arquivo_temporario2, "$diretorio/$nome_arquivo2");
	//move_uploaded_file($arquivo_temporario3, "$diretorio/$nome_arquivo3");
	//move_uploaded_file($arquivo_temporario4, "$diretorio/$nome_arquivo4");				   
	mysql_select_db($database_conn, $conn);
  	$Result1 = mysql_query($insertSQL, $conn) or die(mysql_error());
	//------------------------
	
	$id_produto = mysql_insert_id();
	
  
 
   

  $insertGoTo = "../inicio/principal.php?t=produtos";
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

<style type="text/css">
#form1_cadprodutos table tr td #id_tamanho {
	width: 60px;
}
#form1_cadprodutos table tr td #id_cor {
	width: 110px;
}
</style>

<script type="text/javascript">

function calcula_lucrobruto()
{
form1_cadprodutos.lucrobruto.value = parseFloat(((form1_cadprodutos.precovenda.value - form1_cadprodutos.precocusto.value)*100)/form1_cadprodutos.precovenda.value) ;
}


</script>
</head>

<body>
<form action="<?php echo $editFormAction; ?>" method="post" enctype="multipart/form-data" name="form1_cadprodutos" id="form1_cadprodutos" onSubmit="return valida_2(this);">
<table width="100%"  border="0" align="center" cellpadding="0" cellspacing="2">
    <tr>
      <th><img src="../imagens/produtos.gif" width="28" height="28"> CADASTRAR PRODUTO:</th>
    </tr>
  </table>
<hr align="center" width="100%" style="border:0;border-top:1px dashed #CECBBD;height:1px;clear:both">
<table width="100%"  border="0" cellpadding="1" cellspacing="2">
        <tr>
          <td width="188">&nbsp;NOME:</td>
          <td width="267"><input tabindex="1" name="nome" type="text" class="frm1" onkeyup="maiuscula(this.value)" onclick="clica('nome','erro4');" style="background:" id="nome" onfocus="this.className='frm2'" onblur="this.className='frm1'" size="44" maxlength="150" /></td>
          <td width="178">&nbsp;ESTOQUE DEPOSITO:</td>
          <td width="434"><input name="estoque" type="text" id="estoque2" value="0" size="10" tabindex="10" /></td>
        </tr>
        <tr>
          <td>REFERENCIA:</td>
          <td><label for="refencia2">
            <input tabindex="1" name="referencia" type="text" class="frm1" onkeyup="maiuscula(this.value)" onclick="clica('nome','erro4');" style="background:" id="referencia" onfocus="this.className='frm2'" onblur="this.className='frm1'" size="44" maxlength="150" />
          </label></td>
          <td>&nbsp;ESTOQUE DA FEIRA:</td>
          <td>
            <input name="estoquefeira" type="text" id="estoquefeira" value="0" size="10" tabindex="11" /> 
            ESTOQUE PALMAS
          <input name="estoquepalmas" type="text" id="estoquepalmas" value="0" size="10" tabindex="11" /></td>
        </tr>
        <tr>
          <td>CODIGO DE BARRA:</td>
          <td><input tabindex="1" name="codigodebarra" type="text" class="frm1" onkeyup="maiuscula(this.value)" onclick="clica('nome','erro4');" style="background:" id="codigodebarra" onfocus="this.className='frm2'" onblur="this.className='frm1'" size="44" maxlength="150" /></td>
          <td>&nbsp;ESTOQUE MINIMO:</td>
          <td><input name="estoquecritico" type="text" id="estoquecritico" value="5" size="10" tabindex="12"  /></td>
        </tr>
        <tr>
          <td>PREÇO DE CUSTO:</td>
          <td><input  tabindex="3" name="precocusto" type="text" class="frm1"  size="22" maxlength="8" style="text-align: right; background:" onkeypress="virgula(this.value)"  /></td>
          <td>&nbsp;ESTOQUE MAXIMO:</td>
          <td><input name="estoquemaximo" type="text" id="estoquemaximo" value="20" size="10" tabindex="13" /></td>
        </tr>
        <tr>
          <td>PREÇO DE VENDA:</td>
          <td><input tabindex="4" name="precovenda" type="text" class="frm1"  size="22" maxlength="8" style="text-align: right; background:"  /></td>
          <td>&nbsp;DESTAQUE:</td>
          <td><?php if( $totalRows_seleciona_produtosdestaques < 9){?>
            <label>
              <input tabindex="10" type="radio" name="destaque" value="S" id="destaque" />
              SIM</label>
            <label>
              <input tabindex="11" name="destaque" type="radio" id="destaque" value="N" checked="checked" />
              NÃO</label>
            <?php } else   {    

      echo "JÁ EXISTEM 9 DESTAQUES";

     ?>
          <?php }  ?></td>
        </tr>
        <tr>
          <td>LUCRO BRUTO(%):&nbsp;</td>
          <td><input  tabindex="5" name="lucrobruto" type="text" class="frm1"  size="22" maxlength="8" style="text-align: right; background:"  />
            %</td>
          <td>&nbsp;MARCA:</td>
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
          <td>GRUPO:</td>
          <td><select tabindex="6" name="id_grupo" id="id_grupo">
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
          </select></td>
          <td>&nbsp;FOTO 1:</td>
          <td><input tabindex="15" name="foto1" type="file" class="frm1" onclick="clica('foto','erro4');" style="background:" id="foto1" onfocus="this.className='frm2'" onblur="this.className='frm1'" size="30" maxlength="150" /></td>
        </tr>
        <tr>
          <td>SUBGRUPO:</td>
          <td><select tabindex="8" name="id_subgrupo" id="id_subgrupo">
            <option value=""></option>
            <?php
do {  
?>
            <option value="<?php echo $row_seleciona_subgrupos['id']?>"><?php echo $row_seleciona_subgrupos['nome']?></option>
            <?php
} while ($row_seleciona_subgrupos = mysql_fetch_assoc($seleciona_subgrupos));
  $rows = mysql_num_rows($seleciona_subgrupos);
  if($rows > 0) {
      mysql_data_seek($seleciona_subgrupos, 0);
	  $row_seleciona_subgrupos = mysql_fetch_assoc($seleciona_subgrupos);
  }
?>
          </select></td>
          <td>&nbsp;DESCONTINUADO:</td>
          <td><label>
            <input tabindex="10" type="radio" name="descontinuado" value="S" id="descontinuado" />
            SIM</label>
            <label>
              <input tabindex="11" name="descontinuado" type="radio" id="descontinuado" value="N" checked="checked" />
          NÃO</label></td>
        </tr>
        <tr>
          <td>&nbsp;PROPRIEDADES:
          <input name="dataultimaatualizacao" type="hidden" id="dataultimaatualizacao" value="<?php echo date("Y-m-d"); ?>" /></td>
          <td><textarea  tabindex="9" onkeyup="maiuscula(this.value)" name="propriedades" id="propriedades" cols="40" rows="3" class="frm1"></textarea></td>
          <td>OBSERVAÇÕES:</td>
          <td><textarea tabindex="20"  onkeyup="maiuscula(this.value)" name="observacoes" id="observacoes" cols="50" rows="3" class="frm1"></textarea></td>
        </tr>
      </table>
   
    
    </div>
  </div>
</div>
<table border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><input name="adicionar" type="submit" class="btn1" value="CADASTRAR" /></td>
    <td>&nbsp;</td>
    <td><input type="button" class="btn1" onclick="closeMessage()" value="CANCELAR" /></td>
  </tr>
</table>
<input name="adiciona" type="hidden" id="adiciona" value="form1_cadprodutos" />
<input type="hidden" name="MM_insert" value="form1_cadprodutos" />
<input type="hidden" name="data_cadastro" value="<?php echo date("Y.m.d");?>" />
<p>&nbsp;</p>
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