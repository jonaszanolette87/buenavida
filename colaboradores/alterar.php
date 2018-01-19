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



mysql_select_db($database_conn, $conn);
$query_seleciona_funcoes = "SELECT * FROM funcoes ORDER BY id ASC";
$seleciona_funcoes = mysql_query($query_seleciona_funcoes, $conn) or die(mysql_error());
$row_seleciona_funcoes = mysql_fetch_assoc($seleciona_funcoes);
$totalRows_seleciona_funcoes = mysql_num_rows($seleciona_funcoes);



$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
  $updateSQL = sprintf("UPDATE `colaboradores` SET `ID_Filial`=%s,`Nome`=%s,`Sexo`=%s,`Nascimento`=%s,`Civil`=%s,
  `Nacionalidade`=%s,`CPF`=%s,`RG`=%s,`Mail`=%s,`Logradouro`=%s,
  `Numero`=%s,`Bairro`=%s,`Complemento`=%s,`CEP`=%s,`ID_Estado`=%s,
  `ID_Cidade`=%s,`Tel_Residencial`=%s,`Tel_Movel`=%s,`Tel_Recados`=%s,`Tel_Obervacao`=%s,
  `TemEPI`=%s,`EntregaEPI`=%s,`VencimentoEPI`=%s,`CPF_Responsavel`=%s,`RG_Responsavel`=%s,
  
  `Foto`=%s,`Foto_Tipo`=%s,`ID_Funcao`=%s,`CTPS`=%s,`Data_Registro`=%s,
  `Data_Inicio`=%s,`Data_Desligamento`=%s,`Dia_Pagamento`=%s,`Dia_Ajuda`=%s,`Observacao`=%s,
  `Nome_Empresa`=%s,`Endereco_Empresa`=%s,`Tel_Empresa`=%s,`Ultimo_Salario`=%s,`Ultima_Funcao`=%s,
  `Ultimo_Salario_Registrado`=%s,`Motivo_Desligamento`=%s,`Registrado`=%s,`Ultimo_Trabalho`=%s,`Experiencias`=%s,
  `Conhecimentos`=%s,`Blusa`=%s,`Calca`=%s,`Contratacao`=%s,`Usuario`=%s,
  
  `Senha`=%s,`Data_Criacao`=%s,`Criador`=%s,`Data_Edicao`=%s,`Editor`=%s  WHERE ID=%s",  
  
                       GetSQLValueString($_POST['ID_Filial'], "int"),
                       GetSQLValueString($_POST['Nome'], "text"),
					   GetSQLValueString($_POST['Sexo'], "text"),
                       GetSQLValueString($_POST['Nascimento'], "text"),
                       GetSQLValueString($_POST['Civil'], "text"),
					   
                       GetSQLValueString($_POST['Nacionalidade'], "text"),
                       GetSQLValueString($_POST['CPF'], "text"),
					   GetSQLValueString($_POST['RG'], "text"),
					   GetSQLValueString($_POST['Mail'], "text"),
					   GetSQLValueString($_POST['Logradouro'], "text"),
					   
					   GetSQLValueString($_POST['Numero'], "text"),
					   GetSQLValueString($_POST['Bairro'], "text"),
					   GetSQLValueString($_POST['Complemento'], "text"),
					   GetSQLValueString($_POST['CEP'], "text"),
					   GetSQLValueString($_POST['ID_Estado'], "int"),
					   
					   GetSQLValueString($_POST['ID_Cidade'], "int"),
					   GetSQLValueString($_POST['Tel_Residencial'], "text"),
					   GetSQLValueString($_POST['Tel_Movel'], "text"),
					   GetSQLValueString($_POST['Tel_Recados'], "text"),
					   GetSQLValueString($_POST['Tel_Obervacao'], "int"),
					   
					   GetSQLValueString($_POST['TemEPI'], "text"),
					   GetSQLValueString($_POST['EntregaEPI'], "text"),
					   GetSQLValueString($_POST['VencimentoEPI'], "text"),
					   GetSQLValueString($_POST['CPF_Responsavel'], "text"),
					   GetSQLValueString($_POST['RG_Responsavel'], "text"),
					   
					   GetSQLValueString($_POST['Foto'], "text"),
					   GetSQLValueString($_POST['Foto_Tipo'], "text"),
					   GetSQLValueString($_POST['ID_Funcao'], "text"),
					   GetSQLValueString($_POST['CTPS'], "text"),
					   GetSQLValueString($_POST['Data_Registro'], "date"),
					   
					   
					   GetSQLValueString($_POST['Data_Inicio'], "text"),
					   GetSQLValueString($_POST['Data_Desligamento'], "text"),
					   GetSQLValueString($_POST['Dia_Pagamento'], "text"),
					   GetSQLValueString($_POST['Dia_Ajuda'], "text"),
					 
					   
					   
					   GetSQLValueString($_POST['Observacao'], "text"),
					   GetSQLValueString($_POST['Nome_Empresa'], "text"),
					   GetSQLValueString($_POST['Endereco_Empresa'], "text"),
					   GetSQLValueString($_POST['Tel_Empresa'], "text"),
					   GetSQLValueString($_POST['Ultimo_Salario'], "text"),
					   
					   GetSQLValueString($_POST['Ultima_Funcao'], "text"),
					   GetSQLValueString($_POST['Ultimo_Salario_Registrado'], "text"),
					   GetSQLValueString($_POST['Motivo_Desligamento'], "text"),
					   GetSQLValueString($_POST['Registrado'], "text"),
					   GetSQLValueString($_POST['Ultimo_Trabalho'], "int"),
					   
					   GetSQLValueString($_POST['Experiencias'], "text"),
					   GetSQLValueString($_POST['Conhecimentos'], "text"),
					   GetSQLValueString($_POST['Blusa'], "text"),
					   GetSQLValueString($_POST['Calca'], "text"),
					   GetSQLValueString($_POST['Contratacao'], "int"),
					   
					   GetSQLValueString($_POST['Usuario'], "text"),
					   GetSQLValueString($_POST['Senha'], "text"),
					   GetSQLValueString($_POST['Data_Criacao'], "text"),
					   GetSQLValueString($_POST['Criador'], "text"),
					   GetSQLValueString($_POST['Data_Edicao'], "int"),
					   
					   GetSQLValueString($_POST['Editor'], "text"),
					   
					   
					   GetSQLValueString($_POST['ID'], "int"));

  mysql_select_db($database_conn, $conn);
  $Result1 = mysql_query($updateSQL, $conn) or die(mysql_error());

  $updateGoTo = "../inicio/principal.php?pg=colaboradores";
  if (isset($_SERVER['QUERY_STRING'])) {
  //  $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
 //   $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

$colname_seleciona_colaboradores = "-1";
if (isset($_GET['ID'])) {
  $colname_seleciona_colaboradores = $_GET['ID'];
}
mysql_select_db($database_conn, $conn);
$query_seleciona_colaboradores = sprintf("SELECT * FROM colaboradores WHERE ID = %s", GetSQLValueString($colname_seleciona_colaboradores, "int"));
$seleciona_colaboradores = mysql_query($query_seleciona_colaboradores, $conn) or die(mysql_error());
$row_seleciona_colaboradores = mysql_fetch_assoc($seleciona_colaboradores);
$totalRows_seleciona_colaboradores = mysql_num_rows($seleciona_colaboradores);
?>
<link href="../css/estilos.css" rel="stylesheet" type="text/css" />
<style type="text/css">
#campo {
	margin: 2px;
	padding: 2px;
	float: left;
	height: auto;
	width: auto;
}
#botoes  {
	clear: both;
}
#both  {
	clear: both;
}
</style>

<table width="100%" align="center">
  <tr>
    <th><img src="../imagens/colaboradores.png" alt="colaboradores" width="32" height="32" align="absmiddle" /> ALTERAR COLABORADORES.</th>
  </tr>
  </table>
 <form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
       
            <div id="campo">
            ID:<br />
   <?php echo $row_seleciona_colaboradores['ID']; ?></div>
   <div id="both"></div>
   
   <div id="campo">NOME:<br />
     <input type="text" name="Nome" value="<?php echo htmlentities($row_seleciona_colaboradores['Nome'], ENT_COMPAT, 'utf-8'); ?>" size="50" /> 
     </div>         <div id="both"></div>     
             <div id="campo"> E-MAIL:<br />
   <input type="text" name="Mail" value="<?php echo htmlentities($row_seleciona_colaboradores['Mail'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></div><div id="campo">ENDEREÇO:<br />
     <input name="Logradouro" type="text" id="Logradouro" value="<?php echo htmlentities($row_seleciona_colaboradores['Logradouro'], ENT_COMPAT, 'utf-8'); ?>" size="40" /></div><div id="campo">BAIRRO:<br />
       <input name="Bairro" type="text" id="Bairro" value="<?php echo htmlentities($row_seleciona_colaboradores['Bairro'], ENT_COMPAT, 'utf-8'); ?>" /></div>
          <div id="campo">  CIDADE:<br />
   <input name="ID_Cidade" type="text" id="ID_Cidade" value="<?php echo htmlentities($row_seleciona_colaboradores['ID_Cidade'], ENT_COMPAT, 'utf-8'); ?>" /></div>
          <div id="campo">  ESTADO:<br />
   <input name="ID_Estado" type="text" id="ID_Estado" value="<?php echo htmlentities($row_seleciona_colaboradores['ID_Estado'], ENT_COMPAT, 'utf-8'); ?>" size="5" /></div><div id="campo">CEP:<br />
     <input name="CEP" type="text" id="CEP" value="<?php echo htmlentities($row_seleciona_colaboradores['CEP'], ENT_COMPAT, 'utf-8'); ?>" /></div><div id="campo">FONE:<br />
              <input name="Tel_Residencial" type="text" id="Tel_Residencial" value="<?php echo htmlentities($row_seleciona_colaboradores['Tel_Residencial'], ENT_COMPAT, 'utf-8'); ?>" /></div>
              <div id="campo">
            CELULAR:<br />
   <input name="Tel_Movel" type="text" id="Tel_Movel" value="<?php echo htmlentities($row_seleciona_colaboradores['Tel_Movel'], ENT_COMPAT, 'utf-8'); ?>" /></div><div id="campo">CPF:<br />
     <input name="CPF" type="text" id="CPF" value="<?php echo htmlentities($row_seleciona_colaboradores['CPF'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></div>
          <div id="campo">  RG:<br />
   <input name="RG" type="text" id="RG" value="<?php echo htmlentities($row_seleciona_colaboradores['RG'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></div>
            
            
           <div id="campo">   DATA ADMISSÃO:<br />
   <input name="Data_Registro" type="text" id="Data_Registro" value="<?php echo htmlentities($row_seleciona_colaboradores['Data_Registro'], ENT_COMPAT, 'utf-8'); ?>" /></div>
            <br />
           <div id="campo"> SALARIO:<br />
   <input name="Ultimo_Salario" type="text" id="Ultimo_Salario" value="<?php echo htmlentities($row_seleciona_colaboradores['Ultimo_Salario'], ENT_COMPAT, 'utf-8'); ?>" /></div>
   <div id="campo">STATUS:<label>
                  <br />
                  <input <?php if (!(strcmp($row_seleciona_colaboradores['status'],"S"))) {echo "checked=\"checked\"";} ?> type="radio" name="status" value="S" id="tipo_0" />
                ATIVO</label>
                <label>
                  <input <?php if (!(strcmp($row_seleciona_colaboradores['status'],"N"))) {echo "checked=\"checked\"";} ?> type="radio" name="status" value="N" id="tipo_1" />
                INATIVO</label></div>
   <div id="both"></div>
   <div id="campo">OBSERVAÇÕES:<br />
<textarea name="Observacao" cols="100" id="Observacao"><?php echo htmlentities($row_seleciona_colaboradores['Observacao'], ENT_COMPAT, 'utf-8'); ?></textarea></div>
            <div id="botoes">
              <input name="Entrar" type="submit" id="Entrar" value="CONFIRMAR" />
            <a href="../inicio/principal.php?pg=colaboradores"> <input type="button" class="btn1" onclick="" value="CANCELAR" /></a>
            </div>
        <input type="hidden" name="MM_update" value="form1" />
        <input type="hidden" name="ID" value="<?php echo $row_seleciona_colaboradores['ID']; ?>" />
</form>


<?php
mysql_free_result($seleciona_colaboradores);
?>
