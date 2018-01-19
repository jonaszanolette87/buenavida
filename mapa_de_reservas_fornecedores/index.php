<?php require_once('../Connections/conn.php'); ?>



<link rel="stylesheet" href="../funcoes/modal-message/modal-message.css" type="text/css">
<script type="text/javascript" src="../funcoes/modal-message/ajax.js"></script>
<script type="text/javascript" src="../funcoes/modal-message/modal-message.js"></script>
<script type="text/javascript" src="../funcoes/modal-message/ajax-dynamic-content.js"></script>

<script type="text/javascript">
messageObj = new DHTML_modalMessage();	// We only create one object of this class
messageObj.setShadowOffset(5);	// Large shadow


function displayMessage(url,xx,yy)
{
	messageObj.setSource(url);
	messageObj.setCssClassMessageBox(false);
	messageObj.setSize(xx,yy);
	messageObj.setShadowDivVisible(false);	// Enable shadow for these boxes
	messageObj.display();

}

function closeMessage()
{
	messageObj.close();	

}


</script>


<?php 
//SELECIONA TODOS OS QUARTOS 
mysql_select_db($database_conn, $conn);
$query_seleciona_quartos = "SELECT q.*, f.nome as fornecedor FROM quartos q

LEFT JOIN fornecedores f 
ON q.id_fornecedor = f.id

 ORDER BY q.id ASC";
$seleciona_quartos = mysql_query($query_seleciona_quartos, $conn) or die(mysql_error());
$row_seleciona_quartos = mysql_fetch_assoc($seleciona_quartos);	 
$qtd_quartos = mysql_num_rows($seleciona_quartos);
	 
?>

<?php 

//define o mes
if ( isset($_GET['mes']) )   { $mes = $_GET['mes']; }

else  $mes  = date("m");  

//defini ano

        if (isset($_GET['ano']))  {

         $ano = $_GET['ano'];

         }
         else {
	$ano = date("Y");
               }
	
	//DEFINI OS DIAS DO MES 
	$num_dias_do_mes = cal_days_in_month(CAL_GREGORIAN, $mes , $ano);
	
?>

<script language="javascript" type="text/javascript" >
function jumpto(x){

if (document.form1.jumpmenu.value != "null") {
	document.location.href = x
	}
}
</script>

<style type="text/css">
body table tbody td a{
	color: #FFF;
	font-size: 8px;
}
</style>


<!-- MOSTRA OS MESES  COM O ANO  -->
<table width="100%" border="1"  style="border-collapse: collapse;" id="MyTable">
  <tbody>
  <tr><td colspan="31">
  
   
<form name="form1">
<select name="jumpmenu" onChange="jumpto(document.form1.jumpmenu.options[document.form1.jumpmenu.options.selectedIndex].value)">
<option>Ano...</option>
<option value=principal.php?t=mapa_de_reservas&ano=2015>2015</option>
<option value=principal.php?t=mapa_de_reservas&ano=2016>2016</option>
<option value=principal.php?t=mapa_de_reservas&ano=2017>2017</option>

</select>
</form>



  </td> </tr>
  
  <?php if (isset($_GET['ano'])) 
  
  {
	  $ano = $_GET['ano'];
	  }?>
  <tr>
  <th colspan="31" align="center" valign="middle"> 
    <a href="principal.php?t=mapa_de_reservas&mes=01&ano=<?php echo $ano;?>">JANEIRO</a> -
      <a href="principal.php?t=mapa_de_reservas&mes=02&ano=<?php echo $ano;?>">FEVEREIRO</a> - 
      <a href="principal.php?t=mapa_de_reservas&mes=03&ano=<?php echo $ano;?>">MARÇO</a> - 
      <a href="principal.php?t=mapa_de_reservas&mes=04&ano=<?php echo $ano;?>">ABRIL</a> - 
      <a href="principal.php?t=mapa_de_reservas&mes=05&ano=<?php echo $ano;?>">MAIO</a> - 
      <a href="principal.php?t=mapa_de_reservas&mes=06&ano=<?php echo $ano;?>">JUNHO</a> - 
      <a href="principal.php?t=mapa_de_reservas&mes=07&ano=<?php echo $ano;?>">JULHO</a> - 
      <a href="principal.php?t=mapa_de_reservas&mes=08&ano=<?php echo $ano;?>">AGOSTO</a> - 
      <a href="principal.php?t=mapa_de_reservas&mes=09&ano=<?php echo $ano;?>">SETEMBRO</a> - 
      <a href="principal.php?t=mapa_de_reservas&mes=10&ano=<?php echo $ano;?>">OUTUBRO</a> - 
      <a href="principal.php?t=mapa_de_reservas&mes=11&ano=<?php echo $ano;?>">NOVEMBRO</a> - 
      <a href="principal.php?t=mapa_de_reservas&mes=12&ano=<?php echo $ano;?>">DEZEMBRO</a> </th>
  </tr>
  <tr>
    <td colspan="31" ><br>
      <?php $nome_mes = $_GET['mes']; switch ($mes) {  
	case '1': echo "Janeiro/".$ano;break; 
	case '2': echo "Fevereiro/".$ano;break; 
	case '3': echo "Março/".$ano;break; 
	case '4': echo "Abril/".$ano;break; 
	case '5': echo "Maio/".$ano;break; 
	case '6': echo "Junho/".$ano;break; 
	
	case '7': echo "Julho/".$ano;break; 
	case '8': echo "Agosto/".$ano;break; 
	case '9': echo "Setembro/".$ano;break; 
	case '10': echo "Outubro/".$ano;break; 
	case '11': echo "Novembro/".$ano;break; 
	case '12': echo "Dezembro/".$ano;break; 
	
	
	}
	
	?>
      <br>
      <br></td>
  </tr>
    <tr bgcolor="#D6D6D6">
      <td width="10%">MAPA</td>
      
      <?php 
	   //comeca a digitar o cabecalho do tabela do mes 
	  for($num_dia=1;$num_dia<=$num_dias_do_mes;$num_dia++) { 
	  
	  
	  //acrescenta o zero a esquerda se tiver apenas um carater no dia 
	  if (strlen($num_dia)==1){
	  $num_dia = "0". $num_dia;
	  }
	  
	  echo "<td width=1%>".$num_dia."/".$mes." </td>";
	  }
	  ?>
      
      
    </tr>
    
    
    <?php 
	
	// verifica se o mes esta setado senao mostra o mes atual 
if ( isset($_GET['mes']) ) { $mes = $_GET['mes']; }

else  $mes  = date("m");  
	
	
	
	//pega o numero de dias do mes atual 
	$num_dias_do_mes = cal_days_in_month(CAL_GREGORIAN, $mes , $ano);
	
	
	
	?>
    <?php 	
	
	
	do { ?>
    
    <tr>
    <!-- crias as linhas de acordo com a quantidade de apartamentos  -->
           
        <td width='5%'
        <?php if ($row_seleciona_quartos['fornecedor']=='BOOKING')       {echo "bgcolor='#399962'"; }
		else if ($row_seleciona_quartos['fornecedor']=='DECOLAR')        {echo "bgcolor='#422663'";}
		else if ($row_seleciona_quartos['fornecedor']=='BALCAO')         {echo "bgcolor='#FFBB00'";}
		else if ($row_seleciona_quartos['fornecedor']=='EXPEDIA')        {echo "bgcolor='#00BBBB'";}
		else if ($row_seleciona_quartos['fornecedor']=='ALUGUE TEMPORADA'){echo "bgcolor='#A0BB00'";}
		
		

		?>> <?php echo "<b>".$row_seleciona_quartos['nome']."</b>";?></td>
           
       <?php 
	   
	   //cria a linha dos 30 dias do mes 
	   
	  for($num_dia=1;$num_dia<=$num_dias_do_mes;$num_dia++) { 
	  
	   //acrescenta o zero a esquerda se tiver apenas um carater no dia 
	  if (strlen($num_dia)==1){
	  
	  $num_dia = "0". $num_dia;
	  
	  //mes  ???
	  //ano  ???
	  }	  
	  
	//  mysql_select_db($database_conn, $conn);


//$query_seleciona_status = "SELECT status, chegada, saida, n_noites,id_quarto FROM reservas  WHERE id_quarto=".$row_seleciona_quartos['id']."  
//AND chegada = '".$ano."-".$mes."-".$num_dia."'";
//$seleciona_status = mysql_query($query_seleciona_status, $conn) or die(mysql_error());
//$row_seleciona_status = mysql_fetch_assoc($seleciona_status);	


  mysql_select_db($database_conn, $conn);



$query_seleciona_status_dias = "SELECT  rd.dia as dia, rd.status as status, rd.id_reserva as id_reserva, f.nome as fornecedor 
FROM reservas_dias rd

LEFT JOIN reservas r
ON rd.id_reserva = r.id

LEFT JOIN fornecedores f
ON r.id_fornecedor= f.id

WHERE rd.id_quarto=".$row_seleciona_quartos['id']."  AND dia = '".$ano."-".$mes."-".$num_dia."'";
$seleciona_status_dias = mysql_query($query_seleciona_status_dias, $conn) or die(mysql_error());
$row_seleciona_status_dias = mysql_fetch_assoc($seleciona_status_dias);	

//verifica qual o status   a data para  pintar 

if      (($row_seleciona_status_dias['fornecedor'] == 'BOOKING')   && ($row_seleciona_status_dias['dia'] == $ano."-".$mes."-".$num_dia)) { $cor="#399962"; $qtd_booking = $qtd_booking + 1;}

else if (($row_seleciona_status_dias['fornecedor'] == 'DECOLAR')   && ($row_seleciona_status_dias['dia'] == $ano."-".$mes."-".$num_dia)) { $cor="#422663"; $qtd_decolar = $qtd_decolar + 1;}

else if (($row_seleciona_status_dias['fornecedor'] == 'BALCAO')    && ($row_seleciona_status_dias['dia'] == $ano."-".$mes."-".$num_dia)) { $cor="#FF8080"; $qtd_balcao = $qtd_balcao + 1;}

else if (($row_seleciona_status_dias['fornecedor'] == 'EXPEDIA')   && ($row_seleciona_status_dias['dia'] == $ano."-".$mes."-".$num_dia)) { $cor="#F0E634"; $qtd_expedia = $qtd_expedia + 1;}

else if (($row_seleciona_status_dias['fornecedor'] == 'ALUGUE TEMPORADA') && ($row_seleciona_status_dias['dia'] == $ano."-".$mes."-".$num_dia)) { $cor="#0000BB"; $qtd_aluga_temporada = $qtd_aluga_temporada + 1;}

else if (($row_seleciona_status_dias['fornecedor'] == 'HOTEL URBANO')    && ($row_seleciona_status_dias['dia'] == $ano."-".$mes."-".$num_dia)) { $cor="#FF7900"; $qtd_hotel_urbano = $qtd_hotel_urbano + 1;}

else if (($row_seleciona_status_dias['fornecedor'] == '')    && ($row_seleciona_status_dias['dia'] == $ano."-".$mes."-".$num_dia)) { $cor="#aaaaaa"; $qtd_sem_fornecedor = $qtd_sem_fornecedor + 1;}




//else if (($row_seleciona_status_dias['status'] == 'RESERVADO')    && ($row_seleciona_status_dias['dia'] == $ano."-".$mes."-".$num_dia)) { $cor="#FF0000"; $qtd_reservados = $qtd_reservados + 1;}
//else if (($row_seleciona_status_dias['status'] == 'EM MANUTENCAO') && ($row_seleciona_status_dias['dia'] == $ano."-".$mes."-".$num_dia)) { $cor="#255E00"; $qtd_manutencao = $qtd_manutencao + 1;}
//else if (($row_seleciona_status_dias['status'] == 'HOSPEDADO') 	   && ($row_seleciona_status_dias['dia'] == $ano."-".$mes."-".$num_dia)) { $cor="#3560A9"; $qtd_hospedado = $qtd_hospedado + 1; }
//else if (($row_seleciona_status_dias['status'] == 'PRE RESERVADO') && ($row_seleciona_status_dias['dia'] == $ano."-".$mes."-".$num_dia)) { $cor="#6F6F6F"; $qtd_prereservados =$qtd_prereservados +1;}
//else if (($row_seleciona_status_dias['status'] == 'GOVERNANCA')    && ($row_seleciona_status_dias['dia'] == $ano."-".$mes."-".$num_dia)) { $cor="#88ABD9"; $qtd_governanca  = $qtd_governanca + 1; }
//else if (($row_seleciona_status_dias['status'] == 'LIMPAR')     && ($row_seleciona_status_dias['dia'] == $ano."-".$mes."-".$num_dia)) { $cor="#000000"; $qtd_limpar= $qtd_limpar + 1;}


else {    $cor="#444444";

$qtd_livre= $qtd_livre + 1;}
	  
	  if($cor =='#ffffff'){
		  
		  
		   echo "<td width=2% bgcolor=".$cor.">  
	

	 <a href=#   onClick=displayMessage('../reservas/cadastrar.php?mapa=s&apt=". $row_seleciona_quartos['id']."&chegada=". $ano."-".$mes."-".$num_dia."','1100','750');return false>". $row_seleciona_quartos['id']."</a>


	
 
	 
	 </td>";}
	  
	  else {
	
     echo "<td width=1% bgcolor=".$cor.">  
	 
	 <a href=#  onClick=displayMessage('../reservas/alterar.php?mapa=s&id=". $row_seleciona_status_dias['id_reserva']."','1100','750');return false>Id:". $row_seleciona_status_dias['id_reserva'] ."-".substr($row_seleciona_status_dias['fornecedor'],0,2)."</a>
	 

	 
	 
	 </td>";
	 

	 
	  }
	 
	 
	 
	  }
	  
	  ?>
      
     
    </tr>
    
    
  
    
    <?php } while ($row_seleciona_quartos = mysql_fetch_assoc($seleciona_quartos)); ?>
    
    
    
  </tbody>
</table>

<br>
<table width="100%" border="1">
  <tbody>
  
  <tr><td><a  href="../inicio/principal.php?t=mapa_de_reservas_fornecedores" >Fornecedores</a></td>

<!-- FORNECEDORES -->


  <td bgcolor="#399962">&nbsp;</td>
  
  <td>BOOKING <?php $percentual_booking =  ceil(($qtd_booking/($qtd_quartos*$num_dias_do_mes))*100);
	  echo $percentual_booking."%";

    echo " - ".$qtd_booking;
	  ?> </td>
  <td bgcolor="#422663">&nbsp;</td>
  
  <td>DECOLAR <?php $percentual_decolar =  ceil(($qtd_decolar/($qtd_quartos*$num_dias_do_mes))*100);
	  echo $percentual_decolar."%";

    echo " - ".$qtd_decolar;
	  ?></td>
  
  <td bgcolor="#F0E634">&nbsp;</td>
  <td>EXPEDIA <?php $percentual_expedia =  ceil(($qtd_expedia/($qtd_quartos*$num_dias_do_mes))*100);
	  echo $percentual_expedia."%";

    echo " - ".$qtd_expedia;
	  ?></td>
  <td bgcolor="#0000BB">&nbsp;</td>
  <td>ALUGUE TEMPORADA <?php $percentual_aluga_temporada =  ceil(($qtd_aluga_temporada/($qtd_quartos*$num_dias_do_mes))*100);
	  echo $percentual_aluga_temporada."%";

    echo " - ".$qtd_aluga_temporada;
	  ?></td>
  <td bgcolor="#FFBB00">&nbsp;</td>
  <td>BALCAO/SITE/TELEFONE <?php $percentual_balcao =  ceil(($qtd_balcao/($qtd_quartos*$num_dias_do_mes))*100);
	  echo $percentual_balcao."%";

    echo " - ".$qtd_balcao;
	  ?></td>
  <td bgcolor="#FF7900">&nbsp;</td>
  <td>HOTEL URBANO <?php $percentual_hotel_urbano =  ceil(($qtd_hotel_urbano/($qtd_quartos*$num_dias_do_mes))*100);
	  echo $percentual_hotel_urbano."%";

    echo " - ".$qtd_hotel_urbano;
	  ?></td>
  <td>&nbsp;</td><td>&nbsp;</td>
  </tr>
    <tr>
      <td width="1%" bgcolor="#FFFFFF">Status</td>
      <td width="1%" bgcolor="#FFFFFF">&nbsp;</td>
      <td width="8%">LIVRE <?php $percentual_livre =  ceil(($qtd_livre/($qtd_quartos*$num_dias_do_mes))*100);
	  echo $percentual_livre."%";
	  
	   echo " - ".$qtd_livre;
	  ?></td>
      <td width="2%" bgcolor="#FF0000">&nbsp;</td>
      <td width="8%">RESERVADO <?php $percentual_reservado =  ceil(($qtd_reservados/($qtd_quartos*$num_dias_do_mes))*100);
	  echo $percentual_reservado."%";
	  
	  echo " - ".$qtd_reservados;
	  ?></td>
      <td width="2%" bgcolor="#6F6F6F">&nbsp;</td>
      <td width="8%">PRE RESERVADO <?php $percentual_prereservado =  ceil(($qtd_prereservados/($qtd_quartos*$num_dias_do_mes))*100);
	  echo $percentual_reservado."%";
	   echo " - ".$qtd_prereservados;
	  ?></td>
      <td width="2%" bgcolor="#255E00">&nbsp;</td>
      <td width="8%">EM MANUTENÇÃO <?php $percentual_manutencao =  ceil(($qtd_manutencao/($qtd_quartos*$num_dias_do_mes))*100);
	  echo $percentual_manutencao."%";
	   echo " - ".$qtd_manutencao;
	  ?></td>
      <td width="2%" bgcolor="#3560A9">&nbsp;</td>
      <td width="9%">HOSPEDADO <?php $percentual_hospedado =  ceil(($qtd_hospedado/($qtd_quartos*$num_dias_do_mes))*100);
	  echo $percentual_hospedado."%";
	   echo " - ".$qtd_hospedado;
	  ?></td>
      <td width="2%" bgcolor="#000000">&nbsp;</td>
      <td width="8%">LIMPAR <?php $percentual_limpar =  ceil(($qtd_limpar/($qtd_quartos*$num_dias_do_mes))*100);
	  echo $percentual_limpar."%";
	  echo " - ".$qtd_limpar;
	  ?></td>
      <td width="2%">&nbsp;</td>
      <td width="14%">&nbsp;</td>
    </tr>
  </tbody>
</table>
