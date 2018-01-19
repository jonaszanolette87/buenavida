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


if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1_altprodutos")) {
	
	
	 if ( $_FILES['fotonova1']['name'] == ""){
	
		$nome_arquivo1 = $_POST['foto1'];	
		
	} else {
	
		$nome_arquivo1 = $_FILES['fotonova1']['name'];
	}
		
	
	if ($_FILES['fotonova2']['name'] == ""){
	
		$nome_arquivo2 = $_POST['foto2'];
	
	} else {
	
		echo	"existe".$nome_arquivo2 ;
		$nome_arquivo2 = $_FILES['fotonova2']['name'];
	}
		
	if ( $_FILES['fotonova3']['name'] == ""){
		$nome_arquivo3 = $_POST['foto3'];
	} else {
		
		$nome_arquivo3 =$_FILES['fotonova3']['name'];
		}
		
	if ( $_FILES['fotonova4']['name'] == ""){
		$nome_arquivo4 = $_POST['foto4'];
	} else {
		
		$nome_arquivo4 =$_FILES['fotonova4']['name'];
	}
	
	
	
  $updateSQL = sprintf("UPDATE produtos SET dataultimaatualizacao=%s, codigo=%s, nome=%s, estoque=%s, precodevenda=%s, precodecusto=%s, tabela2=%s, vendadireta=%s, fornecedoratual=%s, id_grupo=%s, id_categoria=%s, acabado=%s, precocompra=%s, customedio=%s, id_marca=%s, propriedades=%s, entradafiscal=%s, saidafiscal=%s, garantia=%s, destaque=%s, mostraremvendadireta=%s, importacupomfiscal=%s, observacoes=%s, data_cadastro=%s, foto1='$nome_arquivo1', foto2='$nome_arquivo2', foto3='$nome_arquivo3', foto4='$nome_arquivo4' WHERE id=%s",
                       GetSQLValueString(datausa($_POST['dataultimaatualizacao']), "date"),
                       GetSQLValueString($_POST['codigo'], "int"),
                       GetSQLValueString($_POST['nome'], "text"),
                       GetSQLValueString($_POST['estoque'], "int"),
                       GetSQLValueString($_POST['precodevenda'], "text"),
					   
                       GetSQLValueString($_POST['precodecusto'], "text"),
                       GetSQLValueString($_POST['tabela2'], "text"),
                       GetSQLValueString($_POST['vendadireta'], "text"),
                       GetSQLValueString($_POST['fornecedoratual'], "text"),
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
					   
                       GetSQLValueString($_POST['mostraremvendadireta'], "text"),
                       GetSQLValueString($_POST['importacupomfiscal'], "text"),
                       GetSQLValueString($_POST['observacoes'], "text"),
                       GetSQLValueString($_POST['data_cadastro'], "date"),
                     //  GetSQLValueString($_POST['fotonova1'], "text"),
					   
                     //  GetSQLValueString($_POST['fotonova2'], "text"),
                      // GetSQLValueString($_POST['fotonova3'], "text"),
                    //   GetSQLValueString($_POST['fotonova4'], "text"),
                       GetSQLValueString($_POST['id'], "int"));

  mysql_select_db($database_conn, $conn);
  $Result1 = mysql_query($updateSQL, $conn) or die(mysql_error());

  $updateGoTo = "../inicio/principal.php?pg=produtos";
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
$query_seleciona_produtosdestaques= "SELECT * FROM produtos 	WHERE destaque = 'S'";
$seleciona_produtosdestaques = mysql_query($query_seleciona_produtosdestaques, $conn) or die(mysql_error());
$row_seleciona_produtosdestaques = mysql_fetch_assoc($seleciona_produtosdestaques);
$totalRows_seleciona_produtosdestaques = mysql_num_rows($seleciona_produtosdestaques);

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
      <td width="30"><img src="../imagens/produtos.gif" width="28" height="28"></td>
      <td class="Titulo16"><strong><em><font color="#666666">ALTERA PRODUTO:</font></em></strong></td>
    </tr>
  </table>
<hr align="center" width="100%" style="border:0;border-top:1px dashed #CECBBD;height:1px;clear:both">
<form  action="<?php echo $editFormAction; ?>" name="form1_altprodutos" id="form1_altprodutos" method="post"  enctype="multipart/form-data">
<table  border="0" cellpadding="1" cellspacing="2">
  <tr>
    <td width="111" bgcolor="#F0F0F0">  &nbsp;CODIGO:</td>
    <td width="264"><input name="id" type="text" class="frm1" id="id" style="background:" onFocus="this.className='frm2'" onBlur="this.className='frm1'" onClick="clica('codigo','erro3');" onKeyPress="return formatar(this, '')" value="<?php echo $row_seleciona_produtos['id']?>" size="6" maxlength="5"></td>
    <td width="129" bgcolor="#F0F0F0">DT DA ULT.. ATUALIZAÇÃO:</td>
    <td width="443"><label for="dataultima"></label>
      <input name="dataultima" type="text" id="dataultima" value="<?php echo databrasil($row_seleciona_produtos['dataultimaatualizacao']);?>" readonly="readonly" />
      <input name="dataultimaatualizacao" type="text" class="frm1" id="dataultimaatualizacao" style="background:" onfocus="this.className='frm2'" onblur="this.className='frm1'" onclick="clica('nome','erro4');" value="<?php echo date("d/m/Y")?>" size="20" maxlength="150" readonly="readonly" /></td>
  </tr>
  <tr>
    <td bgcolor="#F0F0F0">NOME:</td>
    <td><input name="nome" type="text" class="frm1" id="nome" style="background:" onFocus="this.className='frm2'" onBlur="this.className='frm1'" onClick="clica('nome','erro4');" value="<?php echo $row_seleciona_produtos['nome']?>" size="44" maxlength="150"></td>
    <td bgcolor="#F0F0F0">GARANTIA:</td>
    <td><input name="garantia" type="text" class="frm1" id="garantia" style="background:" onfocus="this.className='frm2'" onblur="this.className='frm1'" onclick="clica('garantia','erro4');" value="<?php echo $row_seleciona_produtos['garantia']?>" size="42" maxlength="150" /></td>
  </tr>
   <tr>
    <td bgcolor="#F0F0F0">FORNECEDOR ATUAL:</td>
    <td><input name="fornecedoratual" type="text" class="frm1" onClick="clica('fornecedoratual','erro4');" style="background:" id="fornecedoratual" onFocus="this.className='frm2'" value="<?php echo $row_seleciona_produtos['fornecedoratual']?>" size="44" maxlength="150"></td>
    <td bgcolor="#F0F0F0">DESTAQUE:</td>
    <td>
    <?php if ($totalRows_seleciona_produtosdestaques < 9) {?>
    
    <label>
      <input <?php if (!(strcmp($row_seleciona_produtos['destaque'],"S"))) {echo "checked=\"checked\"";} ?> type="radio" name="destaque" value="S" id="destaque" />
      SIM</label>
      <label>
        <input <?php if (!(strcmp($row_seleciona_produtos['destaque'],"N"))) {echo "checked=\"checked\"";} ?> type="radio" name="destaque" value="N" id="destaque" />
      NÃO</label>
      <?php } else { 
	  
	  	echo "JÁ EXISTEM 9 DESTAQUES"
	  ?>
      
	  <?php }?>
      
      </td>
  </tr>
  <tr>
    <td bgcolor="#F0F0F0">PREÇO DE CUSTO:&nbsp; </td>
    <td><input name="precodecusto" type="text" class="frm1" id="precodecusto" style="text-align: right; background:" onFocus="this.className='frm2'" onBlur="this.className='frm1'" onClick="clica('precodecusto','erro6');" onkeypress="reais(this,event)" onkeydown="backspace(this,event)" value="<?php echo $row_seleciona_produtos['precodecusto']?>" size="44"></td>
    <td bgcolor="#F0F0F0">MOSTRAR EM VENDA DIRETA:</td>
    <td><label>
      <input <?php if (!(strcmp($row_seleciona_produtos['destaque'],"S"))) {echo "checked=\"checked\"";} ?> type="radio" name="mostraremvendadireta" value="S" id="mostraremvendadireta_0" />
      SIM </label><label><input name="mostraremvendadireta" <?php if (!(strcmp($row_seleciona_produtos['destaque'],"S"))) {echo "checked=\"checked\"";} ?> type="radio" id="mostraremvendadireta_1" value="N" />
      NÃO</label></td>
  </tr>
  <tr>
    <td bgcolor="#F0F0F0"> CONSUMIDOR(R$):</td>
    <td><input name="precodevenda" type="text" class="frm1" id="precodevenda" style="text-align: right; background:" onfocus="this.className='frm2'" onblur="this.className='frm1'" onclick="clica('precodevenda','erro6');" onkeypress="reais(this,event)" onkeydown="backspace(this,event)" value="<?php echo $row_seleciona_produtos['precodevenda']?>" size="44" /></td>
    <td bgcolor="#F0F0F0">MARCA:</td>
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
    <td bgcolor="#F0F0F0"> COORPORATIVO(R$):</td>
    <td><input name="tabela2" type="text" class="frm1" id="tabela2" style="text-align: right; background:" onfocus="this.className='frm2'" onblur="this.className='frm1'" onclick="clica('Tabela2','erro6');" onkeypress="reais(this,event)" onkeydown="backspace(this,event)" value="<?php echo $row_seleciona_produtos['tabela2']?>" size="44" /></td>
    <td bgcolor="#F0F0F0"><?php 
	echo "<pre>";
	
  	  if(empty($row_seleciona_produtos['foto1'])){
	 		 
			 echo "<img width='80' name='foto1' src='../site/fotos_produtos/sem_foto.jpg' border='0'>";
	 
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
    <td bgcolor="#F0F0F0">VENDA DIRETA(R$):</td>
    <td><input name="vendadireta" type="text" class="frm1" id="vendadireta" style="text-align: right; background:" onfocus="this.className='frm2'" onblur="this.className='frm1'" onclick="clica('Tabela2','erro6');" onkeypress="reais(this,event)" onkeydown="backspace(this,event)" value="<?php echo $row_seleciona_produtos['vendadireta']?>" size="44" /></td>
    <td bgcolor="#F0F0F0"><?php 
  	  if(empty($row_seleciona_produtos['foto2'])){
	 		 
			 echo "<img width='80' name='foto2' src='../site/fotos_produtos/sem_foto.jpg' border='0'>";
	 
	  } else {
	  	
		if(!empty($row_seleciona_produtos['foto2'])){
		
			echo "<img width='80' name='foto2' src='../site/fotos_produtos/".$row_seleciona_produtos['foto2']."' border='0'>";
		
		} else {
		
			echo "<img width='80' name='foto2' src='../site/fotos_produtos/sem_foto.jpg' border='0'>";
		
		}
	}
	?></td>
    <td>TROCAR FOTO 2 ?:
      <input name="nova_foto[2]" type="radio" value="N" checked="checked" onclick="javascript:DesabilitarFoto2()" />
NÃO
<input name="nova_foto[2]" type="radio" value="S" onclick="javascript: HabilitarFoto2();" />
SIM <br />
<input class="inputon" onchange="document.images.foto2.src=this.value" name="fotonova2" id="fotonova2" type='file' size="16" disabled="disabled" />
<input name="foto2" type="hidden" value="<?php echo $row_seleciona_produtos['foto2']?>" /></td>
  </tr>
  <tr>
    <td bgcolor="#F0F0F0">GRUPO:</td>
    <td><p>
      <select name="id_grupo" id="id_grupo">
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
      </select>
      <br />
    </p></td>
    <td bgcolor="#F0F0F0"><?php 
  	  if(empty($row_seleciona_produtos['foto3'])){
	 		 
			 echo "<img width='80' name='foto3' src='../site/fotos_produtos/sem_foto.jpg' border='0'>";
	 
	  } else {
	  	
		if(!empty($row_seleciona_produtos['foto3'])){
		
			echo "<img width='80' name='foto3' src='../site/fotos_produtos/".$row_seleciona_produtos['foto3']."' border='0'>";
		
		} else {
		
			echo "<img width='80' name='foto3' src='../site/fotos_produtos/sem_foto.jpg' border='0'>";
		
		}
	}
	?></td>
    <td><label for="id_marca">TROCAR FOTO 3?:
        <input name="nova_foto[3]" type="radio" value="N" checked="checked" onclick="javascript:DesabilitarFoto3()" />
NÃO
<input name="nova_foto[3]" type="radio" value="S" onclick="javascript: HabilitarFoto3();" />
SIM <br />
<input class="inputon" onchange="document.images.foto3.src=this.value" name='fotonova3' id="fotonova3" type='file' size="16" disabled="disabled" />
<input name="foto3" type="hidden" value="<?php echo $row_seleciona_produtos['foto3']?>" />
    </label></td>
  </tr>
  <tr>
    <td bgcolor="#F0F0F0">CATEGORIA:</td>
    <td><label for="id_grupo">
      <select name="id_categoria" id="id_categoria">
        <option value="" <?php if (!(strcmp("", $row_seleciona_produtos['id_categoria']))) {echo "selected=\"selected\"";} ?>></option>
        <?php
do {  
?>
        <option value="<?php echo $row_seleciona_categorias['id']?>"<?php if (!(strcmp($row_seleciona_categorias['id'], $row_seleciona_produtos['id_categoria']))) {echo "selected=\"selected\"";} ?>><?php echo $row_seleciona_categorias['nome']?></option>
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
    <td bgcolor="#F0F0F0"><?php 
  	  if(empty($row_seleciona_produtos['foto4'])){
	 		 
			 echo "<img width='80' name='foto4' src='../site/fotos_produtos/sem_foto.jpg' border='0'>";
	 
	  } else {
	  	
		if(!empty($row_seleciona_produtos['foto1'])){
		
			echo "<img width='80' name='foto4' src='../site/fotos_produtos/".$row_seleciona_produtos['foto4']."' border='0'>";
		
		} else {
		
			echo "<img width='80' name='foto4' src='../site/fotos_produtos/sem_foto.jpg' border='0'>";
		
		}
	}
	?></td>  
   <td>
   
   
   <script>
function HabilitarFoto1() {
nForm = document.forms['form1_altprodutos'];
    if(nForm.elements['nova_foto[1]'].checked = true) {
        nForm.elements['fotonova1'].disabled = false;
		nForm.elements['fotonova1'].className= "input";
    }
}
function DesabilitarFoto1() {
nForm.elements['fotonova1'].disabled = true;
nForm.elements['fotonova1'].className = "inputon";
}

function HabilitarFoto2() {
nForm = document.forms['form1_altprodutos'];
    if(nForm.elements['nova_foto[2]'].checked = true) {
        nForm.elements['fotonova2'].disabled = false;
		nForm.elements['fotonova2'].className= "input";
    }
}
function DesabilitarFoto2() {
nForm.elements['fotonova2'].disbled = true;
nForm.elements['fotonova2'].className = "inputon";
}


function HabilitarFoto3() {
nForm = document.forms['form1_altprodutos'];
    if(nForm.elements['nova_foto[3]'].checked = true) {
        nForm.elements['fotonova3'].disabled = false;
		nForm.elements['fotonova3'].className= "input";
    }
}
function DesabilitarFoto3() {
nForm.elements['fotonova3'].disabled = true;
nForm.elements['fotonova3'].className = "inputon";
}


function HabilitarFoto4() {
nForm = document.forms['form1_altprodutos'];
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
TROCAR FOTO 4?:
<input name="nova_foto[4]" type="radio" value="N" checked="checked" onclick="javascript:DesabilitarFoto4()" />
NÃO
<input name="nova_foto[4]" type="radio" value="S" onclick="javascript: HabilitarFoto4();" />
SIM <br />
<input class="inputon" onchange="document.images.foto4.src=this.value" name='fotonova4' id="fotonova4" type='file' size="16" disabled="disabled" />
<input name="foto4" type="hidden" value="<?php echo $row_seleciona_produtos['foto4']?>" /></td>   
      
      
    
  </tr>
  <tr>
    <td height="8" bgcolor="#F0F0F0">PROPRIEDADES:</td>
    <td height="8"><label for="observacoes">
      <textarea name="propriedades" id="propriedades" cols="50" rows="5" class="frm1"><?php echo $row_seleciona_produtos['propriedades']?></textarea>
      </label></td>
    <td height="8">&nbsp;OBSERVAÇÕES:</td>
    <td height="8"><textarea name="observacoes" id="observacoes" cols="50" rows="5" class="frm1"><?php echo $row_seleciona_produtos['observacoes']?></textarea></td>
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
