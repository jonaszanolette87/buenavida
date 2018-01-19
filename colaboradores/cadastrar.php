<?php require_once('../Connections/conn.php');

include("../funcoes/funcoes.php")  ?>
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

mysql_select_db($database_conn, $conn);
$query_seleciona_funcoes = "SELECT ID, Funcoes 
FROM funcoes
";
$seleciona_funcoes = mysql_query($query_seleciona_funcoes, $conn) or die(mysql_error());
$row_seleciona_funcoes = mysql_fetch_assoc($seleciona_funcoes);
$totalRows_seleciona_funcoes = mysql_num_rows($seleciona_funcoes);



$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO colaboradores (ID, Nome, ID_Funcao) VALUES (%s, %s, %s)",
                       GetSQLValueString($_POST['ID'], "int"),
                       GetSQLValueString($_POST['Nome'], "text"),
					    GetSQLValueString($_POST['ID_Funcao'], "int")
                       );

  mysql_select_db($database_conn, $conn);
  $Result1 = mysql_query($insertSQL, $conn) or die(mysql_error());

  $insertGoTo = "../inicio/principal.php?pg=colaboradores";
  if (isset($_SERVER['QUERY_STRING'])) {
  //  $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
  //  $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}
?>
<script type="text/javascript" src="../js/jquery-1.2.6.pack.js"></script>
<script type="text/javascript" src="../js/jquery.maskedinput-1.1.4.pack.js"/></script>
<script type="text/javascript">
	$(document).ready(function(){
		
		$("#Fone_1").mask("(99)9999-9999");
		$("#telefone2").mask("(99)9999-9999");
		$("#CEP").mask("99.999-999");
		$("#datanascimento").mask("99/99/9999");
		$("#cpf").mask("999.999.999-99");
		$("#CNPJ").mask("99.999.999/9999-99");
		
	    
	});
</script>
<link href="../css/estilos.css" rel="stylesheet" type="text/css" />
<style type="text/css">
#campo {
	margin: 2px;
	padding: 2px;
	float: left;
	height: auto;
	width: auto;
}

#form1_altcolaboradores #botoes {
	clear: both;
}
#form1_altcolaboradores #both {
	clear: both;
}
</style>

<table width="100%"><tr><th>
<img src="../imagens/funcionarios.png" alt="usuarios" width="32" height="32" align="absmiddle" />CADASTRAR COLABORADORES</th></tr></table>
     <form action="<?php echo $editFormAction; ?>" method="post" name="form1_altclientes" id="form1_altcolaboradores" onsubmit="return this.Entrar.disabled =true; ">
       
            
             <div id="campo">NOME:<br>
       <input name="Nome" type="text" id="Nome" value="" size="50" /></div>
             <div id="both"></div>
              <div id="campo">
                EMAIL:<br>
            <input type="text" name="email" value="" /></div> <div id="campo">ENDEREÇO:<br>
              <input name="endereco" type="text" id="endereco" value="" size="40" /> 
              </div>           
            <div id="campo">BAIRRO:<br>
                <input name="Bairro" type="text" id="Bairro" value="" /></div>
              
              <div id="campo"> CIDADE:<br>
       <input name="ID_Cidade" type="text" id="ID_Cidade" value="" /></div>
               <div id="campo">ESTADO:<br>
              <input name="ID_Estado" type="text" id="ID_Estado" value="" size="5" /></div> <div id="campo">CEP:<br>
                <input name="CEP" type="text" id="CEP" value="" /></div> <div id="campo">FONE:<br>
                  <input name="telefone1" type="text" id="telefone1" value="" size="32" /></div>
            <div id="campo">  CELULAR:<br>
              <input name="telefone2" type="text" id="telefone2" value="" size="32" /></div> <div id="campo">CPF:
                <br>
                <input name="cpf" type="text" id="cpf" value="" size="32" /></div>
            <div id="campo"> RG:<br>
              <input name="rg" type="text" id="rg" value="" size="32" /></div>  
           <div id="campo">  DATA ADMISSÃO:<br>
             <input name="dataadmissao" type="text" id="dataadmissao" value="" size="20" /></div>
           <div id="campo">  SALARIO:<br>
             <input name="salario" type="text" id="salario" value="" size="20" /></div><div id="campo">STATUS:<br>
<label>
                  <input type="radio" name="status" value="S" id="status_0" />
                ATIVO</label>
                <label>
                  <input type="radio" name="status" value="N" id="status_1" />
            INATIVO</label></div>
            <div id="both"></div>
            <div id="campo">OBSERVAÇÕES:<br>
  <textarea name="observacoes" cols="100" id="observacoes"></textarea></div>
  
  <div id="both"></div>
             <br>
       <div id="botoes">
  <a href="../inicio/principal.php?pg=colaboradores"> 
  <input name="Entrar" id="Entrar" type="submit" value=".::CADASTRAR::." onClick="javascript:this.value='Enviando ...'; "/>
  <input type="button" class="btn1" onclick="" value="CANCELAR" /></a></div>
        <input type="hidden" name="MM_insert" value="form1" />
</form>
   