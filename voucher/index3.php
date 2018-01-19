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

  <table width="659" style="border: 1px solid #444;">
    <tbody>
      <tr>
        <td width="32%"><strong><img src="../imagens/logomarca-pnsf.png" width="195" height="56" alt=""/></strong></td>
        <td align="center" valign="middle" bgcolor="#006699"><h2>FICHA DE HÓSPEDE</h2></td>
      </tr>
      <tr>
        <td colspan="2" bgcolor="#006699"><blockquote>
          <blockquote>
            <blockquote>
              <blockquote>
                <blockquote>
                  <blockquote>
                    <p><strong>
                      <center>
                        Apartamento de N 
                      <strong><?php echo $row_seleciona_reservas['apartamento']; ?></strong>
                      </center>
                    </strong></p>
                  </blockquote>
                </blockquote>
              </blockquote>
            </blockquote>
          </blockquote>
        </blockquote></td>
      </tr>
      <tr>
        <td colspan="2"> Nome do Hóspede: <strong>
        <?php if(!isset($row_seleciona_reservas['nomecliente'])){echo $row_seleciona_reservas['hospede'];}

          else { echo $row_seleciona_reservas['nomecliente'];} ?>
</strong></td>
      </tr>
      <tr>
        <td colspan="2">Nacionalidade : <strong><?php echo $row_seleciona_reservas['numero']; ?></strong> Naturalidade <strong>: 
            <?php echo $row_seleciona_reservas['numero']; ?> </strong>UF : <strong><?php echo $row_seleciona_reservas['numero']; ?></strong></td>
      </tr>
      <tr>
        <td colspan="2">Estado Civil :<strong><?php echo $row_seleciona_reservas['numero']; ?> </strong>Profissão:<strong><?php echo $row_seleciona_reservas['numero']; ?></strong></td>
      </tr>
      <tr>
        <td colspan="2">Data de Nascimento :<strong><?php echo databrasil($row_seleciona_reservas['datanascimento']); ?></strong>Telefone:<strong><?php echo $row_seleciona_reservas['fone1']; ?> - <?php echo $row_seleciona_reservas['fone2']; ?></strong></td>
      </tr>
      <tr>
        <td colspan="2">RG :<strong><?php echo $row_seleciona_reservas['rg']; ?></strong>Orgão: <strong><?php echo $row_seleciona_reservas['numero']; ?></strong> UF : <strong><?php echo $row_seleciona_reservas['numero']; ?> </strong>CPF:<strong><?php echo $row_seleciona_reservas['cpf']; ?>&nbsp;&nbsp;&nbsp;</strong>PASSAPORTE :<strong><strong><?php echo $row_seleciona_reservas['passaporte']; ?></strong></strong></td>
      </tr>
      <tr>
        <td colspan="2">Endereco Completo: <strong><?php echo $row_seleciona_reservas['cpf']; ?></strong></td>
      </tr>
      <tr>
        <td colspan="2">Bairro : <strong><?php echo $row_seleciona_reservas['cpf']; ?>  </strong> CEP:<strong> <strong><?php echo $row_seleciona_reservas['cpf']; ?></strong></strong></td>
      </tr>
      <tr>
        <td colspan="2">Cidade : <strong><?php echo $row_seleciona_reservas['cpf']; ?> </strong>UF:<strong> <strong><?php echo $row_seleciona_reservas['cpf']; ?></strong></strong></td>
      </tr>
      <tr>
        <td colspan="2">Pais : <strong><?php echo $row_seleciona_reservas['cpf']; ?></strong> CNPJ:<strong> <strong><?php echo $row_seleciona_reservas['cpf']; ?></strong></strong></td>
      </tr>
      <tr>
        <td colspan="2">E-mail:<strong><?php echo $row_seleciona_reservas['emailcliente']; ?></strong></td>
      </tr>
      <tr>
        <td colspan="2">1  Hospede : <strong><?php echo $row_seleciona_reservas['cpf']; ?></strong> CPF :<strong> <strong><?php echo $row_seleciona_reservas['cpf']; ?></strong></strong></td>
      </tr>
      <tr>
        <td colspan="2">2 Hospede : <strong><?php echo $row_seleciona_reservas['cpf']; ?></strong> CPF : <strong> <strong><?php echo $row_seleciona_reservas['cpf']; ?></strong></strong></td>
      </tr>
      <tr>
        <td colspan="2">3 Hospede : <strong><?php echo $row_seleciona_reservas['cpf']; ?></strong> CPF :<strong> <strong><?php echo $row_seleciona_reservas['cpf']; ?></strong></strong></td>
      </tr>
      <tr>
        <td colspan="2">4 Hospede : <strong><?php echo $row_seleciona_reservas['cpf']; ?></strong> CPF :<strong> <strong><?php echo $row_seleciona_reservas['cpf']; ?></strong></strong></td>
      </tr>
      <tr>
        <td colspan="2">5 Hospede : <strong><?php echo $row_seleciona_reservas['cpf']; ?></strong> CPF :<strong> <strong><?php echo $row_seleciona_reservas['cpf']; ?></strong></strong></td>
      </tr>
      <tr>
        <td colspan="2">6 Hospede : <strong><?php echo $row_seleciona_reservas['cpf']; ?></strong> CPF :<strong> <strong><?php echo $row_seleciona_reservas['cpf']; ?></strong></strong></td>
      </tr>
      <tr>
        <td colspan="2">Empresa : <strong><?php echo $row_seleciona_reservas['cpf']; ?></strong> Contato :<strong> <strong><?php echo $row_seleciona_reservas['cpf']; ?></strong></strong></td>
      </tr>
      <tr>
        <td colspan="2">Endereco completo : <strong><strong><?php echo $row_seleciona_reservas['cpf']; ?></strong></strong></td>
      </tr>
      <tr>
        <td colspan="2">Bairro : <strong><?php echo $row_seleciona_reservas['cpf']; ?></strong> CEP :<strong> <strong><?php echo $row_seleciona_reservas['cpf']; ?></strong></strong></td>
      </tr>
      <tr>
        <td colspan="2">Cidade : <strong><?php echo $row_seleciona_reservas['cpf']; ?></strong> UF :<strong> <strong><?php echo $row_seleciona_reservas['cpf']; ?></strong></strong> Telefone:</td>
      </tr>
      <tr>
        <td colspan="2">Pais : <strong><?php echo $row_seleciona_reservas['cpf']; ?></strong> CNPJ :<strong> <strong><?php echo $row_seleciona_reservas['cpf']; ?></strong></strong></td>
      </tr>
      <tr>
        <td colspan="2">CGF : <strong><?php echo $row_seleciona_reservas['cpf']; ?></strong> Inscricao Municipal :<strong> <strong><?php echo $row_seleciona_reservas['cpf']; ?></strong></strong></td>
      </tr>
      <tr>
        <td colspan="2">E-mail:<strong><?php echo $row_seleciona_reservas['cpf']; ?></strong></td>
      </tr>
      <tr>
        <td colspan="2">Finalidade da Hospedagem : <strong><?php echo $row_seleciona_reservas['cpf']; ?></strong></td>
      </tr>
      <tr>
        <td colspan="2">N de Hospede(s) : <strong><?php echo $row_seleciona_reservas['cpf']; ?></strong> N de Crianca(s) :<strong> <strong><?php echo $row_seleciona_reservas['cpf']; ?></strong></strong> N de cama(s) : <strong><?php echo $row_seleciona_reservas['cpf']; ?></strong> N de Diarias :<strong> <strong><?php echo $row_seleciona_reservas['cpf']; ?></strong></strong></td>
      </tr>
      <tr>
        <td colspan="2">Valor de Hospedagem : <strong><?php echo $row_seleciona_reservas['cpf']; ?></strong> Pago :<strong> <strong><?php echo $row_seleciona_reservas['cpf']; ?> </strong></strong>Total :<strong> <strong><strong><?php echo $row_seleciona_reservas['cpf']; ?></strong></strong></strong></td>
      </tr>
      <tr>
        <td colspan="2">Valor [bebidas alcolicas] : <strong><?php echo $row_seleciona_reservas['cpf']; ?></strong> Valor [bebidas nao alcolicas]<strong> <strong><?php echo $row_seleciona_reservas['cpf']; ?> </strong></strong>Soma[bebidas]:<strong><strong><?php echo $row_seleciona_reservas['cpf']; ?></strong></strong></td>
      </tr>
      <tr>
        <td colspan="2">Valor Consumo de Alimentos: <strong><strong><?php echo $row_seleciona_reservas['cpf']; ?> </strong></strong>Soma[ Bebidas nao alcoolicas+ Alimentos]: <strong><strong><?php echo $row_seleciona_reservas['cpf']; ?></strong></strong></td>
      </tr>
      <tr>
        <td colspan="2">SOMA GERAL [Consumo de Alimentos + Bebidas]:<strong><strong><?php echo $row_seleciona_reservas['cpf']; ?></strong></strong>  Valor Pago:<strong><strong><?php echo $row_seleciona_reservas['cpf']; ?></strong></strong> Valor a Pagar : <strong><strong><?php echo $row_seleciona_reservas['cpf']; ?></strong></strong></td>
      </tr>
      <tr>
        <td colspan="2">Entrada Reservada : <strong><strong><?php echo $row_seleciona_reservas['cpf']; ?></strong></strong> Horario de Entrada Reservada: <strong><strong><?php echo $row_seleciona_reservas['cpf']; ?></strong></strong></td>
      </tr>
      <tr>
        <td colspan="2">Saida Reservada : <strong><strong><?php echo $row_seleciona_reservas['cpf']; ?></strong></strong> Horario de Saida Reservada : <strong><strong><?php echo $row_seleciona_reservas['cpf']; ?></strong></strong></td>
      </tr>
      <tr>
        <td colspan="2">Data de Entrada : <strong><strong><?php echo $row_seleciona_reservas['cpf']; ?></strong></strong> Hora da Entrada: <strong><strong><?php echo $row_seleciona_reservas['cpf']; ?></strong></strong></td>
      </tr>
      <tr>
        <td colspan="2">Data da Saida: <strong><strong><?php echo $row_seleciona_reservas['cpf']; ?></strong></strong> Hora da Saida: <strong><strong><?php echo $row_seleciona_reservas['cpf']; ?></strong></strong></td>
      </tr>
      <tr>
        <td colspan="2" align="center"><strong>CHECK-IN (CHEGADA) : <?php echo databrasil($row_seleciona_reservas['chegada']); ?>  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;CHECK-OUT: <?php echo databrasil($row_seleciona_reservas['saida']); ?></strong></td>
      </tr>
      <tr>
        <td colspan="2"><p>APARTAMENTO :<strong><strong><?php echo $row_seleciona_reservas['apartamento']; ?></strong></strong></p></td>
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

