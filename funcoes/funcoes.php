<?php
ob_start();

function tirapontovirgula($valor){
	
$valor = str_replace("." , "" , $valor ); // Primeiro tira os pontos
$valor = str_replace("," , "" , $valor); // Depois tira a vírgula

return "$valor";	
}


function databrasil($data){
	
	//2011/12/12
	//0123456789
	
	$novadata = substr($data,8,2)."/".substr($data,5,2)."/".substr($data,0,4);
	return $novadata;
}


function datausa($data){
	
	//12/12/2011
	//0123456789
	
	$novadata = substr($data,6,4)."/".substr($data,3,2)."/".substr($data,0,2);
	return $novadata;
}


function virgula($valor) { 
$conta = strlen ($valor);
    switch ($conta) {
        case "1":
            $retorna = "0,0$valor";
            break;
        case "2":
            $retorna = "0,$valor";
            break;
        case "3":
            $d1 = substr("$valor",0,1);
            $d2 = substr("$valor",-2,2);
            $retorna = "$d1,$d2";
            break;
        case "4":
            $d1 = substr("$valor",0,2);
            $d2 = substr("$valor",-2,2);
            $retorna = "$d1,$d2";
            break;
        case "5":
            $d1 = substr("$valor",0,3);
            $d2 = substr("$valor",-2,2);
            $retorna = "$d1,$d2";
            break;
        case "6":
            $d1 = substr("$valor",1,3);
            $d2 = substr("$valor",-2,2);
            $d3 = substr("$valor",0,1);
            $retorna = "$d3.$d1,$d2";
            break;
        case "7":
            $d1 = substr("$valor",2,3);
            $d2 = substr("$valor",-2,2);
            $d3 = substr("$valor",0,2);
            $retorna = "$d3.$d1,$d2";
            break;
        case "8":
            $d1 = substr("$valor",3,3);
            $d2 = substr("$valor",-2,2);
            $d3 = substr("$valor",0,3);
            $retorna = "$d3.$d1,$d2";
            break;
    } 
return $retorna; 
} 

function validaCPF($cpf)
{	// Verifiva se o número digitado contém todos os digitos
    $cpf = str_pad(ereg_replace('[^0-9]', '', $cpf), 11, '0', STR_PAD_LEFT);
	
	// Verifica se nenhuma das sequências abaixo foi digitada, caso seja, retorna falso
    if (strlen($cpf) != 11 || $cpf == '00000000000' || $cpf == '11111111111' || $cpf == '22222222222' || $cpf == '33333333333' || $cpf == '44444444444' || $cpf == '55555555555' || $cpf == '66666666666' || $cpf == '77777777777' || $cpf == '88888888888' || $cpf == '99999999999')
	{
	return false;
    }
	else
	{   // Calcula os números para verificar se o CPF é verdadeiro
        for ($t = 9; $t < 11; $t++) {
            for ($d = 0, $c = 0; $c < $t; $c++) {
                $d += $cpf{$c} * (($t + 1) - $c);
            }

            $d = ((10 * $d) % 11) % 10;

            if ($cpf{$c} != $d) {
                return false;
            }
        }

        return true;
    }
}
// Verifica se o botão de validação foi acionado
if(isset($_POST['btvalidar']))
	{// Adiciona o numero enviado na variavel $cpf_enviado, poderia ser outro nome, e executa a função acima
	$cpf_enviado = validaCPF($_POST['cpf']);
	// Verifica a resposta da função e exibe na tela
	if($cpf_enviado == true)
		echo "CPF VERDADEIRO";
	elseif($cpf_enviado == false)
		echo "CPF FALSO";
	}

?>