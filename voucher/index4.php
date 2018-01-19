<?php

include("../Connections/conn.php");
include("../funcoes/funcoes.php");
// busca os dados no banco de dados



mysql_select_db($database_conn, $conn);
$query_seleciona_reservas = "SELECT r.*, c.nome as nomecliente, c.email as emailcliente , c.datanascimento as datanascimento,
c.cpf as cpf, c.rg as rg,c.passaporte as passaporte ,c.endereco as endereco, c.complemento as complemento, c.bairro as bairro,
c.cidade as cidade, c.uf as uf, c.pais as pais, c.fone1 as fone1, c.fone2 as fone2, q.nome as apartamento FROM reservas r


LEFT JOIN clientes c
ON r.id_cliente = c.id

LEFT JOIN quartos q
ON r.id_quarto = q.id

WHERE r.id = ".$_GET['ID'];
$seleciona_reservas = mysql_query($query_seleciona_reservas, $conn) or die(mysql_error());
$row_seleciona_reservas = mysql_fetch_assoc($seleciona_reservas);


?>
   <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<style type="text/css">
body,td,th {
	font-size: 14px;
	font-family: Cambria, "Hoefler Text", "Liberation Serif", Times, "Times New Roman", serif;
}
</style>

  <table width="659" cellpadding="5" cellspacing="2" style="border: 1px solid #444;">
    <tbody>
      <tr>
        <td width="32%"><strong><img src="../imagens/logomarca-pnsf.png" width="319" height="119" alt=""/></strong></td>
        <td><p>RUA CARLOS RIBEIRO, Nº 7, <br />
          BAIRRO DE FÁTIMA | CEP 60.040-420 <br />
          FORTALEZA | CEARÁ | BRASIL <br />
          FONES: +55 (85) 3077.2727 | 99988-6869</p>
        <h2>FICHA CADASTRAL</h2></td>
      </tr>
      <tr>
        <td colspan="2"><br>
          NOME :   <strong><?php if(!isset($row_seleciona_reservas['nomecliente'])){echo $row_seleciona_reservas['hospede'];}

          else { echo $row_seleciona_reservas['nomecliente'];} ?></strong><br>
          <br>
          E-MAIL :   <strong><?php echo $row_seleciona_reservas['emailcliente']; ?></strong> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;DATA DE NASCIMENTO : <strong><?php echo databrasil($row_seleciona_reservas['datanascimento']); ?></strong><br>
          <br>
          CPF : <strong><?php echo $row_seleciona_reservas['cpf']; ?></strong> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;RG : <strong><?php echo $row_seleciona_reservas['rg']; ?></strong> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;PASSAPORTE :<strong><?php echo $row_seleciona_reservas['passaporte']; ?></strong><br>
          <br>
          ENDEREÇO:<strong><?php echo $row_seleciona_reservas['endereco']; ?></strong> &nbsp;&nbsp;&nbsp;NUMERO:<strong><?php echo $row_seleciona_reservas['numero']; ?></strong> &nbsp;&nbsp;&nbsp;&nbsp;CEP:<strong><?php echo $row_seleciona_reservas['cep']; ?></strong> &nbsp;&nbsp;&nbsp;&nbsp;COMPLEMENTO :<strong><?php echo $row_seleciona_reservas['complemento']; ?></strong><br>
          <br>
          BAIRRO :<strong><?php echo $row_seleciona_reservas['bairro']; ?></strong> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;CIDADE :<strong><?php echo $row_seleciona_reservas['cidade']; ?></strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;UF :<strong><?php echo $row_seleciona_reservas['uf']; ?>
          </strong> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;PAÍS :<strong><?php echo $row_seleciona_reservas['pais']; ?></strong><br>
          <br>
          TELEFONE :<strong><?php echo $row_seleciona_reservas['fone1']; ?></strong> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;CELULAR :<strong><?php echo $row_seleciona_reservas['fone2']; ?></strong> 
        <h5>&nbsp;</h5>
        <strong><center>INFORMAÇÕES VOUCHER</center></strong></td>
      </tr>
      <tr>
        <td colspan="2" align="center"><strong>CHECK-IN (CHEGADA) : <?php echo databrasil($row_seleciona_reservas['chegada']); ?>  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;CHECK-OUT: <?php echo databrasil($row_seleciona_reservas['saida']); ?></strong></td>
        </tr>
      <tr>
        <td colspan="2"><p>APARTAMENTO : <strong><?php echo $row_seleciona_reservas['apartamento']; ?></strong></p></td>
      </tr>
      <tr>
        <td colspan="2">NÚMEROS DE PESSOAS NO QUARTO : <strong><?php echo $row_seleciona_reservas['qtd_pass']; ?> </strong> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;NUMERO DE NOITES <strong>:<?php echo $row_seleciona_reservas['n_noites']; ?></strong></td>
      </tr>
      <tr>
        <td colspan="2">TARIFA: BOOKING(<?php if($row_seleciona_reservas['id_fornecedor']=='2'){echo "<b>X</b>" ;}?>)  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;DECOLAR(
        <?php if($row_seleciona_reservas['id_fornecedor']=='1'){echo "<b>X</b>" ;}?>)  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;BALCÃO(
        <?php if($row_seleciona_reservas['id_fornecedor']=='6'){echo "<b>X</b>" ;}?>)  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;OUTROS : _______________________________________</td>
      </tr>
      <tr>
        <td colspan="2">VALOR TOTAL R$ : <strong><?php echo $row_seleciona_reservas['valor_reserva']; ?> </strong> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;VALOR ADIANTADO: <strong><?php echo $row_seleciona_reservas['valor_retido']; ?></strong>   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;VALOR A COBRAR:<strong> <?php echo $row_seleciona_reservas['cobro_adiantamento']; ?></strong></td>
      </tr>
      <tr>
        <td colspan="2">FORMA DE PAGAMENTO : ESPÉCIE :(<?php if($row_seleciona_reservas['formadepagamento']=='E'){echo "<b>X</b>" ;}?>)  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;CARTÃO :(
          <?php if($row_seleciona_reservas['formadepagamento']=='C'){echo "<b>X</b>" ;}?>
          )  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;DEPÓSITO BANCÁRIO :(
<?php if($row_seleciona_reservas['formadepagamento']=='D'){echo "<b>X</b>" ;}?>
          )  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;BOLETO BANCÁRIO :(
          <?php if($row_seleciona_reservas['formadepagamento']=='B'){echo "<b>X</b>" ;}?>
          )  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;OUTROS :(
        <?php if($row_seleciona_reservas['formadepagamento']=='O'){echo "<b>X</b>" ;}?>        )  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;OUTROS : _______________________________________</td>
      </tr>
      <tr>
        <td colspan="2">CAFÉ DA MANHÃ INCLUSO : ( <?php if($row_seleciona_reservas['cafedamanha']=='S'){echo "<b>X</b>" ;}?>)SIM  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(
<?php if($row_seleciona_reservas['cafedamanha']=='N'){echo "<b>X</b>" ;}?>)NÃO </td>
      </tr>
      <tr>
        <td colspan="2" valign="top"><center>
OUTRAS INFORMAÇÕES:          <br>
<br>
<strong><?php echo $row_seleciona_reservas['observacoes']; ?></strong><br /><?php echo "usuario:".substr($row_seleciona_reservas['usuario'],0,4)?>
<br>
<br>
               
        </center>
       </td>
      </tr>
      
    </tbody>
  </table>

