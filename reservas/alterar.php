<?php require_once('../Connections/conn.php'); ?>
<?php require_once('../funcoes/funcoes.php'); ?>
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

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1_altreservas")) {



  $updateSQL = sprintf("UPDATE reservas SET id_fornecedor=%s, id_reserva=%s,cpf_cnpj=%s, id_cliente=%s, data_reserva=%s, hora_reserva=%s, chegada_hora=%s, hora_prevista_chegada=%s,saida_hora=%s, hora_prevista_saida=%s,hospede=%s,
  
  hospede_cpf=%s,hospede2=%s,hospede_cpf2=%s,hospede3=%s,hospede_cpf3=%s,
  hospede4=%s,hospede_cpf4=%s,hospede5=%s,hospede_cpf5=%s,hospede6=%s,
  hospede_cpf6=%s,
  
  chegada=%s, saida=%s, n_noites=%s,valor_diaria=%s, qtd_pass=%s, n_criancas=%s,n_camas=%s,qtd_total=%s,id_quarto=%s,
  valor_reserva=%s,formadepagamento=%s,cafedamanha=%s, comissao=%s, valor_retido=%s ,
   cobro_adiantamento=%s, valor_recebido=%s, valor_devido=%s,formadepagamento_checkin =%s,status=%s,situacao=%s, observacoes=%s  WHERE id=%s",
                      
					   GetSQLValueString($_POST['id_fornecedor'], "text"),
                       GetSQLValueString($_POST['id_reserva'], "text"),

GetSQLValueString($_POST['cpf_cnpj'], "text"),

					   GetSQLValueString($_POST['id_cliente'], "int"),
					   GetSQLValueString(datausa($_POST['data_reserva']), "date"),
 GetSQLValueString($_POST['hora_reserva'], "text"),
GetSQLValueString($_POST['chegada_hora'], "text"),
GetSQLValueString($_POST['hora_prevista_chegada'], "text"),
GetSQLValueString($_POST['saida_hora'], "text"),
GetSQLValueString($_POST['hora_prevista_saida'], "text"),
					   GetSQLValueString($_POST['hospede'], "text"),
					   
					   GetSQLValueString($_POST['hospede_cpf'], "text"),
					   GetSQLValueString($_POST['hospede2'], "text"),
					   GetSQLValueString($_POST['hospede_cpf2'], "text"),
					   GetSQLValueString($_POST['hospede3'], "text"),
					   GetSQLValueString($_POST['hospede_cpf3'], "text"),
					   
					    GetSQLValueString($_POST['hospede4'], "text"),
					   GetSQLValueString($_POST['hospede_cpf4'], "text"),
					    GetSQLValueString($_POST['hospede5'], "text"),
					   GetSQLValueString($_POST['hospede_cpf5'], "text"),
					    GetSQLValueString($_POST['hospede6'], "text"),
					   GetSQLValueString($_POST['hospede_cpf6'], "text"),
					   
					   

                       GetSQLValueString($_POST['chegada'], "text"),
					   GetSQLValueString($_POST['saida'], "text"),
					   GetSQLValueString($_POST['n_noites'], "text"),
 GetSQLValueString($_POST['valor_diaria'], "text"),
					   GetSQLValueString($_POST['qtd_pass'], "text"),
  GetSQLValueString($_POST['n_criancas'], "int"),
  GetSQLValueString($_POST['n_camas'], "int"),
GetSQLValueString($_POST['qtd_total'], "int"),
					   GetSQLValueString($_POST['id_quarto'], "int"),
					   
					   GetSQLValueString($_POST['valor_reserva'], "text"),
			           GetSQLValueString($_POST['formadepagamento'], "text"),
                       GetSQLValueString($_POST['cafedamanha'], "text"),
					   GetSQLValueString($_POST['comissao'], "text"),					   
					   GetSQLValueString($_POST['valor_retido'], "text"),
					   
					   GetSQLValueString($_POST['cobro_adiantamento'], "text"),

 GetSQLValueString($_POST['valor_recebido'], "text"),
 GetSQLValueString($_POST['valor_devido'], "text"),

					   GetSQLValueString($_POST['formadepagamento_checkin'], "text"),
					   GetSQLValueString($_POST['status'], "text"),
			   GetSQLValueString($_POST['situacao'], "text"),

					   GetSQLValueString($_POST['observacoes'], "text"),
                       GetSQLValueString($_POST['id'], "int"));

  mysql_select_db($database_conn, $conn);
  $Result1 = mysql_query($updateSQL, $conn) or die(mysql_error());
  
  
  
   if ($_POST['n_noites']  == 1) {




$dia_chegada = $_POST['chegada'];
//$dia = substr($dia_chegada,0,2);
//$mes = substr($dia_chegada,3,2);
//$ano= substr($dia_chegada,6,4);
//$dia_chegada =  $ano."-".$mes."-".$dia;





//$dia_chegada = date('Y-m-d', strtotime($_POST['chegada']))   ;

//$dia = date('Y-m-d', strtotime($dia_chegada. "+".$i." days"));

   $insertSQL2 = sprintf("UPDATE reservas_dias SET id_reserva=%s,dia=%s,status=%s, situacao=%s,id_quarto=%s    WHERE id_reserva=%s",


  // UPDATE INTO reservas_dias (id,id_reserva, dia, status, situacao, id_quarto) VALUES (%s,%s, %s, %s, %s )",


                       GetSQLValueString($_POST['id'], "int"),
					   GetSQLValueString($dia_chegada, "date"),
                       GetSQLValueString($_POST['status'], "text"),
           GetSQLValueString($_POST['situacao'], "text"),	
				   GetSQLValueString($_POST['id_quarto'], "text"),
					   GetSQLValueString($_POST['id'], "int")


						);

  mysql_select_db($database_conn, $conn);
  $Result2 = mysql_query($insertSQL2, $conn) or die(mysql_error());
  }


   if ($_POST['n_noites'] >1) { 
	  
	  $diarias = $_POST['n_noites'];
	  		
			for ($i=0;$i<$diarias;$i++) {
	  
	
$dia_chegada = $_POST['chegada'];

$dia = date('Y-m-d', strtotime($dia_chegada. "+".$i." days"));
	   
   $updateSQL2 = sprintf("UPDATE reservas_dias SET  id_quarto=%s, status=%s,situacao=%s WHERE id_reserva=%s",
                       
					  
					   GetSQLValueString($_POST['id_quarto'], "int"),
GetSQLValueString($_POST['status'], "text"),

GetSQLValueString($_POST['situacao'], "text"),
					    GetSQLValueString($_POST['id'], "int")
					  
						
						);

  mysql_select_db($database_conn, $conn);
  $Result2 = mysql_query($updateSQL2, $conn) or die(mysql_error());
  }
 }  
 

if ($_GET["mapa"] =="s"){
  $updateGoTo = "../inicio/principal.php?t=mapa_de_reservas";
}

else 
{
  $updateGoTo = "../inicio/principal.php?t=reservas";

}

  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

$colname_seleciona_reservas = "-1";
if (isset($_GET['id'])) {
  $colname_seleciona_reservas = $_GET['id'];
}

$id = $_GET['id'];


$colname_seleciona_reservas_dias = "-1";
if (isset($_GET['id_reserva'])) {
  $colname_seleciona_reservas_dias = $_GET['id_reserva'];
}

$id_reserva = $_GET['id_reserva'];

mysql_select_db($database_conn, $conn);
$query_seleciona_reservas = sprintf("SELECT * FROM reservas WHERE id = %s", GetSQLValueString($colname_seleciona_reservas, "int"));
$seleciona_reservas = mysql_query($query_seleciona_reservas, $conn) or die(mysql_error());
$row_seleciona_reservas = mysql_fetch_assoc($seleciona_reservas);
$totalRows_seleciona_reservas = mysql_num_rows($seleciona_reservas);

mysql_select_db($database_conn, $conn);
$query_seleciona_reservas_dias = sprintf("SELECT * FROM reservas_dias WHERE id = %s", GetSQLValueString($colname_seleciona_reservas_dias, "int"));
$seleciona_reservas_dias = mysql_query($query_seleciona_reservas_dias, $conn) or die(mysql_error());
$row_seleciona_reservas_dias = mysql_fetch_assoc($seleciona_reservas_dias);
$totalRows_seleciona_reservas_dias = mysql_num_rows($seleciona_reservas_dias);


mysql_select_db($database_conn, $conn);
$query_seleciona_quartos = sprintf("SELECT * FROM quartos ");
$seleciona_quartos = mysql_query($query_seleciona_quartos, $conn) or die(mysql_error());
$row_seleciona_quartos = mysql_fetch_assoc($seleciona_quartos);
$totalRows_seleciona_quartos = mysql_num_rows($seleciona_quartos);


mysql_select_db($database_conn, $conn);
$query_seleciona_clientes = "SELECT * FROM clientes ORDER BY nome ASC";
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
<link href="../css/estilos.css" rel="stylesheet" type="text/css" />


<script type="text/javascript" src="../js/jquery-1.2.6.pack.js"></script>
<script type="text/javascript" src="../js/jquery.maskedinput-1.1.4.pack.js"></script>

<script type="text/javascript">
	$(document).ready(function(){

		
	$("#hospede_cpf").mask("99.999.999.9999/99");
$("#hospede_cpf2").mask("999.999.9999-99");
$("#hospede_cpf3").mask("999.999.999-99");
$("#hospede_cpf4").mask("999.999.9999-99");
$("#hospede_cpf5").mask("999.999.9999-99");
$("#hospede_cpf6").mask("999.999.9999-99");
$("#hospede_cpf7").mask("999.999.9999-99");
$("#hospede_cpf8").mask("999.999.9999-99");
$("#hospede_cpf9").mask("999.999.9999-99");
$("#hospede_cpf10").mask("999.999.9999-99");
	
	$("#InicioHora").mask("99:99");
	
		
	$("#FimData").mask("99/99/9999");
	
	$("#FimHora").mask("99:99");
	
		    
	});
</script>

<script type="text/javascript">


  function maskIt(w,e,m,r,a){
// Cancela se o evento for Backspace
if (!e) var e = window.event
if (e.keyCode) code = e.keyCode;
else if (e.which) code = e.which;
// Vari�veis da fun��o
var txt  = (!r) ? w.value.replace(/[^\d]+/gi,'') : w.value.replace(/[^\d]+/gi,'').reverse();
var mask = (!r) ? m : m.reverse();
var pre  = (a ) ? a.pre : "";
var pos  = (a ) ? a.pos : "";
var ret  = "";
if(code == 9 || code == 8 || txt.length == mask.replace(/[^#]+/g,'').length) return false;
// Loop na m�scara para aplicar os caracteres
for(var x=0,y=0, z=mask.length;x<z && y<txt.length;){
if(mask.charAt(x)!='#'){
ret += mask.charAt(x); x++; }
else {
ret += txt.charAt(y); y++; x++; } }
// Retorno da fun��o
ret = (!r) ? ret : ret.reverse()
w.value = pre+ret+pos; }
// Novo m�todo para o objeto 'String'
String.prototype.reverse = function(){
return this.split('').reverse().join(''); };	

	  
  function diasDecorridos(dt1, dt2){
    // variáveis auxiliares
    var minuto = 60000; 
    var dia = minuto * 60 * 24;
    var horarioVerao = 0;
    
    // ajusta o horario de cada objeto Date
    dt1.setHours(0);
    dt1.setMinutes(0);
    dt1.setSeconds(0);
    dt2.setHours(0);
    dt2.setMinutes(0);
    dt2.setSeconds(0);
    
    // determina o fuso horário de cada objeto Date
    var fh1 = dt1.getTimezoneOffset();
    var fh2 = dt2.getTimezoneOffset(); 
    
    // retira a diferença do horário de verão
    if(dt2 > dt1){
      horarioVerao = (fh2 - fh1) * minuto;
    } 
    else{
      horarioVerao = (fh1 - fh2) * minuto;    
    }
    
    var dif = Math.abs(dt2.getTime() - dt1.getTime()) - horarioVerao;
    return Math.ceil(dif / dia);
}


function numero_noites(chegada,saida){
var data1 = new Date(document.getElementById("chegada").value);
  var data2 = new Date(document.getElementById("saida").value);
  document.getElementById("n_noites").value = diasDecorridos(data1, data2);

}

function soma_adiantado(){

var valor_reserva = parseFloat(document.getElementById("valor_reserva").value);
var valor_retido = parseFloat(document.getElementById("valor_retido").value);

document.getElementById("cobro_adiantamento").value =valor_reserva -   valor_retido ;
}







function soma_total(){

var valor_diaria = parseFloat(document.getElementById("valor_diaria").value);


var n_noites= parseFloat(document.getElementById("n_noites").value);

document.getElementById("valor_reserva").value =valor_diaria * n_noites;
}







function soma_pessoas(){

var qtd_pass = parseFloat(document.getElementById("qtd_pass").value);
var n_criancas= parseFloat(document.getElementById("n_criancas").value);

document.getElementById("qtd_total").value =qtd_pass + n_criancas;

}



function soma_total_valor_reservas(){

var n_noites= parseFloat(document.getElementById("n_noites").value);
var valor_diaria= parseFloat(document.getElementById("valor_diaria").value);

document.getElementById("valor_reserva").value =valor_diaria * n_noites;

}


function soma_devido(){

var cobro_adiantamento = parseFloat(document.getElementById("cobro_adiantamento").value);
var valor_recebido= parseFloat(document.getElementById("valor_recebido").value);

document.getElementById("valor_devido").value =cobro_adiantamento - valor_recebido;

}
</script>







</head>

<body>
<table width="100%"  border="0" align="center" cellpadding="0" cellspacing="2">
    <tr>
      <th width="40"><img src="../imagens/campainha.png" alt="" width="30" height="30" align="absmiddle" /></th>
      <th width="1217" class="Titulo16">ALTERA RESERVAS:</th>
      <th width="66" class="Titulo16"><a href="#" onclick="closeMessage()"><img src="../imagens/botao_fechar.png" width="25" height="25" alt="fechar" /></a></th>
    </tr>
</table>
  <hr align="center" width="100%" style="border:0;border-top:1px dashed #CECBBD;height:1px;clear:both">
<table width="100%">
  <tr>
    <td>
      <form action="<?php echo $editFormAction; ?>" method="post" name="form1_altreservas" id="form1_altreservas">
        <table width="100%" align="center">
          <tr valign="baseline">
            <td nowrap="nowrap" align="right">ID:</td>
            <td><?php echo "<h2>".$row_seleciona_reservas['id']."</h2>"; ?></td>
          </tr>
          <tr valign="baseline">
            <td nowrap="nowrap" align="right">FORNECEDOR:</td>
            <td><select name="id_fornecedor" id="id_fornecedor">
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
            <td align="right" nowrap="nowrap">ID_RESERVA:</td>
            <td><input name="id_reserva" type="text" id="id_reserva" value="<?php echo htmlentities($row_seleciona_reservas['id_reserva'], ENT_COMPAT, 'utf-8'); ?>" size="44" /></td>
          </tr>
          <tr valign="baseline">
            <td align="right" nowrap="nowrap">DATA DA RESERVA:</td>
            <td><input name="data_reserva" type="text" id="data_reserva" value="<?php echo htmlentities(databrasil($row_seleciona_reservas['data_reserva']), ENT_COMPAT, 'utf-8'); ?>" size="44" />

HORA DA RESERVA:
            <input name="hora_reserva" type="text" id="hora_reserva" value="<?php echo htmlentities($row_seleciona_reservas['hora_reserva'], ENT_COMPAT, 'utf-8'); ?>" size="44" />

</td>
          </tr>

<tr valign="baseline">
            <td align="right" nowrap="nowrap">CPF/CNPJ:</td>
            <td><input name="cpf_cnpj" type="text" id="cpf_cnpj" value="<?php echo htmlentities($row_seleciona_reservas['cpf_cnpj'], ENT_COMPAT, 'utf-8'); ?>" size="44" /></td>
          </tr>

          <tr valign="baseline">
            <td align="right" nowrap="nowrap">NOME DO CLIENTE:</td>
            <td><select name="id_cliente" id="id_cliente">
           <option value="">Escolha  o Cliente</option>
             <?php
do {  
?>
             <option value="<?php echo $row_seleciona_clientes['id']?>"<?php if (!(strcmp($row_seleciona_clientes['id'], $row_seleciona_reservas['id_cliente']))) {echo "selected=\"selected\"";} ?>><?php echo $row_seleciona_clientes['nome']?></option>
             <?php
} while ($row_seleciona_clientes = mysql_fetch_assoc($seleciona_clientes));
  $rows = mysql_num_rows($seleciona_clientes);
  if($rows > 0) {
      mysql_data_seek($seleciona_clientes, 0);
	  $row_seleciona_clientes = mysql_fetch_assoc($seleciona_clientes);
  }
?>
          </select></td>
          </tr>
          <tr valign="baseline">
            <td align="right" nowrap="nowrap">NOME DO HOSPEDE:</td>
            <td><input name="hospede" type="text" id="hospede" value="<?php echo htmlentities($row_seleciona_reservas['hospede'], ENT_COMPAT, 'utf-8'); ?>" size="20" />
            CPF:
            <input name="hospede_cpf" type="text"  id="hospede_cpf" value="<?php echo htmlentities($row_seleciona_reservas['hospede_cpf'], ENT_COMPAT, 'utf-8'); ?>" size="15" placeholder="000.000.000-00" pattern="[0-9]{3}.[0-9]{3}.[0-9]{3}-[0-9]{2}" /> 
            HOSPEDE 4 <input name="hospede4" type="text" id="hospede4" value="<?php echo htmlentities($row_seleciona_reservas['hospede4'], ENT_COMPAT, 'utf-8'); ?>" size="20" />
CPF:
<input name="hospede_cpf4" type="text" id="hospede_cpf4" value="<?php echo htmlentities($row_seleciona_reservas['hospede_cpf4'], ENT_COMPAT, 'utf-8'); ?>" size="15" placeholder="000.000.000-00" pattern="[0-9]{3}.[0-9]{3}.[0-9]{3}-[0-9]{2}"/></td>
          </tr>
          <tr valign="baseline">
            <td align="right" nowrap="nowrap">NOME DO HOSPEDE 2:</td>
            <td><input name="hospede2" type="text" id="hospede2" value="<?php echo htmlentities($row_seleciona_reservas['hospede2'], ENT_COMPAT, 'utf-8'); ?>" size="20" />
CPF:
  <input name="hospede_cpf2" type="text" id="hospede_cpf2" value="<?php echo htmlentities($row_seleciona_reservas['hospede_cpf2'], ENT_COMPAT, 'utf-8'); ?>" size="15" placeholder="000.000.000-00" pattern="[0-9]{3}.[0-9]{3}.[0-9]{3}-[0-9]{2}"/>
HOSPEDE 5
<input name="hospede5" type="text" id="hospede5" value="<?php echo htmlentities($row_seleciona_reservas['hospede5'], ENT_COMPAT, 'utf-8'); ?>" size="20" />
CPF:
<input name="hospede_cpf5" type="text" id="hospede_cpf5" value="<?php echo htmlentities($row_seleciona_reservas['hospede_cpf5'], ENT_COMPAT, 'utf-8'); ?>" size="15" placeholder="000.000.000-00" pattern="[0-9]{3}.[0-9]{3}.[0-9]{3}-[0-9]{2}"/></td>
          </tr>
          <tr valign="baseline">
            <td align="right" nowrap="nowrap">NOME DO HOSPEDE 3:</td>
            <td><input name="hospede3" type="text" id="hospede3" value="<?php echo htmlentities($row_seleciona_reservas['hospede3'], ENT_COMPAT, 'utf-8'); ?>" size="20" />
CPF:
  <input name="hospede_cpf3" type="text" id="hospede_cpf3" value="<?php echo htmlentities($row_seleciona_reservas['hospede_cpf3'], ENT_COMPAT, 'utf-8'); ?>" size="15" placeholder="000.000.000-00" pattern="[0-9]{3}.[0-9]{3}.[0-9]{3}-[0-9]{2}"/>
HOSPEDE 6
<input name="hospede6" type="text" id="hospede6" value="<?php echo htmlentities($row_seleciona_reservas['hospede6'], ENT_COMPAT, 'utf-8'); ?>" size="20" />
CPF:
<input name="hospede_cpf6" type="text" id="hospede_cpf6" value="<?php echo htmlentities($row_seleciona_reservas['hospede_cpf6'], ENT_COMPAT, 'utf-8'); ?>" size="15" placeholder="000.000.000-00" pattern="[0-9]{3}.[0-9]{3}.[0-9]{3}-[0-9]{2}"/></td>
          </tr>
          <tr valign="baseline">
            <td align="right" nowrap="nowrap">DATA DA CHEGADA:</td>
            <td><input name="chegada" type="date" id="chegada" value="<?php echo htmlentities($row_seleciona_reservas['chegada'], ENT_COMPAT, 'utf-8'); ?>" size="44" />

HORA CHECK IN : 
              <input name="chegada_hora" type="time" id="chegada_hora" value="<?php echo htmlentities($row_seleciona_reservas['chegada_hora'], ENT_COMPAT, 'utf-8'); ?>" size="15" onkeyup="maiuscula(this.value)"  />


HORA PREVISTA CHEGADA: 
              <input name="hora_prevista_chegada" type="time" id="hora_prevista_chegada" value="<?php echo htmlentities($row_seleciona_reservas['hora_prevista_chegada'], ENT_COMPAT, 'utf-8'); ?>" size="15" onkeyup="maiuscula(this.value)"  />
</td>
          </tr>
          <tr valign="baseline">
            <td align="right" nowrap="nowrap">DATA DA SAIDA:</td>
            <td><input name="saida" type="date" id="saida" value="<?php echo htmlentities($row_seleciona_reservas['saida'], ENT_COMPAT, 'utf-8'); ?>" size="44" />
HORA CHECK OUT :
            <input name="saida_hora" type="time" id="saida_hora" value="<?php echo htmlentities($row_seleciona_reservas['saida_hora'], ENT_COMPAT, 'utf-8'); ?>" size="15" onkeyup="maiuscula(this.value)"  />


HORA PREVISTA SAIDA: 
              <input name="hora_prevista_saida" type="time" id="hora_prevista_saida" value="<?php echo htmlentities($row_seleciona_reservas['hora_prevista_saida'], ENT_COMPAT, 'utf-8'); ?>" size="15" onkeyup="maiuscula(this.value)"  />
</td>
          </tr>
          <tr valign="baseline">
            <td align="right" nowrap="nowrap">Nº DE NOITES:</td>
            <td>

<input name="n_noites"  id="n_noites" value="<?php echo htmlentities($row_seleciona_reservas['n_noites'], ENT_COMPAT, 'utf-8'); ?>" size="5" onfocus="numero_noites()" style="background-color: #cccccc" readonly="readonly" />

VALOR DIARIA :<input name="valor_diaria" type="text" id="valor_diaria" value="<?php echo htmlentities($row_seleciona_reservas['valor_diaria'], ENT_COMPAT, 'utf-8'); ?>" size="5" /></td>
          </tr>
          <tr valign="baseline">
            <td align="right" nowrap="nowrap">Nº DE ADULTOS:</td>
            <td><input name="qtd_pass"  id="qtd_pass" value="<?php echo htmlentities($row_seleciona_reservas['qtd_pass'], ENT_COMPAT, 'utf-8'); ?>" size="2" />

Nº CRIANCAS(5 ANOS):
<input name="n_criancas"  id="n_criancas" value="<?php echo htmlentities($row_seleciona_reservas['n_criancas'], ENT_COMPAT, 'utf-8'); ?>" size="2" />

Nº DE CAMAS:
<input name="n_camas"  id="n_camas" value="<?php echo htmlentities($row_seleciona_reservas['n_camas'], ENT_COMPAT, 'utf-8'); ?>" size="2" />

TOTAL:
<input name="qtd_total"  id="qtd_total" value="<?php echo htmlentities($row_seleciona_reservas['qtd_total'], ENT_COMPAT, 'utf-8'); ?>" size="2"  onfocus="soma_pessoas()" style="background-color: #cccccc" readonly="readonly"/>


</td>
          </tr>
          <tr valign="baseline">
            <td align="right" nowrap="nowrap">NOME APT:</td>
            <td><select name="id_quarto" id="id_quarto">
              <option value="" <?php if (!(strcmp("", $row_seleciona_reservas['id_quarto']))) {echo "selected=\"selected\"";} ?>></option>
              <?php
do {  
?>
              <option value="<?php echo $row_seleciona_quartos['id']?>"<?php if (!(strcmp($row_seleciona_quartos['id'], $row_seleciona_reservas['id_quarto']))) {echo "selected=\"selected\"";} ?>><?php echo $row_seleciona_quartos['nome']?></option>
              <?php
} while ($row_seleciona_quartos = mysql_fetch_assoc($seleciona_quartos));
  $rows = mysql_num_rows($seleciona_quartos);
  if($rows > 0) {
      mysql_data_seek($seleciona_quartos, 0);
	  $row_seleciona_quartos = mysql_fetch_assoc($seleciona_quartos);
  }
?>
            </select></td>
          </tr>
          <tr valign="baseline">
            <td align="right" nowrap="nowrap">VALOR TOTAL DA RESERVA:</td>
            <td><input name="valor_reserva" type="text" id="valor_reserva" value="<?php echo htmlentities($row_seleciona_reservas['valor_reserva'], ENT_COMPAT, 'utf-8'); ?>" size="11" required="required" style="background-color: #cccccc" readonly="readonly" onfocus="soma_total_valor_reservas()";  />


</td>
          </tr>
          <tr valign="baseline">
            <td align="right" nowrap="nowrap">FORMA DE PAGAMENTO:</td>
            <td><select name="formadepagamento" id="formadepagamento">
              <option value="" <?php if (!(strcmp("", $row_seleciona_reservas['formadepagamento']))) {echo "selected=\"selected\"";} ?>>Escolha a Forma de Pagamento</option>
              <option value="E" <?php if (!(strcmp("E", $row_seleciona_reservas['formadepagamento']))) {echo "selected=\"selected\"";} ?>>ESPECIE</option>
              <option value="C" <?php if (!(strcmp("C", $row_seleciona_reservas['formadepagamento']))) {echo "selected=\"selected\"";} ?>>CARTAO</option>


   <option value="V" <?php if (!(strcmp("V", $row_seleciona_reservas['formadepagamento']))) {echo "selected=\"selected\"";} ?>>CARTAO CREDITO VISA</option>
   <option value="M" <?php if (!(strcmp("M", $row_seleciona_reservas['formadepagamento']))) {echo "selected=\"selected\"";} ?>>CARTAO CREDITO MASTERCARD</option>
   <option value="DV" <?php if (!(strcmp("DV", $row_seleciona_reservas['formadepagamento']))) {echo "selected=\"selected\"";} ?>>CARTAO DEBITO VISA</option>
   <option value="DM" <?php if (!(strcmp("DM", $row_seleciona_reservas['formadepagamento']))) {echo "selected=\"selected\"";} ?>>CARTAO CREDITO MASTERGARD</option>
   <option value="AE" <?php if (!(strcmp("AE", $row_seleciona_reservas['formadepagamento']))) {echo "selected=\"selected\"";} ?>>CARTAO CREDITO AMERICAN EXP.</option>
   <option value="H" <?php if (!(strcmp("H", $row_seleciona_reservas['formadepagamento']))) {echo "selected=\"selected\"";} ?>>CARTAO CREDITO HIPERCARD</option>









              <option value="B" <?php if (!(strcmp("B", $row_seleciona_reservas['formadepagamento']))) {echo "selected=\"selected\"";} ?>>BOLETO BANCARIO</option>
              <option value="D" <?php if (!(strcmp("D", $row_seleciona_reservas['formadepagamento']))) {echo "selected=\"selected\"";} ?>>DEPOSITO</option>
              <option value="O" <?php if (!(strcmp("O", $row_seleciona_reservas['formadepagamento']))) {echo "selected=\"selected\"";} ?>>CONVENIO</option>
             
            </select></td>
          </tr>
          <tr valign="baseline">
            <td align="right" nowrap="nowrap">CAFE DA MANHA:</td>
            <td><label>
              <input <?php if (!(strcmp($row_seleciona_reservas['cafedamanha'],"S"))) {echo "checked=\"checked\"";} ?> type="radio" name="cafedamanha" value="S" id="tipo_0" />
              SIM</label>
              <label>
                <input <?php if (!(strcmp($row_seleciona_reservas['cafedamanha'],"N"))) {echo "checked=\"checked\"";} ?> type="radio" name="cafedamanha" value="N" id="tipo_1" />
            NÃO</label></td>
          </tr>
          <tr valign="baseline">
            <td align="right" nowrap="nowrap">VALOR ADIANTADO:</td>
            <td><input name="valor_retido" type="text" id="valor_retido" value="<?php echo htmlentities($row_seleciona_reservas['valor_retido'], ENT_COMPAT, 'utf-8'); ?>" size="20" /></td>
          </tr>
          <tr valign="baseline">
            <td align="right" nowrap="nowrap">COBRAR NO CHECK IN:</td>
            <td><input name="cobro_adiantamento" type="text" id="cobro_adiantamento" value="<?php echo htmlentities($row_seleciona_reservas['cobro_adiantamento'], ENT_COMPAT, 'utf-8'); ?>" onfocus="soma_adiantado()" size="20" style="background-color: #cccccc" readonly="readonly" />



VALOR  RECEBIDO :<input name="valor_recebido" type="text" id="valor_recebido" value="<?php echo htmlentities($row_seleciona_reservas['valor_recebido'], ENT_COMPAT, 'utf-8'); ?>" size="20" />


VALOR  DEVIDO :<input name="valor_devido" type="text" id="valor_devido" value="<?php echo htmlentities($row_seleciona_reservas['valor_devido'], ENT_COMPAT, 'utf-8'); ?>" onfocus="soma_devido()" value="" size="20" style="background-color: #cccccc" />

</td>
          </tr>
          <tr valign="baseline">
            <td align="right" nowrap="nowrap">FORMA DE PAGAMENTO NO CHECK IN:</td>
            <td><select name="formadepagamento_checkin" id="formadepagamento_checkin">
              <option value="" <?php if (!(strcmp("", $row_seleciona_reservas['formadepagamento_checkin']))) {echo "selected=\"selected\"";} ?>></option>
              <option value="E" <?php if (!(strcmp("E", $row_seleciona_reservas['formadepagamento_checkin']))) {echo "selected=\"selected\"";} ?>>ESPECIE</option>
              <option value="C" <?php if (!(strcmp("C", $row_seleciona_reservas['formadepagamento_checkin']))) {echo "selected=\"selected\"";} ?>>CARTAO</option>


<option value="V" <?php if (!(strcmp("V", $row_seleciona_reservas['formadepagamento_checkin']))) {echo "selected=\"selected\"";} ?>>CARTAO CREDITO VISA</option>
<option value="M" <?php if (!(strcmp("M", $row_seleciona_reservas['formadepagamento_checkin']))) {echo "selected=\"selected\"";} ?>>CARTAO CREDITO MASTERCARD</option>
<option value="DV" <?php if (!(strcmp("DV", $row_seleciona_reservas['formadepagamento_checkin']))) {echo "selected=\"selected\"";} ?>>CARTAO DEBITO VISA</option>
<option value="DM" <?php if (!(strcmp("DM", $row_seleciona_reservas['formadepagamento_checkin']))) {echo "selected=\"selected\"";} ?>>CARTAO DEBITO MASTERCARD</option>
<option value="AE" <?php if (!(strcmp("AE", $row_seleciona_reservas['formadepagamento_checkin']))) {echo "selected=\"selected\"";} ?>>CARTAO AMERICAN EXPRESS</option>
<option value="H" <?php if (!(strcmp("H", $row_seleciona_reservas['formadepagamento_checkin']))) {echo "selected=\"selected\"";} ?>>CARTAO HIPERCARD</option>

              <option value="B" <?php if (!(strcmp("B", $row_seleciona_reservas['formadepagamento_checkin']))) {echo "selected=\"selected\"";} ?>>BOLETO BANCARIO</option>
              <option value="D" <?php if (!(strcmp("D", $row_seleciona_reservas['formadepagamento_checkin']))) {echo "selected=\"selected\"";} ?>>DEPOSITO</option>
              <option value="O" <?php if (!(strcmp("O", $row_seleciona_reservas['formadepagamento_checkin']))) {echo "selected=\"selected\"";} ?>>OUTROS</option>
            </select></td>
          </tr>
          <tr valign="baseline">
            <td align="right" nowrap="nowrap">STATUS:</td>
            
            <td><select name="status" id="status">
            
             <option value="" <?php if (!(strcmp("", $row_seleciona_reservas['status']))) {echo "selected=\"selected\"";} ?>></option>
              
             
              <option value="RESERVADO" <?php if (!(strcmp("RESERVADO", $row_seleciona_reservas['status']))) {echo "selected=\"selected\"";} ?>>RESERVADO</option>
              
              <option value="EM MANUTENCAO" <?php if (!(strcmp("EM MANUTENCAO", $row_seleciona_reservas['status']))) {echo "selected=\"selected\"";} ?>>EM MANUTENCAO</option>
              <option value="HOSPEDADO" <?php if (!(strcmp("HOSPEDADO", $row_seleciona_reservas['status']))) {echo "selected=\"selected\"";} ?>>HOSPEDADO</option>
              
              
              <option value="PRE RESERVADO" <?php if (!(strcmp("PRE RESERVADO", $row_seleciona_reservas['status']))) {echo "selected=\"selected\"";} ?>>PRE RESERVADO</option>
              
             
              <option value="LIMPAR" <?php if (!(strcmp("LIMPAR", $row_seleciona_reservas['status']))) {echo "selected=\"selected\"";} ?>>LIMPAR</option>
              
               <option value="CANCELADO" <?php if (!(strcmp("CANCELADO", $row_seleciona_reservas['status']))) {echo "selected=\"selected\"";} ?>>CANCELADO</option>
              
              
            </select>




</td>


<tr valign="baseline">
            <td align="right" nowrap="nowrap">SITUAÇÃO:</td>
            
            <td><select name="situacao" id="situacao">
            
             <option value="" <?php if (!(strcmp("", $row_seleciona_reservas['situacao']))) {echo "selected=\"selected\"";} ?>></option>
              
             
              <option value="LC" <?php if (!(strcmp("LC", $row_seleciona_reservas['situacao']))) {echo "selected=\"selected\"";} ?>>LIMPEZA COMPLETA</option>
              
              <option value="LCH" <?php if (!(strcmp("LCH", $row_seleciona_reservas['situacao']))) {echo "selected=\"selected\"";} ?>>LIMPEZA COM HOSPEDE</option>
              <option value="LSH" <?php if (!(strcmp("LSH", $row_seleciona_reservas['situacao']))) {echo "selected=\"selected\"";} ?>>LIMPEZA SEM HOSPEDE</option>
              
               <option value="EM" <?php if (!(strcmp("EM", $row_seleciona_reservas['situacao']))) {echo "selected=\"selected\"";} ?>>EM MANUTENCAO</option>
             
              
              
            </select>



          </tr>
          <tr valign="baseline">
            <td nowrap="nowrap" align="right">OBSERVAÇÕES:</td>
            <td><textarea name="observacoes" cols="44" id="observacoes"><?php echo htmlentities($row_seleciona_reservas['observacoes'], ENT_COMPAT, 'utf-8'); ?></textarea></td>
          </tr>
          <tr valign="baseline">
            <td nowrap="nowrap" align="right">&nbsp;</td>
            <td><input name="id2" type="hidden" id="id" value="<?php echo $row_seleciona_reservas['id']?>" />
            <input name="id_permissao" type="hidden" id="id_permissao" value="<?php echo $row_permissoes['id']?>" /></td>
          </tr>
          <tr valign="baseline">
            <td nowrap="nowrap" align="right">&nbsp;</td>
            <td><input type="submit" value="Confirmar" />
            <input type="button" class="btn1" onclick="closeMessage()" value="Cancelar" /></td>
          </tr>
        </table>
        <input type="hidden" name="MM_update" value="form1_altreservas" />
        <input type="hidden" name="id" value="<?php echo $row_seleciona_reservas['id']; ?>" />

        <input type="hidden" name="id_quarto_anterior" value="<?php $row_seleciona_reservas['id_quarto']?>">
        <input type="hidden" name="entrada_anterior" value="<?php $row_seleciona_reservas['entrada']?>">
        <input type="hidden" name="saida_anterior" value="<?php $row_seleciona_reservas['saida']?>">
      </form>
   </td>
  </tr>
</table>


<script>


function maiuscula(valor) {
var campo=document.form1_altreservas;
campo.hospede.value = campo.hospede.value.toUpperCase();
campo.fornecedor.value = campo.fornecedor.value.toUpperCase();
campo.local_realocado.value = campo.local_realocado.value.toUpperCase();
campo.observacoes.value = campo.observacoes.value.toUpperCase();


}


</script>
</body>
</html>
<?php
mysql_free_result($seleciona_reservas);
mysql_free_result($seleciona_reservas_dias);
?>
