<?php require_once('../Connections/conn.php'); 

include("../funcoes/funcoes.php")?>
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
$query_seleciona_fornecedores = "SELECT * FROM fornecedores ORDER BY nome ASC";
$seleciona_fornecedores = mysql_query($query_seleciona_fornecedores, $conn) or die(mysql_error());
$row_seleciona_fornecedores = mysql_fetch_assoc($seleciona_fornecedores);
$totalRows_seleciona_fornecedores = mysql_num_rows($seleciona_fornecedores);

mysql_select_db($database_conn, $conn);
$query_seleciona_marcas = "SELECT * FROM marcas ORDER BY nome ASC";
$seleciona_marcas = mysql_query($query_seleciona_marcas, $conn) or die(mysql_error());
$row_seleciona_marcas = mysql_fetch_assoc($seleciona_marcas);
$totalRows_seleciona_marcas = mysql_num_rows($seleciona_marcas);

mysql_select_db($database_conn, $conn);
$query_seleciona_grupos = "SELECT * FROM grupos ORDER BY nome ASC";
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


if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1_altprodutos")) {
	
	
	 if (!isset($_FILES['fotonova1']['name']) && $_FILES['fotonova1']['name'] == ""){
	
		$nome_arquivo1 = $_POST['foto1'];	
		
	} else {
	
		$nome_arquivo1 = $_FILES['fotonova1']['name'];
	}
	
	if (!isset($_FILES['fotonova2']['name']) && $_FILES['fotonova2']['name'] == ""){
	
		$nome_arquivo2 = $_POST['foto2'];	
		
	} else {
	
		$nome_arquivo2 = $_FILES['fotonova2']['name'];
	}
		
	
	
	
  $updateSQL = sprintf("UPDATE produtos SET 
   codigo=%s, nome=%s, referencia=%s, codigodebarra =%s, estoque=%s, 
   precovenda=%s,  estoqueminimo =%s, estoquemaximo =%s, 
  precocusto=%s, lucrobruto=%s, id_grupo=%s, id_subgrupo=%s, id_marca=%s, 
  propriedades=%s,  destaque=%s,  observacoes=%s, data_cadastro=%s, foto1='$nome_arquivo1' 
  WHERE id=%s",
                       
					                  
					   GetSQLValueString($_POST['codigo'], "int"),
                       GetSQLValueString($_POST['nome'], "text"),
					   GetSQLValueString($_POST['referencia'], "text"),
					   GetSQLValueString($_POST['codigodebarra'], "text"),
                       GetSQLValueString($_POST['estoque'], "int"),
					   
                       GetSQLValueString($_POST['precovenda'], "text"),
					  
					   GetSQLValueString($_POST['estoqueminimo'], "text"),
					   GetSQLValueString($_POST['estoquemaximo'], "text"),					   
                       GetSQLValueString($_POST['precocusto'], "text"), 
					   
					   GetSQLValueString($_POST['lucrobruto'], "double"),                      
                       GetSQLValueString($_POST['id_grupo'], "int"),
                       GetSQLValueString($_POST['id_subgrupo'], "int"),
                       GetSQLValueString($_POST['id_marca'], "int"),
					   
                       GetSQLValueString($_POST['propriedades'], "text"),
                       GetSQLValueString($_POST['destaque'], "text"),
                       GetSQLValueString($_POST['observacoes'], "text"),
                       GetSQLValueString($_POST['data_cadastro'], "date"),
                       GetSQLValueString($_POST['id'], "int"));
					   
					   
					   // zerar o tempo limite de upload
  	set_time_limit(0);
	//onde a imagem vai ficar
	$diretorio = "../site/fotos_produtos";
	$id_arquivo1 = "fotonova1";
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
  $Result1 = mysql_query($updateSQL, $conn) or die(mysql_error());
  
 
	
	 
	 

  $updateGoTo = "../inicio/principal.php?t=produtos";
  
  
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  

  
  header(sprintf("Location: %s", $updateGoTo));

}

$colname_seleciona_produtos = "-1";
if (isset($_GET['id'])) {
  $colname_seleciona_produtos = $_GET['id'];
}
mysql_select_db($database_conn, $conn);
$query_seleciona_produtos = sprintf("SELECT * FROM produtos WHERE id = %s", GetSQLValueString($colname_seleciona_produtos, "int"));
$seleciona_produtos = mysql_query($query_seleciona_produtos, $conn) or die(mysql_error());
$row_seleciona_produtos = mysql_fetch_assoc($seleciona_produtos);
$totalRows_seleciona_produtos = mysql_num_rows($seleciona_produtos);







//soma todos os destaques
mysql_select_db($database_conn, $conn);
$query_seleciona_produtosdestaques= "SELECT * FROM produtos WHERE destaque = 'S'";
$seleciona_produtosdestaques = mysql_query($query_seleciona_produtosdestaques, $conn) or die(mysql_error());
$row_seleciona_produtosdestaques = mysql_fetch_assoc($seleciona_produtosdestaques);
$totalRows_seleciona_produtosdestaques = mysql_num_rows($seleciona_produtosdestaques);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<style type="text/css">
#form1_altprodutos table tr td #id_tamanho {
	width: 60px;
}
#form1_altprodutos table tr td #id_cor {
	width: 110px;
}
</style>

<script type="text/javascript">

function calcula_lucrobruto()
{
form1_altprodutos.lucrobruto.value = parseFloat((form1_altprodutos.precocusto.value/form1_altprodutos.precovenda.value)*100) ;
}


</script>
</head>

<body>

  <table width="100%"  border="0" align="center" cellpadding="0" cellspacing="2">
    <tr>
      <th><img src="../imagens/produtos.gif" width="28" height="28">ALTERA PRODUTO:</th>
    </tr>
  </table>
<hr align="center" width="100%" style="border:0;border-top:1px dashed #CECBBD;height:1px;clear:both">
<form  action="<?php echo $editFormAction; ?>" name="form1_altprodutos" id="form1_altprodutos" method="post"  enctype="multipart/form-data">
<table width="100%"  border="0" cellpadding="1" cellspacing="2">
  <tr>
    <td width="161">  &nbsp;ID:</td>
    <td width="292"><input name="id" type="text" class="frm1" id="id" style="background:" onFocus="this.className='frm2'" onBlur="this.className='frm1'" onClick="clica('codigo','erro3');" onKeyPress="return formatar(this, '')" value="<?php echo $row_seleciona_produtos['id']?>" size="6" maxlength="5"></td>
    <td width="306">ESTOQUE DEPOSITO:</td>
    <td width="477"><label for="dataultimaatualizacao">
      <input name="estoque" type="text" id="estoque" value="<?php echo $row_seleciona_produtos['estoque'];?>" size="10" />
    </label></td>
  </tr>
  <tr>
    <td>NOME:</td>
    <td><input name="nome" type="text" class="frm1" id="nome" style="background:" onFocus="this.className='frm2'" onBlur="this.className='frm1'" onClick="clica('nome','erro4');" value="<?php echo $row_seleciona_produtos['nome']?>" size="44" maxlength="150"></td>
    <td>ESTOQUE MINIMO:</td>
    <td><input name="estoqueminimo" type="text" id="estoqueminimo" value="<?php echo $row_seleciona_produtos['estoqueminimo'];?>" size="10" /></td>
    
  </tr>
  <tr>
    <td>REFERENCIA:</td>
    <td><input name="referencia" type="text" class="frm1" id="referencia" style="background:" onfocus="this.className='frm2'" onblur="this.className='frm1'" onclick="clica('nome','erro4');" value="<?php echo $row_seleciona_produtos['referencia']?>" size="44" maxlength="150" /></td>
    <td>ESTOQUE MAXIMO:</td>
    <td><input name="estoquemaximo" type="text" id="estoquemaximo" value="<?php echo $row_seleciona_produtos['estoquemaximo'];?>" size="10" /></td>
  </tr>
  <tr>
    <td>CODIGO DE BARRA:</td>
    <td><input name="codigodebarra" type="text" class="frm1" id="codigodebarra" style="background:" onfocus="this.className='frm2'" onblur="this.className='frm1'" onclick="clica('nome','erro4');" value="<?php echo $row_seleciona_produtos['codigodebarra']?>" size="44" maxlength="150" /></td>
    <td>DESTAQUE:</td>
    <td><?php if ($totalRows_seleciona_produtosdestaques < 9) {?>
      <label>
        <input <?php if (!(strcmp($row_seleciona_produtos['destaque'],"S"))) {echo "checked=\"checked\"";} ?> type="radio" name="destaque" value="S" id="destaque" />
        SIM</label>
      <label>
        <input <?php if (!(strcmp($row_seleciona_produtos['destaque'],"N"))) {echo "checked=\"checked\"";} ?> type="radio" name="destaque" value="N" id="destaque" />
        NÃO</label>
      <?php } else { 
	  
	  	echo "JÁ EXISTEM 9 DESTAQUES";
		
		?>
      <?php if($row_seleciona_produtos['destaque']== 'S') {?>
      <input <?php if (!(strcmp($row_seleciona_produtos['destaque'],"S"))) {echo "checked=\"checked\"";} ?> type="hidden" name="destaque" value="S" id="destaque" />
      <?php } else {?>
      <input <?php if (!(strcmp($row_seleciona_produtos['destaque'],"N"))) {echo "checked=\"checked\"";} ?> type="hidden" name="destaque" value="N" id="destaque" />
      <?php } ?>
      <?php }?></td>
  </tr>
  <tr>
    <td>PREÇO DE CUSTO:&nbsp; </td>
    <td><input name="precocusto" type="text" class="frm1" id="precocusto" style="text-align: right; background:"  value="<?php echo $row_seleciona_produtos['precocusto']?>" onblur="calcula_lucrobruto()" size="22" /></td>
    <td>MARCA:</td>
    <td><select name="id_marca" id="id_marca">
      <option value="" <?php if (!(strcmp("", $row_seleciona_produtos['id_marca']))) {echo "selected=\"selected\"";} ?>></option>
      <?php
do {  
?>
      <option value="<?php echo $row_seleciona_marcas['id']?>"<?php if (!(strcmp($row_seleciona_marcas['id'], $row_seleciona_produtos['id_marca']))) {echo "selected=\"selected\"";} ?>><?php echo $row_seleciona_marcas['nome']?></option>
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
    <td>PREÇO DE VENDA:</td>
    <td><input name="precovenda" type="text" class="frm1" id="precovenda" style="text-align: right; background:"  value="<?php echo $row_seleciona_produtos['precovenda']?>" size="22" onblur="calcula_lucrobruto()" /></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>LUCRO BRUTO(%):</td>
    <td><input name="lucrobruto" type="text" class="frm1" id="lucrobruto" style="text-align: right; background:" value="<?php echo $row_seleciona_produtos['lucrobruto']?>"  onClick="calcula_lucrobruto()" size="22" />
      %</td>
    <td><?php 
	echo "<pre>";
	
  	  if(empty($row_seleciona_produtos['foto1'])){
	 		 
			 echo "<img width='30' name='foto1' src='../site/fotos_produtos/sem_foto.jpg' border='0'>";
	 
	  } else {
	  	
		if(!empty($row_seleciona_produtos['foto1'])){
		
			echo "<img width='80' name='foto1' src='../site/fotos_produtos/".$row_seleciona_produtos['foto1']."' border='0'>";
		
		} else {
		
			echo "<img width='80' name='foto1' src='../site/fotos_produtos/sem_foto.jpg' border='0'>";
		echo "</pre>";
		}
	}
	?></td>
    <td>TROCAR FOTO 1 ?:
      <input name="nova_foto[1]" type="radio" value="N" checked="checked" onclick="javascript:DesabilitarFoto1()" />
NÃO
<input name="nova_foto[1]" type="radio" value="S" onclick="javascript: HabilitarFoto1();" />
SIM <br />
<input class="inputon" onchange="document.images.foto1.src=this.value" name="fotonova1" id="fotonova1" type='file' size="16" disabled="disabled" />
<input name="foto1" type="hidden" value="<?php echo $row_seleciona_produtos['foto1']?>" /></td>
  </tr>
  <tr>
    <td>GRUPO:</td>
    <td><select name="id_grupo" id="id_grupo">
      <option value="" <?php if (!(strcmp("", $row_seleciona_produtos['id_grupo']))) {echo "selected=\"selected\"";} ?>></option>
      <?php
do {  
?>
      <option value="<?php echo $row_seleciona_grupos['id']?>"<?php if (!(strcmp($row_seleciona_grupos['id'], $row_seleciona_produtos['id_grupo']))) {echo "selected=\"selected\"";} ?>><?php echo $row_seleciona_grupos['nome']?></option>
      <?php
} while ($row_seleciona_grupos = mysql_fetch_assoc($seleciona_grupos));
  $rows = mysql_num_rows($seleciona_grupos);
  if($rows > 0) {
      mysql_data_seek($seleciona_grupos, 0);
	  $row_seleciona_grupos = mysql_fetch_assoc($seleciona_grupos);
  }
?>
    </select></td>
    <td>DESCONTINUADO:</td>
    <td><label>
      <input <?php if (!(strcmp($row_seleciona_produtos['descontinuado'],"S"))) {echo "checked=\"checked\"";} ?> type="radio" name="descontinuado" value="S" id="descontinuado" />
      SIM</label>
      <label>
        <input <?php if (!(strcmp($row_seleciona_produtos['descontinuado'],"N"))) {echo "checked=\"checked\"";} ?> type="radio" name="descontinuado" value="N" id="descontinuado" />
      NÃO</label></td>
  </tr>
  <tr>
    <td>SUBGRUPO:</td>
    <td><select name="id_subgrupo" id="id_subgrupo">
      <option value="" <?php if (!(strcmp("", $row_seleciona_produtos['id_subgrupo']))) {echo "selected=\"selected\"";} ?>></option>
      <?php
do {  
?>
      <option value="<?php echo $row_seleciona_subgrupos['id']?>"<?php if (!(strcmp($row_seleciona_subgrupos['id'], $row_seleciona_produtos['id_subgrupo']))) {echo "selected=\"selected\"";} ?>><?php echo $row_seleciona_subgrupos['nome']?></option>
      <?php
} while ($row_seleciona_subgrupos = mysql_fetch_assoc($seleciona_subgrupos));
  $rows = mysql_num_rows($seleciona_subgrupos);
  if($rows > 0) {
      mysql_data_seek($seleciona_subgrupos, 0);
	  $row_seleciona_subgrupos = mysql_fetch_assoc($seleciona_subgrupos);
  }
?>
    </select></td>
    <td rowspan="2">&nbsp;OBSERVAÇÕES:</td>
    <td rowspan="2"><textarea name="observacoes" id="observacoes" cols="50" rows="3" class="frm1"><?php echo $row_seleciona_produtos['observacoes']?></textarea></td>
  </tr>
  <tr>
    <td>PROPRIEDADES:</td>
    <td><textarea name="propriedades" id="propriedades" cols="40" rows="3" class="frm1"><?php echo $row_seleciona_produtos['propriedades']?></textarea></td>
  </tr>
 
      </table>
      <table border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td><input name="editar" type="submit" class="btn1" value="CONFIRMAR" id="editar"></td>
          <td>&nbsp;</td>
          <td><input type="button" class="btn1" onclick="closeMessage()" value="CANCELAR"></td>
          </tr>
        </table>
      
      <input type="hidden" name="MM_update" value="form1_altprodutos" />
      <input type="hidden" name="id" value="<?php echo $row_seleciona_produtos['id']; ?>" />
      
      
      <input name="edita" type="hidden" id="edita" value="form1_altprodutos" />
      </td>
    
  </tr>
    </table>
    </td>
    </tr>
</table>
</form>

<script language='JavaScript' type='text/javascript'>
  document.form1_altprodutos.nome.focus()
  
</script>
<script>


function maiuscula(valor) {
var campo=document.form1_altprodutos;
campo.nome.value=campo.nome.value.toUpperCase();
campo.fornecedoratual.value=campo.fornecedoratual.value.toUpperCase();
campo.garantia.value=campo.garantia.value.toUpperCase();
campo.propriedades.value=campo.propriedades.value.toUpperCase();
campo.observacoes.value=campo.observacoes.value.toUpperCase();
}
</script>

</body>
</html>
<?php
mysql_free_result($seleciona_produtos);
?>
