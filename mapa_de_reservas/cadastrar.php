<?php 
session_start(); $_SESSION["MM_username"];

require_once('../Connections/conn.php'); 
require_once('../funcoes/funcoes.php'); ?>
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

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO reservas (id, id_fornecedor, id_reserva,id_cliente, data_reserva, 
  hospede, chegada, saida, n_noites, qtd_pass, 
  local_realocado, id_quarto, valor_reserva,formadepagamento,cafedamanha, 
  valor_realocacao,  comissao, valor_retido,formadepagamento_checkin, cobro_adiantamento, status,
  observacoes,usuario) VALUES (%s, %s, %s, %s, %s, 
  %s,%s, %s,%s, %s, 
  %s, %s, %s, %s, %s,
   %s, %s, %s, %s, %s
   , %s, %s, %s)",
                       GetSQLValueString($_POST['id'], "int"),
                       GetSQLValueString($_POST['id_fornecedor'], "text"),
                       GetSQLValueString($_POST['id_reserva'], "text"),
					    GetSQLValueString($_POST['id_cliente'], "text"),
					   GetSQLValueString($_POST['data_reserva'], "text"),
					   
					   GetSQLValueString($_POST['hospede'], "text"),
					    GetSQLValueString($_POST['chegada'], "date"),
						GetSQLValueString($_POST['saida'], "text"),
						GetSQLValueString($_POST['n_noites'], "text"),
						GetSQLValueString($_POST['qtd_pass'], "text"),	
						
						GetSQLValueString($_POST['local_realocado'], "text"),
						GetSQLValueString($_POST['id_quarto'], "int"),
						GetSQLValueString($_POST['valor_reserva'], "text"),
						GetSQLValueString($_POST['formadepagamento'], "text"),
						GetSQLValueString($_POST['cafedamanha'], "text"),
						
						GetSQLValueString($_POST['valor_realocacao'], "text"),																									                        GetSQLValueString($_POST['comissao'], "text"),
						GetSQLValueString($_POST['valor_retido'], "text"),
							GetSQLValueString($_POST['formadepagamento_checkin'], "text"),
						GetSQLValueString(ceil($_POST['cobro_adiantamento']), "text"),
						GetSQLValueString($_POST['status'], "text"),
						
						GetSQLValueString($_POST['observacoes'], "text"),
						GetSQLValueString($_POST['usuario'], "text")
					
						
						);
						
						

  mysql_select_db($database_conn, $conn);
  $Result1 = mysql_query($insertSQL, $conn) or die(mysql_error());
  $id_reserva = mysql_insert_id();
  
  if ($_POST['n_noites']  == 1) {



$dia_chegada = $_POST['chegada'];
//$dia = substr($dia_chegada,0,2);
//$mes = substr($dia_chegada,3,2);
//$ano= substr($dia_chegada,6,4);
//$dia_chegada =  $ano."-".$mes."-".$dia;




//$dia_chegada = date('Y-m-d', strtotime($_POST['chegada']))   ;

//$dia = date('Y-m-d', strtotime($dia_chegada. "+".$i." days"));

   $insertSQL2 = sprintf("INSERT INTO reservas_dias (id,id_reserva, dia, status, id_quarto) VALUES (%s,%s, %s, %s, %s )",
                       GetSQLValueString($_POST['id'], "int"),
                       GetSQLValueString($id_reserva, "int"),

					   GetSQLValueString($dia_chegada, "date"),
                       GetSQLValueString($_POST['status'], "text"),
					   GetSQLValueString($_POST['id_quarto'], "text")


						);

  mysql_select_db($database_conn, $conn);
  $Result2 = mysql_query($insertSQL2, $conn) or die(mysql_error());
  }

 
  
  
  
 if ($_POST['n_noites'] >1) {
	  
	  $diarias = $_POST['n_noites'];
	  		
			for ($i=0;$i<$diarias;$i++) {
	  
	
$dia_chegada = $_POST['chegada'];

$dia = date('Y-m-d', strtotime($dia_chegada. "+".$i." days"));
	   
   $insertSQL2 = sprintf("INSERT INTO reservas_dias (id,id_reserva, dia, status, id_quarto) VALUES (%s,%s, %s, %s, %s )",
                       GetSQLValueString($_POST['id'], "int"),
                       GetSQLValueString($id_reserva, "int"),
                       
					   GetSQLValueString($dia, "date"),
                       GetSQLValueString($_POST['status'], "text"),
					   GetSQLValueString($_POST['id_quarto'], "text")
					  
						
						);

  mysql_select_db($database_conn, $conn);
  $Result2 = mysql_query($insertSQL2, $conn) or die(mysql_error());
  }
 }

  $insertGoTo = "../inicio/principal.php?t=mapa_de_reservas";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}


mysql_select_db($database_conn, $conn);
$query_seleciona_quartos = sprintf("SELECT * FROM quartos ");
$seleciona_quartos = mysql_query($query_seleciona_quartos, $conn) or die(mysql_error());
$row_seleciona_quartos = mysql_fetch_assoc($seleciona_quartos);
$totalRows_seleciona_quartos = mysql_num_rows($seleciona_quartos);

mysql_select_db($database_conn, $conn);
$query_seleciona_clientes = "SELECT * FROM clientes";
$seleciona_clientes = mysql_query($query_seleciona_clientes, $conn) or die(mysql_error());
$row_seleciona_clientes = mysql_fetch_assoc($seleciona_clientes);
$totalRows_seleciona_clientes = mysql_num_rows($seleciona_clientes);

mysql_select_db($database_conn, $conn);
$query_seleciona_fornecedores = "SELECT * FROM fornecedores";
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

<script type="text/javascript">

		  
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

</script>



</head>

<body>

<table width="100%"  border="0" align="center" cellpadding="0" cellspacing="2">
    <tr>
      <th width="40"><img src="../imagens/campainha.png" alt="" width="30" height="30" align="absmiddle" /></th>
      <th width="878" class="Titulo16">CADASTRAR RESERVAS:</th>
      <th width="108" class="Titulo16"><a href="#" onclick="closeMessage()"><img src="../imagens/botao_fechar.png" width="25" height="25" alt="fechar" /></a></th>
    </tr>
</table>
  <hr align="center" width="100%" style="border:0;border-top:1px dashed #CECBBD;height:1px;clear:both">
<table width="100%">
  <tr>
    <td>
      <form action="<?php echo $editFormAction; ?>" method="post" name="form1_cadreservas" id="form1">
        <table width="100%" align="center">
          <tr valign="baseline">
            <td nowrap="nowrap" align="right">FORNECEDOR:</td>
            <td><select name="id_fornecedor" id="id_fornecedor">
              <option value=""></option>
              <?php
do {  
?>
              <option value="<?php echo $row_seleciona_fornecedores['id']?>"><?php echo $row_seleciona_fornecedores['nome']?></option>
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
            <td><input name="id_reserva" type="text" id="id_reserva" value="" size="44" /></td>
          </tr>
          <tr valign="baseline">
            <td align="right" nowrap="nowrap">DATA DA RESERVA:</td>
            <td><input name="data_reserva" type="text" id="data_reserva" value="<?php echo date('d/m/Y h:i A'); ?>" size="44" /></td>
          </tr>
          <tr valign="baseline">
            <td align="right" nowrap="nowrap">NOME DO CLIENTE:</td>
            <td><select name="id_cliente" id="id_cliente">
              <option value=""></option>
              <?php
do {  
?>
              <option value="<?php echo $row_seleciona_clientes['id']?>"><?php echo $row_seleciona_clientes['nome']?></option>
              <?php
} while ($row_seleciona_clientes = mysql_fetch_assoc($seleciona_clientes));
  $rows = mysql_num_rows($seleciona_clientes);
  if($rows > 0) {
      mysql_data_seek($seleciona_clientes, 0);
	  $row_seleciona_clientes = mysql_fetch_assoc($seleciona_clientes);
  }
?>


            </select>   <a href=# onClick=displayMessage('../clientes/cadastrar.php','800','600')><font color=black><b> +</b></font> </a> </td>
          </tr>
          <tr valign="baseline">
            <td align="right" nowrap="nowrap">NOME DO HOSPEDE:</td>
            <td><input name="hospede" type="text" id="hospede" value="" size="44" onkeyup="maiuscula(this.value)"  /></td>
          </tr>
          <tr valign="baseline">
            <td align="right" nowrap="nowrap">DATA DE CHEGADA:</td>
            <td><input name="chegada" type="date" id="chegada" value="" size="44" /></td>
          </tr>
          <tr valign="baseline">
            <td align="right" nowrap="nowrap">DATA DE SAIDA:</td>
            <td><input name="saida" type="date" id="saida" value="" size="44" /></td>
          </tr>
          <tr valign="baseline">
            <td align="right" nowrap="nowrap">NUMERO DE NOITES:</td>
            <td><input name="n_noites" type="number" id="n_noites" value="" size="44" onclick="numero_noites()" /></td>
          </tr>
          <tr valign="baseline">
            <td align="right" nowrap="nowrap">QTD DE PAX:</td>
            <td><input name="qtd_pass" type="number" id="qtd_pass" value="" size="44" /></td>
          </tr>
          <tr valign="baseline">
            <td align="right" nowrap="nowrap">NOME APT:</td>
            <td><select tabindex="7" name="id_quarto" id="id_quarto">
              <option value=""></option>
              <?php
do {  
?>
              <option value="<?php echo $row_seleciona_quartos['id']?>"><?php echo $row_seleciona_quartos['nome']?></option>
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
            <td align="right" nowrap="nowrap">VALOR DA RESERVA:</td>
            <td><input name="valor_reserva" type="text" id="valor_reserva" value="" size="20"  onKeyUp="maskIt(this,event,'###.###.###,##',true)" dir="rtl"/></td>
          </tr>
          <tr valign="baseline">
            <td align="right" nowrap="nowrap">FORMA DE PAGAMENTO:</td>
            <td><select name="formadepagamento" id="formadepagamento">
              <option>Escolha a Forma de Pagamento</option>
              <option value="E">Especie</option>
              <option value="C">Cartao</option>
              <option value="B">Boleto Bancario</option>
              <option value="D">Deposito</option>
            </select></td>
          </tr>
          <tr valign="baseline">
            <td align="right" nowrap="nowrap">CAFÉ DA MANHA:</td>
            <td><label>
              <input name="cafedamanha" type="radio" id="tipo_0" value="S" checked="checked" />
              SIM
            </label>
              <label>
                <input type="radio" name="cafedamanha" value="N" id="tipo_1" />
            NÃO</label></td>
          </tr>
          <tr valign="baseline">
            <td align="right" nowrap="nowrap">VALOR ADIANTADO:</td>
            <td><input name="valor_retido" type="text" id="valor_retido"  value="" size="20" onKeyUp="maskIt(this,event,'###.###.###,##',true)" dir="rtl"/></td>
          </tr>
          <tr valign="baseline">
            <td align="right" nowrap="nowrap">COBRAR NO CHECKIN:</td>
            <td><input name="cobro_adiantamento" type="text" id="cobro_adiantamento"  onclick="soma_adiantado()" value="" size="20" onblur="maskIt(this,event,'###.###.###,##',true)" dir="rtl" /></td>
          </tr>
          
          <tr>
               <td  align="right" nowrap="nowrap">FORMA DE PAGAMENTO NO CHECK IN:</td>
               <td><select name="formadepagamento_checkin" id="formadepagamento_checkin">
              <option>Escolha a Forma de Pagamento</option>
              <option value="E">Especie</option>
              <option value="C">Cartao</option>
              <option value="B">Boleto Bancario</option>
              <option value="D">Deposito</option>
            </select></td>
          </tr>
          <tr valign="baseline">
            <td align="right" nowrap="nowrap">STATUS:</td>
            
            <td><select name="status" id="status">
            <option></option>
              <option value="RESERVADO">RESERVADO</option><option value="PRE RESERVADO">PRE RESERVADO</option>
				<option value="EM MANUTENCAO">EM MANUTENÇÃO</option>
			
			
                  <option value="HOSPEDADO">HOSPEDADO</option>
                  <option value="LIMPAR">LIMPAR</option>
                  
                 <option value="CANCELADO">CANCELADO</option>
        </select></td>
          </tr>
          <tr valign="baseline">
            <td align="right" nowrap="nowrap">OBSERVAÇÕES:</td>
            <td><textarea name="observacoes" cols="44" id="observacoes" onkeyup="maiuscula(this.value)"></textarea></td>
          </tr>
          <tr valign="baseline">
            <td nowrap="nowrap" align="right">&nbsp;</td>
            <td><input type="submit" value="Cadastrar" />
            <input type="button" class="btn1" onclick="closeMessage()" value="Cancelar" /></td>
          </tr>
        </table>
        <input type="hidden" name="MM_insert" value="form1" />
        <input type="hidden" name="usuario" value="<?php echo $_SESSION['MM_Username'];?>" />
        
      </form>
   </td>
  </tr>
</table>

<script language='JavaScript' type='text/javascript'>
  document.form1_cadreservas.fornecedor.focus()
  
</script>
<script>


function maiuscula(valor) {
var campo=document.form1_cadreservas;
campo.fornecedor.value=campo.fornecedor.value.toUpperCase();
campo.hospede.value=campo.hospede.value.toUpperCase();
campo.local_realocado.value=campo.local_realocado.value.toUpperCase();
campo.observacoes.value=campo.observacoes.value.toUpperCase();



}


</script>
</body>
</html>
