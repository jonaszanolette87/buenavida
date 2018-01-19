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
$query_seleciona_categorias = "SELECT * FROM categorias ORDER BY nome ASC";
$seleciona_categorias = mysql_query($query_seleciona_categorias, $conn) or die(mysql_error());
$row_seleciona_categorias = mysql_fetch_assoc($seleciona_categorias);
$totalRows_seleciona_categorias = mysql_num_rows($seleciona_categorias);


if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1_altimoveis")) {
	
	
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
		
		
	if (!isset($_FILES['fotonova3']['name']) && $_FILES['fotonova3']['name'] == ""){
	
		$nome_arquivo3 = $_POST['foto3'];	
		
	} else {
	
		$nome_arquivo3 = $_FILES['fotonova3']['name'];
	}
	
	if (!isset($_FILES['fotonova4']['name']) && $_FILES['fotonova4']['name'] == ""){
	
		$nome_arquivo4 = $_POST['foto4'];	
		
	} else {
	
		$nome_arquivo4 = $_FILES['fotonova4']['name'];
	}	
	
	if (!isset($_FILES['fotonova5']['name']) && $_FILES['fotonova5']['name'] == ""){
	
		$nome_arquivo4 = $_POST['foto5'];	
		
	} else {
	
		$nome_arquivo5 = $_FILES['fotonova5']['name'];
	}	
	
	if (!isset($_FILES['fotonova6']['name']) && $_FILES['fotonova6']['name'] == ""){
	
		$nome_arquivo6 = $_POST['foto6'];	
		
	} else {
	
		$nome_arquivo6 = $_FILES['fotonova6']['name'];
	}	
	
	if (!isset($_FILES['fotonova7']['name']) && $_FILES['fotonova7']['name'] == ""){
	
		$nome_arquivo7 = $_POST['foto7'];	
		
	} else {
	
		$nome_arquivo7 = $_FILES['fotonova7']['name'];
	}	
	
	
	if (!isset($_FILES['fotonova8']['name']) && $_FILES['fotonova8']['name'] == ""){
	
		$nome_arquivo8 = $_POST['foto8'];	
		
	} else {
	
		$nome_arquivo8 = $_FILES['fotonova8']['name'];
	}
	
	
	
	if (!isset($_FILES['fotonova9']['name']) && $_FILES['fotonova9']['name'] == ""){
	
		$nome_arquivo9 = $_POST['foto9'];	
		
	} else {
	
		$nome_arquivo9 = $_FILES['fotonova9']['name'];
	}
	
	
	if (!isset($_FILES['fotonova10']['name']) && $_FILES['fotonova10']['name'] == ""){
	
		$nome_arquivo10 = $_POST['foto10'];	
		
	} else {
	
		$nome_arquivo10 = $_FILES['fotonova10']['name'];
	}
	
	
	
	
	
  $updateSQL = sprintf("UPDATE imoveis SET 
  dataultimaatualizacao=%s, codigo=%s, nome=%s, estoque=%s, peso=%s, precodevenda=%s, 
  precodecusto=%s, tabela2=%s, vendadireta=%s, id_fornecedoratual=%s, id_grupo=%s, 
  id_categoria=%s, acabado=%s, precocompra=%s, customedio=%s, id_marca=%s, 
  propriedades=%s, entradafiscal=%s, saidafiscal=%s, garantia=%s, destaque=%s, 
  novidades=%s,promocoes=%s,precopromocao=%s, importacupomfiscal=%s, observacoes=%s,semestoque=%s, data_cadastro=%s, foto1='$nome_arquivo1', foto2='$nome_arquivo2', foto3='$nome_arquivo3', foto4='$nome_arquivo4', foto5='$nome_arquivo5', foto5='$nome_arquivo5', foto6='$nome_arquivo6', foto7='$nome_arquivo7', foto8='$nome_arquivo8', foto9='$nome_arquivo9', foto10='$nome_arquivo10' WHERE id=%s",
                       
					   GetSQLValueString(datausa($_POST['dataultimaatualizacao']), "date"),               
					   GetSQLValueString($_POST['codigo'], "int"),
                       GetSQLValueString($_POST['nome'], "text"),
                       GetSQLValueString($_POST['estoque'], "int"),
					   GetSQLValueString($_POST['peso'], "text"),
                       GetSQLValueString($_POST['precodevenda'], "text"),
					   
                       GetSQLValueString($_POST['precodecusto'], "text"),
                       GetSQLValueString($_POST['tabela2'], "text"),
                       GetSQLValueString($_POST['vendadireta'], "text"),
                       GetSQLValueString($_POST['id_fornecedoratual'], "int"),
                       GetSQLValueString($_POST['id_grupo'], "int"),
					   
                       GetSQLValueString($_POST['id_categoria'], "int"),
                       GetSQLValueString($_POST['acabado'], "text"),
                       GetSQLValueString($_POST['precocompra'], "text"),
                       GetSQLValueString($_POST['customedio'], "text"),
                       GetSQLValueString($_POST['id_marca'], "int"),
					   
                       GetSQLValueString($_POST['propriedades'], "text"),
                       GetSQLValueString($_POST['entradafiscal'], "int"),
                       GetSQLValueString($_POST['saidafiscal'], "int"),
                       GetSQLValueString($_POST['garantia'], "text"),
                       GetSQLValueString($_POST['destaque'], "text"),
					   
					   GetSQLValueString($_POST['novidades'], "text"),
                       GetSQLValueString($_POST['promocoes'], "text"),
					   GetSQLValueString($_POST['precopromocao'], "text"),			   
                       GetSQLValueString($_POST['importacupomfiscal'], "text"),
                       GetSQLValueString($_POST['observacoes'], "text"),
					   GetSQLValueString($_POST['semestoque'], "text"),
					   
                       GetSQLValueString($_POST['data_cadastro'], "date"),
                       
					   
                       GetSQLValueString($_POST['id'], "int"));
					   
					   
					   // zerar o tempo limite de upload
  	set_time_limit(0);
	//onde a imagem vai ficar
	$diretorio = "../site/fotos_imoveis";
	$id_arquivo1 = "fotonova1";
	$id_arquivo2 = "fotonova2";
	$id_arquivo3 = "fotonova3";
	$id_arquivo4 = "fotonova4";
	$id_arquivo5 = "fotonova5";
	$id_arquivo6 = "fotonova6";
	$id_arquivo7 = "fotonova7";
	$id_arquivo8 = "fotonova8";
	$id_arquivo9 = "fotonova9";
	$id_arquivo10 = "fotonova10";
	
	$nome_arquivo1 = $_FILES[$id_arquivo1]["name"];
	$nome_arquivo2 = $_FILES[$id_arquivo2]["name"];
	$nome_arquivo3 = $_FILES[$id_arquivo3]["name"];
	$nome_arquivo4 = $_FILES[$id_arquivo4]["name"];
	$nome_arquivo5 = $_FILES[$id_arquivo5]["name"];
	$nome_arquivo6 = $_FILES[$id_arquivo6]["name"];
	$nome_arquivo7 = $_FILES[$id_arquivo7]["name"];
	$nome_arquivo8 = $_FILES[$id_arquivo8]["name"];
	$nome_arquivo9 = $_FILES[$id_arquivo9]["name"];
	$nome_arquivo10 = $_FILES[$id_arquivo10]["name"];
	
	
	$arquivo_temporario1 = $_FILES[$id_arquivo1]["tmp_name"];
	$arquivo_temporario2 = $_FILES[$id_arquivo2]["tmp_name"];
	$arquivo_temporario3 = $_FILES[$id_arquivo3]["tmp_name"];
	$arquivo_temporario4 = $_FILES[$id_arquivo4]["tmp_name"];
    $arquivo_temporario5 = $_FILES[$id_arquivo5]["tmp_name"];
	$arquivo_temporario6 = $_FILES[$id_arquivo6]["tmp_name"];
	$arquivo_temporario7 = $_FILES[$id_arquivo7]["tmp_name"];
	$arquivo_temporario8 = $_FILES[$id_arquivo8]["tmp_name"];
	$arquivo_temporario9 = $_FILES[$id_arquivo9]["tmp_name"];
	$arquivo_temporario10 = $_FILES[$id_arquivo10]["tmp_name"];
	
	move_uploaded_file($arquivo_temporario1, "$diretorio/$nome_arquivo1");
	move_uploaded_file($arquivo_temporario2, "$diretorio/$nome_arquivo2");
	move_uploaded_file($arquivo_temporario3, "$diretorio/$nome_arquivo3");
	move_uploaded_file($arquivo_temporario4, "$diretorio/$nome_arquivo4");
    move_uploaded_file($arquivo_temporario5, "$diretorio/$nome_arquivo5");
	move_uploaded_file($arquivo_temporario6, "$diretorio/$nome_arquivo6");
	move_uploaded_file($arquivo_temporario7, "$diretorio/$nome_arquivo7");
	move_uploaded_file($arquivo_temporario8, "$diretorio/$nome_arquivo8");
	move_uploaded_file($arquivo_temporario9, "$diretorio/$nome_arquivo9");
	move_uploaded_file($arquivo_temporario10, "$diretorio/$nome_arquivo10");



  mysql_select_db($database_conn, $conn);
  $Result1 = mysql_query($updateSQL, $conn) or die(mysql_error());

  $updateGoTo = "../inicio/principal.php?t=imoveis";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  
   if(isset($_GET['pg']) && ($_GET['pg']=='inicial')){
	  $updateGoTo = "../inicio/principal.php";
		header(sprintf("Location: %s", $updateGoTo));  
	  }
  else{
  
  header(sprintf("Location: %s", $updateGoTo));
  }
}

$colname_seleciona_imoveis = "-1";
if (isset($_GET['id'])) {
  $colname_seleciona_imoveis = $_GET['id'];
}
mysql_select_db($database_conn, $conn);
$query_seleciona_imoveis = sprintf("SELECT * FROM imoveis WHERE id = %s", GetSQLValueString($colname_seleciona_imoveis, "int"));
$seleciona_imoveis = mysql_query($query_seleciona_imoveis, $conn) or die(mysql_error());
$row_seleciona_imoveis = mysql_fetch_assoc($seleciona_imoveis);
$totalRows_seleciona_imoveis = mysql_num_rows($seleciona_imoveis);


//soma todos os destaques
mysql_select_db($database_conn, $conn);
$query_seleciona_imoveisdestaques= "SELECT * FROM imoveis WHERE destaque = 'S'";
$seleciona_imoveisdestaques = mysql_query($query_seleciona_imoveisdestaques, $conn) or die(mysql_error());
$row_seleciona_imoveisdestaques = mysql_fetch_assoc($seleciona_imoveisdestaques);
$totalRows_seleciona_imoveisdestaques = mysql_num_rows($seleciona_imoveisdestaques);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<body>

  <table width="100%"  border="0" align="center" cellpadding="0" cellspacing="2">
    <tr>
      <td width="30"><img src="../imagens/imoveis.gif" width="28" height="28"></td>
      <td class="Titulo16"><strong><em><font color="#666666">ALTERA PRODUTO:</font></em></strong></td>
    </tr>
  </table>
<hr align="center" width="100%" style="border:0;border-top:1px dashed #CECBBD;height:1px;clear:both">
<form  action="<?php echo $editFormAction; ?>" name="form1_altimoveis" id="form1_altimoveis" method="post"  enctype="multipart/form-data">
<table  border="0" cellpadding="1" cellspacing="2">
  <tr>
    <td width="163" bgcolor="#F0F0F0">  &nbsp;CODIGO:</td>
    <td width="379"><input name="id" type="text" class="frm1" id="id" style="background:" onFocus="this.className='frm2'" onBlur="this.className='frm1'" onClick="clica('codigo','erro3');" onKeyPress="return formatar(this, '')" value="<?php echo $row_seleciona_imoveis['id']?>" size="6" maxlength="5"></td>
    <td width="207" bgcolor="#F0F0F0">DT DA ULT.. ATUALIZAÇÃO:</td>
    <td width="349"><label for="dataultima"></label>
      <input name="dataultima" type="text" id="dataultima" value="<?php echo databrasil($row_seleciona_imoveis['dataultimaatualizacao']);?>" readonly="readonly" />
      <input name="dataultimaatualizacao" type="text" class="frm1" id="dataultimaatualizacao" style="background:" onfocus="this.className='frm2'" onblur="this.className='frm1'" onclick="clica('nome','erro4');" value="<?php echo date("d/m/Y")?>" size="20" maxlength="150" readonly="readonly" /></td>
  </tr>
  <tr>
    <td bgcolor="#F0F0F0">NOME:</td>
    <td><input name="nome" type="text" class="frm1" id="nome" style="background:" onFocus="this.className='frm2'" onBlur="this.className='frm1'" onClick="clica('nome','erro4');" value="<?php echo $row_seleciona_imoveis['nome']?>" size="44" maxlength="150"></td>
    <td bgcolor="#F0F0F0">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
   <tr>
    <td bgcolor="#F0F0F0"> CONSUMIDOR (R$):</td>
    <td><input name="precodevenda" type="text"  value="<?php echo $row_seleciona_imoveis['precodevenda']?>" size="44" /></td>
    <td bgcolor="#F0F0F0">DESTAQUE:</td>
    <td>
    <?php if ($totalRows_seleciona_imoveisdestaques < 25) {?>
    
    <label>
      <input <?php if (!(strcmp($row_seleciona_imoveis['destaque'],"S"))) {echo "checked=\"checked\"";} ?> type="radio" name="destaque" value="S" id="destaque" />
      SIM</label>
      <label>
        <input <?php if (!(strcmp($row_seleciona_imoveis['destaque'],"N"))) {echo "checked=\"checked\"";} ?> type="radio" name="destaque" value="N" id="destaque" />
      NÃO</label>
      <?php } else { 
	  
	  	echo "JÁ EXISTEM 24 DESTAQUES";
		
		?>
        
        <?php if($row_seleciona_imoveis['destaque']== 'S') {?>
		 <input <?php if (!(strcmp($row_seleciona_imoveis['destaque'],"S"))) {echo "checked=\"checked\"";} ?> type="hidden" name="destaque" value="S" id="destaque" />
		
        <?php } else {?>
         <input <?php if (!(strcmp($row_seleciona_imoveis['destaque'],"N"))) {echo "checked=\"checked\"";} ?> type="hidden" name="destaque" value="N" id="destaque" />
		
        <?php } ?>
	  
      
	  <?php }?>      </td>
  </tr>
  <tr>
    <td bgcolor="#F0F0F0">&nbsp;</td>
    <td>&nbsp;</td>
    <td bgcolor="#F0F0F0">NOVIDADES:</td>
    <td><label>
      <input <?php if (!(strcmp($row_seleciona_imoveis['novidades'],"S"))) {echo "checked=\"checked\"";} ?> type="radio" name="novidades" value="S" id="novidades_0" />
      SIM </label><label><input name="novidades" <?php if (!(strcmp($row_seleciona_imoveis['novidades'],"N"))) {echo "checked=\"checked\"";} ?> type="radio" id="novidades_1" value="N" />
      NÃO</label></td>
  </tr>
  <tr>
    <td bgcolor="#F0F0F0">&nbsp;</td>
    <td>&nbsp;</td>
    <td bgcolor="#F0F0F0">PROMOÇÕES:</td>
    <td><label>
      <input <?php if (!(strcmp($row_seleciona_imoveis['promocoes'],"S"))) {echo "checked=\"checked\"";} ?> type="radio" name="promocoes" value="S" id="promocoes_2" />
      SIM </label>
      <label>
        <input name="promocoes" <?php if (!(strcmp($row_seleciona_imoveis['promocoes'],"N"))) {echo "checked=\"checked\"";} ?> type="radio" id="promocoes_3" value="N" />
      NÃO</label></td>
  </tr>
  <tr>
    <td bgcolor="#F0F0F0"><?php 
	echo "<pre>";
	
  	  if(empty($row_seleciona_imoveis['foto7'])){
	 		 
			 echo "<img width='80' name='foto7' src='../site/fotos_imoveis/sem_foto.jpg' border='0'>";
	 
	  } else {
	  	
		if(!empty($row_seleciona_imoveis['foto7'])){
		
			echo "<img width='80' name='foto1' src='../site/fotos_imoveis/".$row_seleciona_imoveis['foto7']."' border='0'>";
		
		} else {
		
			echo "<img width='80' name='foto7' src='../site/fotos_imoveis/sem_foto.jpg' border='0'>";
		echo "</pre>";
		}
	}
	?></td>
    <td><?php 
	echo "<pre>";
	
  	  if(empty($row_seleciona_imoveis['foto8'])){
	 		 
			 echo "<img width='80' name='foto8' src='../site/fotos_imoveis/sem_foto.jpg' border='0'>";
	 
	  } else {
	  	
		if(!empty($row_seleciona_imoveis['foto8'])){
		
			echo "<img width='80' name='foto8' src='../site/fotos_imoveis/".$row_seleciona_imoveis['foto8']."' border='0'>";
		
		} else {
		
			echo "<img width='80' name='foto8' src='../site/fotos_imoveis/sem_foto.jpg' border='0'>";
		echo "</pre>";
		}
	}
	?></td>
    <td bgcolor="#F0F0F0"><?php 
	echo "<pre>";
	
  	  if(empty($row_seleciona_imoveis['foto1'])){
	 		 
			 echo "<img width='80' name='foto1' src='../site/fotos_imoveis/sem_foto.jpg' border='0'>";
	 
	  } else {
	  	
		if(!empty($row_seleciona_imoveis['foto1'])){
		
			echo "<img width='80' name='foto1' src='../site/fotos_imoveis/".$row_seleciona_imoveis['foto1']."' border='0'>";
		
		} else {
		
			echo "<img width='80' name='foto1' src='../site/fotos_imoveis/sem_foto.jpg' border='0'>";
		echo "</pre>";
		}
	}
	?></td>
    <td><?php 
	echo "<pre>";
	
  	  if(empty($row_seleciona_imoveis['foto2'])){
	 		 
			 echo "<img width='80' name='foto2' src='../site/fotos_imoveis/sem_foto.jpg' border='0'>";
	 
	  } else {
	  	
		if(!empty($row_seleciona_imoveis['foto2'])){
		
			echo "<img width='80' name='foto2' src='../site/fotos_imoveis/".$row_seleciona_imoveis['foto2']."' border='0'>";
		
		} else {
		
			echo "<img width='80' name='foto2' src='../site/fotos_imoveis/sem_foto.jpg' border='0'>";
		echo "</pre>";
		}
	}
	?></td>
  </tr>
  <tr>
    <td bgcolor="#F0F0F0">TROCAR FOTO 7 ?:
      <input name="nova_foto[7]" type="radio" value="N" checked="checked" onclick="javascript:DesabilitarFoto7()" />
NÃO
<input name="nova_foto[7]" type="radio" value="S" onclick="javascript: HabilitarFoto7();" />
SIM <br />
<input class="inputon" onchange="document.images.foto7.src=this.value" name="fotonova7" id="fotonova7" type='file' size="16" disabled="disabled" />
<input name="foto7" type="hidden" value="<?php echo $row_seleciona_imoveis['foto7']?>" />
<script>
function HabilitarFoto7() {

nForm = document.forms['form1_altimoveis'];

if(nForm.elements['nova_foto[7]'].checked = true) {
        nForm.elements['fotonova7'].disabled = false;
		nForm.elements['fotonova7'].className= "input";
 }
}


function DesabilitarFoto7() {
	nForm.elements['fotonova7'].disabled = true;
	nForm.elements['fotonova7'].className = "inputon";

}


</script></td>
    <td>TROCAR FOTO 8 ?:
      <input name="nova_foto[8]" type="radio" value="N" checked="checked" onclick="javascript:DesabilitarFoto8()" />
NÃO
<input name="nova_foto[8]" type="radio" value="S" onclick="javascript: HabilitarFoto8();" />
SIM <br />
<input class="inputon" onchange="document.images.foto8.src=this.value" name="fotonova8" id="fotonova8" type='file' size="16" disabled="disabled" />
<input name="foto8" type="hidden" value="<?php echo $row_seleciona_imoveis['foto8']?>" />
<script>
function HabilitarFoto8() {

nForm = document.forms['form1_altimoveis'];

if(nForm.elements['nova_foto[8]'].checked = true) {
        nForm.elements['fotonova8'].disabled = false;
		nForm.elements['fotonova8'].className= "input";
 }
}


function DesabilitarFoto8() {
	nForm.elements['fotonova8'].disabled = true;
	nForm.elements['fotonova8'].className = "inputon";

}


</script></td>
    <td bgcolor="#F0F0F0">TROCAR FOTO 1 ?:
      <input name="nova_foto[1]" type="radio" value="N" checked="checked" onclick="javascript:DesabilitarFoto1()" />
NÃO
<input name="nova_foto[1]" type="radio" value="S" onclick="javascript: HabilitarFoto1();" />
SIM <br />
<input class="inputon" onchange="document.images.foto1.src=this.value" name="fotonova1" id="fotonova1" type='file' size="16" disabled="disabled" />
<input name="foto1" type="hidden" value="<?php echo $row_seleciona_imoveis['foto1']?>" />
<script>
function HabilitarFoto1() {

nForm = document.forms['form1_altimoveis'];

if(nForm.elements['nova_foto[1]'].checked = true) {
        nForm.elements['fotonova1'].disabled = false;
		nForm.elements['fotonova1'].className= "input";
 }
}


function DesabilitarFoto1() {
	nForm.elements['fotonova1'].disabled = true;
	nForm.elements['fotonova1'].className = "inputon";

}


</script></td>
    <td>TROCAR FOTO 2 ?:
      <input name="nova_foto[2]" type="radio" value="N" checked="checked" onclick="javascript:DesabilitarFoto2()" />
NÃO
<input name="nova_foto[2]" type="radio" value="S" onclick="javascript: HabilitarFoto2();" />
SIM <br />
<input class="inputon" onchange="document.images.foto2.src=this.value" name="fotonova2" id="fotonova2" type='file' size="16" disabled="disabled" />
<input name="foto2" type="hidden" value="<?php echo $row_seleciona_imoveis['foto2']?>" />
<script>
function HabilitarFoto2() {

nForm = document.forms['form1_altimoveis'];

if(nForm.elements['nova_foto[2]'].checked = true) {
        nForm.elements['fotonova2'].disabled = false;
		nForm.elements['fotonova2'].className= "input";
 }
}


function DesabilitarFoto2() {
	nForm.elements['fotonova2'].disabled = true;
	nForm.elements['fotonova2'].className = "inputon";

}


</script></td>
  </tr>
  <tr>
    <td bgcolor="#F0F0F0"><?php 
	echo "<pre>";
	
  	  if(empty($row_seleciona_imoveis['foto9'])){
	 		 
			 echo "<img width='80' name='foto9' src='../site/fotos_imoveis/sem_foto.jpg' border='0'>";
	 
	  } else {
	  	
		if(!empty($row_seleciona_imoveis['foto9'])){
		
			echo "<img width='80' name='foto9' src='../site/fotos_imoveis/".$row_seleciona_imoveis['foto9']."' border='0'>";
		
		} else {
		
			echo "<img width='80' name='foto9' src='../site/fotos_imoveis/sem_foto.jpg' border='0'>";
		echo "</pre>";
		}
	}
	?></td>
    <td><?php 
	echo "<pre>";
	
  	  if(empty($row_seleciona_imoveis['foto10'])){
	 		 
			 echo "<img width='80' name='foto10' src='../site/fotos_imoveis/sem_foto.jpg' border='0'>";
	 
	  } else {
	  	
		if(!empty($row_seleciona_imoveis['foto10'])){
		
			echo "<img width='80' name='foto10' src='../site/fotos_imoveis/".$row_seleciona_imoveis['foto7']."' border='0'>";
		
		} else {
		
			echo "<img width='80' name='foto10' src='../site/fotos_imoveis/sem_foto.jpg' border='0'>";
		echo "</pre>";
		}
	}
	?></td>
    <td bgcolor="#F0F0F0"><?php 
	echo "<pre>";
	
  	  if(empty($row_seleciona_imoveis['foto3'])){
	 		 
			 echo "<img width='80' name='foto3' src='../site/fotos_imoveis/sem_foto.jpg' border='0'>";
	 
	  } else {
	  	
		if(!empty($row_seleciona_imoveis['foto3'])){
		
			echo "<img width='80' name='foto3' src='../site/fotos_imoveis/".$row_seleciona_imoveis['foto3']."' border='0'>";
		
		} else {
		
			echo "<img width='80' name='foto3' src='../site/fotos_imoveis/sem_foto.jpg' border='0'>";
		echo "</pre>";
		}
	}
	?></td>
    <td><?php 
	echo "<pre>";
	
  	  if(empty($row_seleciona_imoveis['foto4'])){
	 		 
			 echo "<img width='80' name='foto4' src='../site/fotos_imoveis/sem_foto.jpg' border='0'>";
	 
	  } else {
	  	
		if(!empty($row_seleciona_imoveis['foto4'])){
		
			echo "<img width='80' name='foto1' src='../site/fotos_imoveis/".$row_seleciona_imoveis['foto4']."' border='0'>";
		
		} else {
		
			echo "<img width='80' name='foto4' src='../site/fotos_imoveis/sem_foto.jpg' border='0'>";
		echo "</pre>";
		}
	}
	?></td>
  </tr>
  <tr>
    <td bgcolor="#F0F0F0">TROCAR FOTO 9 ?:
      <input name="nova_foto[9]" type="radio" value="N" checked="checked" onclick="javascript:DesabilitarFoto9()" />
NÃO
<input name="nova_foto[9]" type="radio" value="S" onclick="javascript: HabilitarFoto9();" />
SIM <br />
<input class="inputon" onchange="document.images.foto9.src=this.value" name="fotonova9" id="fotonova9" type='file' size="16" disabled="disabled" />
<input name="foto9" type="hidden" value="<?php echo $row_seleciona_imoveis['foto9']?>" />
<script>
function HabilitarFoto9() {

nForm = document.forms['form1_altimoveis'];

if(nForm.elements['nova_foto[9]'].checked = true) {
        nForm.elements['fotonova9'].disabled = false;
		nForm.elements['fotonova9'].className= "input";
 }
}


function DesabilitarFoto10() {
	nForm.elements['fotonova10'].disabled = true;
	nForm.elements['fotonova10'].className = "inputon";

}


</script></td>
    <td>TROCAR FOTO 10 ?:
      <input name="nova_foto[10]" type="radio" value="N" checked="checked" onclick="javascript:DesabilitarFoto10()" />
NÃO
<input name="nova_foto[10]" type="radio" value="S" onclick="javascript: HabilitarFoto10();" />
SIM <br />
<input class="inputon" onchange="document.images.foto10.src=this.value" name="fotonova10" id="fotonova10" type='file' size="16" disabled="disabled" />
<input name="foto10" type="hidden" value="<?php echo $row_seleciona_imoveis['foto10']?>" />
<script>
function HabilitarFoto10() {

nForm = document.forms['form1_altimoveis'];

if(nForm.elements['nova_foto[10]'].checked = true) {
        nForm.elements['fotonova10'].disabled = false;
		nForm.elements['fotonova10'].className= "input";
 }
}


function DesabilitarFoto10() {
	nForm.elements['fotonova10'].disabled = true;
	nForm.elements['fotonova10'].className = "inputon";

}


</script></td>
    <td bgcolor="#F0F0F0">TROCAR FOTO 3 ?:
      <input name="nova_foto[3]" type="radio" value="N" checked="checked" onclick="javascript:DesabilitarFoto3()" />
NÃO
<input name="nova_foto[3]" type="radio" value="S" onclick="javascript: HabilitarFoto3();" />
SIM <br />
<input class="inputon" onchange="document.images.foto3.src=this.value" name="fotonova3" id="fotonova3" type='file' size="16" disabled="disabled" />
<input name="foto3" type="hidden" value="<?php echo $row_seleciona_imoveis['foto3']?>" />
<script>
function HabilitarFoto3() {

nForm = document.forms['form1_altimoveis'];

if(nForm.elements['nova_foto[3]'].checked = true) {
        nForm.elements['fotonova3'].disabled = false;
		nForm.elements['fotonova3'].className= "input";
 }
}


function DesabilitarFoto3() {
	nForm.elements['fotonova3'].disabled = true;
	nForm.elements['fotonova3'].className = "inputon";

}


</script></td>
    <td>TROCAR FOTO 4 ?:
      <input name="nova_foto[4]" type="radio" value="N" checked="checked" onclick="javascript:DesabilitarFoto4()" />
NÃO
<input name="nova_foto[4]" type="radio" value="S" onclick="javascript: HabilitarFoto4();" />
SIM <br />
<input class="inputon" onchange="document.images.foto4.src=this.value" name="fotonova4" id="fotonova4" type='file' size="16" disabled="disabled" />
<input name="foto4" type="hidden" value="<?php echo $row_seleciona_imoveis['foto4']?>" /></td>
  </tr>
  <tr>
    <td rowspan="2" bgcolor="#F0F0F0">PROPRIEDADES:</td>
    <td rowspan="2"><textarea name="propriedades" id="propriedades" cols="50" rows="5" class="frm1"><?php echo $row_seleciona_imoveis['propriedades']?></textarea></td>
    <td bgcolor="#F0F0F0"><?php 
	echo "<pre>";
	
  	  if(empty($row_seleciona_imoveis['foto5'])){
	 		 
			 echo "<img width='80' name='foto5' src='../site/fotos_imoveis/sem_foto.jpg' border='0'>";
	 
	  } else {
	  	
		if(!empty($row_seleciona_imoveis['foto5'])){
		
			echo "<img width='80' name='foto5' src='../site/fotos_imoveis/".$row_seleciona_imoveis['foto5']."' border='0'>";
		
		} else {
		
			echo "<img width='80' name='foto5' src='../site/fotos_imoveis/sem_foto.jpg' border='0'>";
		echo "</pre>";
		}
	}
	?></td>
    <td><script>
function HabilitarFoto4() {

nForm = document.forms['form1_altimoveis'];

if(nForm.elements['nova_foto[4]'].checked = true) {
        nForm.elements['fotonova4'].disabled = false;
		nForm.elements['fotonova4'].className= "input";
 }
}


function DesabilitarFoto4() {
	nForm.elements['fotonova4'].disabled = true;
	nForm.elements['fotonova4'].className = "inputon";

}


</script>
  <?php 
	echo "<pre>";
	
  	  if(empty($row_seleciona_imoveis['foto6'])){
	 		 
			 echo "<img width='80' name='foto6' src='../site/fotos_imoveis/sem_foto.jpg' border='0'>";
	 
	  } else {
	  	
		if(!empty($row_seleciona_imoveis['foto6'])){
		
			echo "<img width='80' name='foto6' src='../site/fotos_imoveis/".$row_seleciona_imoveis['foto6']."' border='0'>";
		
		} else {
		
			echo "<img width='80' name='foto6' src='../site/fotos_imoveis/sem_foto.jpg' border='0'>";
		echo "</pre>";
		}
	}
	?></td>
  </tr>
  <tr>
    <td bgcolor="#F0F0F0">TROCAR FOTO 5 ?:
      <input name="nova_foto[5]" type="radio" value="N" checked="checked" onclick="javascript:DesabilitarFoto5()" />
NÃO
<input name="nova_foto[5]" type="radio" value="S" onclick="javascript: HabilitarFoto5();" />
SIM <br />
<input class="inputon" onchange="document.images.foto5.src=this.value" name="fotonova5" id="fotonova5" type='file' size="16" disabled="disabled" />
<input name="foto5" type="hidden" value="<?php echo $row_seleciona_imoveis['foto5']?>" />
<script>
function HabilitarFoto5() {

nForm = document.forms['form1_altimoveis'];

if(nForm.elements['nova_foto[5]'].checked = true) {
        nForm.elements['fotonova5'].disabled = false;
		nForm.elements['fotonova5'].className= "input";
 }
}


function DesabilitarFoto5() {
	nForm.elements['fotonova5'].disabled = true;
	nForm.elements['fotonova5'].className = "inputon";

}


</script></td>
    <td>TROCAR FOTO 6 ?:
      <input name="nova_foto[6]" type="radio" value="N" checked="checked" onclick="javascript:DesabilitarFoto6()" />
NÃO
<input name="nova_foto[6]" type="radio" value="S" onclick="javascript: HabilitarFoto6();" />
SIM <br />
<input class="inputon" onchange="document.images.foto6.src=this.value" name="fotonova6" id="fotonova6" type='file' size="16" disabled="disabled" />
<input name="foto6" type="hidden" value="<?php echo $row_seleciona_imoveis['foto6']?>" />
<script>
function HabilitarFoto6() {

nForm = document.forms['form1_altimoveis'];

if(nForm.elements['nova_foto[6]'].checked = true) {
        nForm.elements['fotonova6'].disabled = false;
		nForm.elements['fotonova6'].className= "input";
 }
}


function DesabilitarFoto6() {
	nForm.elements['fotonova6'].disabled = true;
	nForm.elements['fotonova6'].className = "inputon";

}


</script></td>
  </tr>
  <tr>
    <td bgcolor="#F0F0F0">&nbsp;</td>
    <td>&nbsp;</td>
    <td bgcolor="#F0F0F0">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="4">
      <table border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td><input name="editar" type="submit" class="btn1" value="Editar" id="editar"></td>
          <td>&nbsp;</td>
          <td><input type="button" class="btn1" onclick="closeMessage()" value="Cancelar"></td>
          </tr>
        </table>
      
      <input type="hidden" name="MM_update" value="form1_altimoveis" />
      <input type="hidden" name="id" value="<?php echo $row_seleciona_imoveis['id']; ?>" />
      
      
      <input name="edita" type="hidden" id="edita" value="form1_altimoveis" />      </td>
  </tr>
    </table>
</td>
    </tr>
</table>
</form>

<script language='JavaScript' type='text/javascript'>
  document.form1_altimoveis.nome.focus()
  
</script>
<script>


function maiuscula(valor) {
var campo=document.form1_altimoveis;
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
mysql_free_result($seleciona_imoveis);
?>
